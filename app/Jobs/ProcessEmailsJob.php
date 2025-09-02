<?php

namespace App\Jobs;

use App\Models\EmailSession;
use App\Services\EmailProcessingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Exception;

class ProcessEmailsJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public int $timeout = 3600; // 1 hour timeout
    public int $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public EmailSession $session
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(EmailProcessingService $processingService): void
    {
        try {
            $processingService->processEmails($this->session);
        } catch (Exception $e) {
            $this->session->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(Exception $exception): void
    {
        $this->session->update([
            'status' => 'failed',
            'error_message' => $exception->getMessage(),
        ]);
    }
}
