<?php

namespace App\Http\Controllers;

use App\Models\EmailSession;
use App\Services\OAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class OAuthController extends Controller
{
    private OAuthService $oauthService;

    public function __construct(OAuthService $oauthService)
    {
        $this->oauthService = $oauthService;
    }

    /**
     * Redirect to OAuth provider
     */
    public function redirect(string $provider)
    {
        try {
            $authUrl = $this->oauthService->getAuthorizationUrl($provider);
            return redirect($authUrl);
        } catch (\Exception $e) {
            Log::error('OAuth redirect error: ' . $e->getMessage());
            return redirect()->route('dashboard.index')
                ->with('error', 'Failed to initiate OAuth authentication: ' . $e->getMessage());
        }
    }

    /**
     * Handle OAuth callback
     */
    public function callback(Request $request, string $provider)
    {
        try {
            $code = $request->get('code');
            $state = $request->get('state');
            $error = $request->get('error');

            if ($error) {
                return redirect()->route('dashboard.index')
                    ->with('error', 'OAuth authentication failed: ' . $error);
            }

            if (!$code) {
                return redirect()->route('dashboard.index')
                    ->with('error', 'Authorization code not received');
            }

            // Exchange code for tokens
            $tokens = $this->oauthService->exchangeCodeForTokens($provider, $code, $state);
            
            // Get user info
            $userInfo = $this->oauthService->getUserInfo($provider, $tokens['access_token']);
            
            // Create session
            $sessionId = Str::uuid();
            $session = EmailSession::create([
                'session_id' => $sessionId,
                'provider' => $provider,
                'encrypted_credentials' => $this->oauthService->encryptTokens($tokens),
                'email_address' => $userInfo['email'],
                'status' => 'connected',
                'connection_settings' => [
                    'oauth_tokens' => true,
                    'provider' => $provider,
                    'user_info' => $userInfo
                ],
                'total_emails' => 0, // Will be updated when we fetch emails
                'connected_at' => now(),
            ]);

            // Test the connection and get email count
            $emailCount = $this->oauthService->testOAuthConnection($provider, $tokens);
            $session->update(['total_emails' => $emailCount]);

            return redirect()->route('dashboard.index')
                ->with('success', "Successfully connected to {$provider}! Found {$emailCount} emails.")
                ->with('session_id', $sessionId);

        } catch (\Exception $e) {
            Log::error('OAuth callback error: ' . $e->getMessage());
            return redirect()->route('dashboard.index')
                ->with('error', 'OAuth authentication failed: ' . $e->getMessage());
        }
    }

    /**
     * Disconnect OAuth session
     */
    public function disconnect(string $sessionId)
    {
        try {
            $session = EmailSession::where('session_id', $sessionId)->firstOrFail();
            
            // Revoke tokens if possible
            if ($session->connection_settings['oauth_tokens'] ?? false) {
                $tokens = $this->oauthService->decryptTokens($session->encrypted_credentials);
                $this->oauthService->revokeTokens($session->provider, $tokens);
            }

            $session->delete();

            return response()->json([
                'success' => true,
                'message' => 'Account disconnected successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('OAuth disconnect error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to disconnect account: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Refresh OAuth tokens
     */
    public function refreshTokens(string $sessionId)
    {
        try {
            $session = EmailSession::where('session_id', $sessionId)->firstOrFail();
            $tokens = $this->oauthService->decryptTokens($session->encrypted_credentials);
            
            $newTokens = $this->oauthService->refreshTokens($session->provider, $tokens['refresh_token']);
            
            $session->update([
                'encrypted_credentials' => $this->oauthService->encryptTokens($newTokens)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tokens refreshed successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Token refresh error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to refresh tokens: ' . $e->getMessage()
            ], 500);
        }
    }
}
