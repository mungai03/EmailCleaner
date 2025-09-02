<?php

namespace App\Http\Controllers;

use App\Models\EmailSession;
use App\Services\EmailProviderService;
use App\Services\StorageAnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EmailDashboardController extends Controller
{
    private EmailProviderService $providerService;
    private StorageAnalyticsService $analyticsService;

    public function __construct(
        EmailProviderService $providerService,
        StorageAnalyticsService $analyticsService
    ) {
        $this->providerService = $providerService;
        $this->analyticsService = $analyticsService;
    }

    public function index()
    {
        return view('dashboard.index', [
            'supported_providers' => $this->providerService->getSupportedProviders(),
            'provider_display_names' => collect($this->providerService->getSupportedProviders())
                ->mapWithKeys(fn($provider) => [$provider => $this->providerService->getProviderDisplayName($provider)])
                ->toArray(),
        ]);
    }

    public function testConnection(Request $request)
    {
        $request->validate([
            'provider' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
            'custom_host' => 'nullable|string',
            'custom_port' => 'nullable|integer',
            'custom_encryption' => 'nullable|string|in:ssl,tls,none',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $customSettings = null;
        if (in_array($request->provider, ['imap', 'pop3'])) {
            $customSettings = [
                'host' => $request->custom_host,
                'port' => $request->custom_port ?? 993,
                'encryption' => $request->custom_encryption ?? 'ssl',
                'validate_cert' => true,
                'protocol' => $request->provider,
            ];
        }

        $result = $this->providerService->testConnection(
            $request->provider,
            $credentials,
            $customSettings
        );

        if ($result['success']) {
            // Create session for successful connection
            $sessionId = Str::uuid();
            $session = EmailSession::create([
                'session_id' => $sessionId,
                'provider' => $request->provider,
                'email_address' => $request->email,
                'status' => 'connected',
                'connection_settings' => $customSettings,
                'total_emails' => $result['total_emails'],
                'connected_at' => now(),
            ]);

            // Set credentials using the mutator
            $session->credentials = $credentials;
            $session->save();

            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'session_id' => $sessionId,
                'total_emails' => $result['total_emails'],
                'folders' => $result['folders'],
            ]);
        }

        return response()->json($result, 400);
    }

    public function sessionStatus(string $sessionId)
    {
        $session = EmailSession::where('session_id', $sessionId)->firstOrFail();

        $progress = $this->analyticsService->getRealTimeProgress($session);

        return response()->json([
            'session' => [
                'id' => $session->session_id,
                'provider' => $session->provider,
                'email_address' => $session->email_address,
                'status' => $session->status,
                'progress_percentage' => $session->progress_percentage,
                'storage_saved_mb' => $session->storage_saved_mb,
                'storage_saved_gb' => $session->storage_saved_gb,
                'error_message' => $session->error_message,
            ],
            'progress' => $progress,
        ]);
    }

    public function sessionAnalytics(string $sessionId)
    {
        $session = EmailSession::where('session_id', $sessionId)->firstOrFail();

        if (!$session->isCompleted()) {
            return response()->json(['error' => 'Session not completed yet'], 400);
        }

        $analytics = $this->analyticsService->getSessionAnalytics($session);

        return response()->json([
            'session' => [
                'id' => $session->session_id,
                'provider' => $session->provider,
                'email_address' => $session->email_address,
                'status' => $session->status,
                'total_emails' => $session->total_emails,
                'processed_emails' => $session->processed_emails,
                'storage_saved_mb' => $session->storage_saved_mb,
                'storage_saved_gb' => $session->storage_saved_gb,
                'processing_started_at' => $session->processing_started_at?->format('Y-m-d H:i:s'),
                'processing_completed_at' => $session->processing_completed_at?->format('Y-m-d H:i:s'),
            ],
            'analytics' => $analytics,
        ]);
    }

    public function processingDashboard(string $sessionId)
    {
        $session = EmailSession::where('session_id', $sessionId)->firstOrFail();

        return view('dashboard.processing', [
            'session' => $session,
        ]);
    }

    public function resultsDashboard(string $sessionId)
    {
        $session = EmailSession::where('session_id', $sessionId)->firstOrFail();

        if (!$session->isCompleted()) {
            return redirect()->route('dashboard.processing', $sessionId)
                ->with('error', 'Processing not completed yet');
        }

        $analytics = $this->analyticsService->getSessionAnalytics($session);

        return view('dashboard.results', [
            'session' => $session,
            'analytics' => $analytics,
        ]);
    }
}
