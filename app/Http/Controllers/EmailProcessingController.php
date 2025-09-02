<?php

namespace App\Http\Controllers;

use App\Models\EmailSession;
use App\Services\EmailProcessingService;
use App\Jobs\ProcessEmailsJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class EmailProcessingController extends Controller
{
    private EmailProcessingService $processingService;

    public function __construct(EmailProcessingService $processingService)
    {
        $this->processingService = $processingService;
    }

    public function startProcessing(Request $request, string $sessionId)
    {
        $session = EmailSession::where('session_id', $sessionId)->firstOrFail();

        if (!$session->isProcessing() && !$session->isCompleted()) {
            return response()->json(['error' => 'Session not in valid state for processing'], 400);
        }

        // Dispatch background job for email processing
        ProcessEmailsJob::dispatch($session);

        return response()->json([
            'success' => true,
            'message' => 'Email processing started',
            'session_id' => $sessionId,
        ]);
    }

    public function pauseProcessing(string $sessionId)
    {
        $session = EmailSession::where('session_id', $sessionId)->firstOrFail();

        // In a real implementation, you would pause the background job
        // For now, we'll just update the status
        if ($session->status === 'processing') {
            $session->update(['status' => 'paused']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Processing paused',
        ]);
    }

    public function resumeProcessing(string $sessionId)
    {
        $session = EmailSession::where('session_id', $sessionId)->firstOrFail();

        if ($session->status === 'paused') {
            $session->update(['status' => 'processing']);
            ProcessEmailsJob::dispatch($session);
        }

        return response()->json([
            'success' => true,
            'message' => 'Processing resumed',
        ]);
    }

    public function downloadResults(string $sessionId)
    {
        $session = EmailSession::where('session_id', $sessionId)->firstOrFail();

        if (!$session->isCompleted()) {
            return response()->json(['error' => 'Processing not completed'], 400);
        }

        $zipPath = $this->createDownloadZip($session);

        return response()->download(storage_path("app/{$zipPath}"))
            ->deleteFileAfterSend(true);
    }

    public function downloadIndividualFile(string $sessionId, int $logId)
    {
        $session = EmailSession::where('session_id', $sessionId)->firstOrFail();
        $log = $session->processingLogs()->findOrFail($logId);

        if (!$log->output_file_path || !Storage::exists($log->output_file_path)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        $filename = basename($log->output_file_path);
        return response()->download(storage_path("app/{$log->output_file_path}"), $filename);
    }

    public function getProcessingLogs(string $sessionId)
    {
        $session = EmailSession::where('session_id', $sessionId)->firstOrFail();

        $logs = $session->processingLogs()
            ->orderBy('processed_at', 'desc')
            ->paginate(20);

        return response()->json([
            'logs' => $logs->items(),
            'pagination' => [
                'current_page' => $logs->currentPage(),
                'last_page' => $logs->lastPage(),
                'per_page' => $logs->perPage(),
                'total' => $logs->total(),
            ],
        ]);
    }

    public function getImageGallery(string $sessionId)
    {
        $session = EmailSession::where('session_id', $sessionId)->firstOrFail();

        $logsWithImages = $session->processingLogs()
            ->where('image_count', '>', 0)
            ->whereNotNull('images_info')
            ->get();

        $images = [];
        foreach ($logsWithImages as $log) {
            foreach ($log->images_info as $image) {
                $images[] = [
                    'email_subject' => $log->subject,
                    'email_sender' => $log->sender,
                    'image_name' => $image['name'],
                    'image_size' => $image['size'],
                    'image_type' => $image['type'],
                    'processed_at' => $log->processed_at->format('Y-m-d H:i:s'),
                ];
            }
        }

        return response()->json([
            'images' => $images,
            'total_images' => count($images),
            'total_size_mb' => round(collect($images)->sum('image_size') / 1024 / 1024, 2),
        ]);
    }

    public function getAttachmentsList(string $sessionId)
    {
        $session = EmailSession::where('session_id', $sessionId)->firstOrFail();

        $logsWithAttachments = $session->processingLogs()
            ->where('attachment_count', '>', 0)
            ->whereNotNull('attachments_info')
            ->get();

        $attachments = [];
        foreach ($logsWithAttachments as $log) {
            foreach ($log->attachments_info as $attachment) {
                $attachments[] = [
                    'email_subject' => $log->subject,
                    'email_sender' => $log->sender,
                    'attachment_name' => $attachment['name'],
                    'attachment_size' => $attachment['size'],
                    'attachment_type' => $attachment['type'],
                    'processed_at' => $log->processed_at->format('Y-m-d H:i:s'),
                ];
            }
        }

        return response()->json([
            'attachments' => $attachments,
            'total_attachments' => count($attachments),
            'total_size_mb' => round(collect($attachments)->sum('attachment_size') / 1024 / 1024, 2),
        ]);
    }

    private function createDownloadZip(EmailSession $session): string
    {
        $zipFilename = "email_conversion_{$session->session_id}.zip";
        $zipPath = storage_path("app/downloads/{$zipFilename}");

        // Ensure directory exists
        if (!file_exists(dirname($zipPath))) {
            mkdir(dirname($zipPath), 0755, true);
        }

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE) !== TRUE) {
            throw new \Exception('Cannot create zip file');
        }

        // Add all converted files to zip
        $logs = $session->processingLogs()
            ->whereNotNull('output_file_path')
            ->get();

        foreach ($logs as $log) {
            if (Storage::exists($log->output_file_path)) {
                $filePath = storage_path("app/{$log->output_file_path}");
                $filename = "email_{$log->id}_" . basename($log->output_file_path);
                $zip->addFile($filePath, $filename);
            }
        }

        // Add summary report
        $summaryContent = $this->generateSummaryReport($session);
        $zip->addFromString('conversion_summary.txt', $summaryContent);

        $zip->close();

        return "downloads/{$zipFilename}";
    }

    private function generateSummaryReport(EmailSession $session): string
    {
        $report = "Email Conversion Summary\n";
        $report .= "========================\n\n";
        $report .= "Session ID: {$session->session_id}\n";
        $report .= "Email Provider: " . ucfirst($session->provider) . "\n";
        $report .= "Email Address: {$session->email_address}\n";
        $report .= "Processing Started: {$session->processing_started_at}\n";
        $report .= "Processing Completed: {$session->processing_completed_at}\n\n";

        $report .= "Statistics:\n";
        $report .= "-----------\n";
        $report .= "Total Emails: {$session->total_emails}\n";
        $report .= "Processed Emails: {$session->processed_emails}\n";
        $report .= "Storage Saved: {$session->storage_saved_mb} MB ({$session->storage_saved_gb} GB)\n\n";

        $successfulLogs = $session->processingLogs()->where('action', 'converted')->count();
        $errorLogs = $session->processingLogs()->where('action', 'error')->count();

        $report .= "Conversion Results:\n";
        $report .= "-------------------\n";
        $report .= "Successfully Converted: {$successfulLogs}\n";
        $report .= "Errors: {$errorLogs}\n";
        $report .= "Success Rate: " . round(($successfulLogs / $session->processed_emails) * 100, 2) . "%\n\n";

        $report .= "Generated on: " . now()->format('Y-m-d H:i:s') . "\n";

        return $report;
    }
}
