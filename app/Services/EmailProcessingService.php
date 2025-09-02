<?php

namespace App\Services;

use App\Models\EmailSession;
use App\Models\EmailProcessingLog;
use App\Models\StorageAnalytics;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Webklex\PHPIMAP\Client;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EmailProcessingService
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

    public function processEmails(EmailSession $session): void
    {
        try {
            $session->update([
                'status' => 'processing',
                'processing_started_at' => now(),
            ]);

            // Handle demo mode
            if ($session->provider === 'demo') {
                $this->processDemoEmails($session);
                return;
            }

            $credentials = $session->decrypted_credentials;
            $client = $this->providerService->createConnection(
                $session->provider,
                $credentials,
                $session->connection_settings
            );

            $client->connect();

            // Get total email count for progress tracking
            $totalEmails = $this->providerService->getEmailCount($client);
            $session->update(['total_emails' => $totalEmails]);

            $processedCount = 0;
            $batchSize = 10; // Process emails in batches

            for ($offset = 0; $offset < $totalEmails; $offset += $batchSize) {
                $emails = $this->providerService->getEmails($client, 'INBOX', $batchSize, $offset);

                foreach ($emails as $email) {
                    $this->processIndividualEmail($session, $email);
                    $processedCount++;

                    // Update progress
                    $session->update(['processed_emails' => $processedCount]);
                }

                // Small delay to prevent overwhelming the server
                usleep(100000); // 0.1 second
            }

            $client->disconnect();

            // Calculate final analytics
            $this->analyticsService->calculateSessionAnalytics($session);

            $session->update([
                'status' => 'completed',
                'processing_completed_at' => now(),
            ]);

        } catch (Exception $e) {
            $session->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    private function processIndividualEmail(EmailSession $session, array $email): void
    {
        try {
            $originalSize = $email['size'] ?? 0;
            $attachments = $this->extractAttachments($email);
            $images = $this->extractImages($email);

            // Create Word document
            $wordDoc = $this->createWordDocument($email, $attachments, $images);
            $outputPath = $this->saveWordDocument($wordDoc, $session->session_id, $email['uid']);

            $convertedSize = Storage::size($outputPath);
            $storageSaved = max(0, $originalSize - $convertedSize);

            // Log the processing
            EmailProcessingLog::create([
                'email_session_id' => $session->id,
                'email_uid' => $email['uid'],
                'subject' => $email['subject'],
                'sender' => $email['from'],
                'email_date' => $email['date'],
                'action' => 'converted',
                'content_type' => $this->determineContentType($email),
                'attachment_count' => count($attachments),
                'image_count' => count($images),
                'original_size_bytes' => $originalSize,
                'converted_size_bytes' => $convertedSize,
                'storage_saved_bytes' => $storageSaved,
                'attachments_info' => $attachments,
                'images_info' => $images,
                'output_file_path' => $outputPath,
                'processed_at' => now(),
            ]);

            // Update session totals
            $session->increment('freed_storage_bytes', $storageSaved);

        } catch (Exception $e) {
            // Log the error
            EmailProcessingLog::create([
                'email_session_id' => $session->id,
                'email_uid' => $email['uid'],
                'subject' => $email['subject'],
                'sender' => $email['from'],
                'email_date' => $email['date'],
                'action' => 'error',
                'content_type' => $this->determineContentType($email),
                'original_size_bytes' => $email['size'] ?? 0,
                'error_details' => $e->getMessage(),
                'processed_at' => now(),
            ]);
        }
    }

    private function createWordDocument(array $email, array $attachments, array $images): PhpWord
    {
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Add email header
        $section->addText('Subject: ' . ($email['subject'] ?? 'No Subject'), ['bold' => true, 'size' => 14]);
        $section->addText('From: ' . ($email['from'] ?? 'Unknown'), ['size' => 12]);
        $section->addText('Date: ' . ($email['date'] ? $email['date']->format('Y-m-d H:i:s') : 'Unknown'), ['size' => 12]);
        $section->addTextBreak(2);

        // Add email body
        if (!empty($email['body_text'])) {
            $section->addText('Email Content:', ['bold' => true, 'size' => 12]);
            $section->addTextBreak();
            $section->addText($email['body_text']);
        } elseif (!empty($email['body_html'])) {
            $section->addText('Email Content (HTML):', ['bold' => true, 'size' => 12]);
            $section->addTextBreak();
            $section->addText(strip_tags($email['body_html']));
        }

        // Add attachments info
        if (!empty($attachments)) {
            $section->addTextBreak(2);
            $section->addText('Attachments:', ['bold' => true, 'size' => 12]);
            foreach ($attachments as $attachment) {
                $section->addText('- ' . $attachment['name'] . ' (' . $attachment['size'] . ' bytes)');
            }
        }

        // Add images info
        if (!empty($images)) {
            $section->addTextBreak(2);
            $section->addText('Images:', ['bold' => true, 'size' => 12]);
            foreach ($images as $image) {
                $section->addText('- ' . $image['name'] . ' (' . $image['size'] . ' bytes)');
            }
        }

        return $phpWord;
    }

    private function saveWordDocument(PhpWord $phpWord, string $sessionId, string $emailUid): string
    {
        $filename = "email_{$sessionId}_{$emailUid}.docx";
        $tempPath = storage_path("app/temp/{$filename}");

        // Ensure directory exists
        if (!file_exists(dirname($tempPath))) {
            mkdir(dirname($tempPath), 0755, true);
        }

        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tempPath);

        return "temp/{$filename}";
    }

    private function extractAttachments(array $email): array
    {
        // This would extract actual attachments in a real implementation
        // For now, return mock data based on email content
        $attachments = [];

        if ($email['has_attachments'] ?? false) {
            for ($i = 0; $i < ($email['attachment_count'] ?? 0); $i++) {
                $attachments[] = [
                    'name' => "attachment_{$i}.pdf",
                    'size' => rand(1024, 1048576), // Random size between 1KB and 1MB
                    'type' => 'application/pdf',
                ];
            }
        }

        return $attachments;
    }

    private function extractImages(array $email): array
    {
        // This would extract actual images in a real implementation
        // For now, return mock data based on email content
        $images = [];

        if (!empty($email['body_html'])) {
            // Count img tags in HTML
            $imageCount = substr_count($email['body_html'], '<img');

            for ($i = 0; $i < $imageCount; $i++) {
                $images[] = [
                    'name' => "image_{$i}.jpg",
                    'size' => rand(10240, 512000), // Random size between 10KB and 500KB
                    'type' => 'image/jpeg',
                ];
            }
        }

        return $images;
    }

    private function determineContentType(array $email): string
    {
        if ($email['has_attachments'] ?? false) {
            return 'mixed';
        } elseif (!empty($email['body_html'])) {
            return 'html';
        } else {
            return 'text';
        }
    }

    private function processDemoEmails(EmailSession $session): void
    {
        // Simulate processing with demo data
        $demoEmails = $this->generateDemoEmails();
        $session->update(['total_emails' => count($demoEmails)]);

        $processedCount = 0;

        foreach ($demoEmails as $email) {
            // Simulate processing time
            usleep(500000); // 0.5 second delay per email

            $this->processIndividualEmail($session, $email);
            $processedCount++;

            // Update progress
            $session->update(['processed_emails' => $processedCount]);
        }

        // Calculate final analytics
        $this->analyticsService->calculateSessionAnalytics($session);

        $session->update([
            'status' => 'completed',
            'processing_completed_at' => now(),
        ]);
    }

    private function generateDemoEmails(): array
    {
        $demoEmails = [];
        $subjects = [
            'Welcome to our newsletter!',
            'Your monthly report is ready',
            'Meeting reminder: Team standup',
            'Invoice #12345 from Acme Corp',
            'Photo album from vacation',
            'Project update: Q4 goals',
            'Security alert: New login detected',
            'Your order has been shipped',
            'Weekly digest: Top articles',
            'Birthday party invitation',
            'Conference registration confirmation',
            'Password reset request',
            'Survey: How did we do?',
            'New feature announcement',
            'Maintenance window scheduled',
            'Thank you for your purchase',
            'Webinar recording available',
            'Monthly newsletter - December',
            'System backup completed',
            'Holiday schedule update'
        ];

        $senders = [
            'newsletter@company.com',
            'reports@analytics.com',
            'team@workspace.com',
            'billing@acmecorp.com',
            'photos@cloudservice.com',
            'pm@projecttools.com',
            'security@emailprovider.com',
            'orders@onlinestore.com',
            'digest@newssite.com',
            'events@socialapp.com'
        ];

        for ($i = 0; $i < 20; $i++) {
            $hasAttachments = rand(0, 100) < 30; // 30% chance
            $hasImages = rand(0, 100) < 40; // 40% chance
            $isHtml = rand(0, 100) < 70; // 70% chance

            $demoEmails[] = [
                'uid' => 'demo_' . ($i + 1),
                'subject' => $subjects[array_rand($subjects)],
                'from' => $senders[array_rand($senders)],
                'date' => now()->subDays(rand(1, 30)),
                'size' => rand(5120, 2097152), // 5KB to 2MB
                'has_attachments' => $hasAttachments,
                'attachment_count' => $hasAttachments ? rand(1, 3) : 0,
                'body_html' => $isHtml ? '<p>This is a demo HTML email with <strong>formatting</strong>.</p>' : '',
                'body_text' => 'This is a demo email content for testing the email processing system.',
            ];
        }

        return $demoEmails;
    }
}
