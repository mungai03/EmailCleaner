<?php

namespace App\Services;

use Webklex\PHPIMAP\ClientManager;
use Webklex\PHPIMAP\Client;
use Exception;

class EmailProviderService
{
    private array $providerConfigs = [
        'demo' => [
            'host' => 'demo.emailcleaner.com',
            'port' => 993,
            'encryption' => 'ssl',
            'validate_cert' => false,
            'protocol' => 'imap',
        ],
        'gmail' => [
            'host' => 'imap.gmail.com',
            'port' => 993,
            'encryption' => 'ssl',
            'validate_cert' => true,
            'protocol' => 'imap',
        ],
        'yahoo' => [
            'host' => 'imap.mail.yahoo.com',
            'port' => 993,
            'encryption' => 'ssl',
            'validate_cert' => true,
            'protocol' => 'imap',
        ],
        'outlook' => [
            'host' => 'outlook.office365.com',
            'port' => 993,
            'encryption' => 'ssl',
            'validate_cert' => true,
            'protocol' => 'imap',
        ],
        'aol' => [
            'host' => 'imap.aol.com',
            'port' => 993,
            'encryption' => 'ssl',
            'validate_cert' => true,
            'protocol' => 'imap',
        ],
        'zoho' => [
            'host' => 'imap.zoho.com',
            'port' => 993,
            'encryption' => 'ssl',
            'validate_cert' => true,
            'protocol' => 'imap',
        ],
    ];

    public function createConnection(string $provider, array $credentials, ?array $customSettings = null): Client
    {
        $config = $this->getProviderConfig($provider, $customSettings);

        $clientManager = new ClientManager();

        // Clean and validate credentials
        $cleanEmail = trim($credentials['email']);
        $cleanPassword = trim($credentials['password']);

        // Validate email format
        if (!filter_var($cleanEmail, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Invalid email address format');
        }

        // Validate password
        if (empty($cleanPassword)) {
            throw new \Exception('Password cannot be empty');
        }

        $client = $clientManager->make([
            'host' => $config['host'],
            'port' => $config['port'],
            'encryption' => $config['encryption'],
            'validate_cert' => $config['validate_cert'],
            'username' => $cleanEmail,
            'password' => $cleanPassword,
            'protocol' => $config['protocol'],
            'timeout' => 30,
            'debug' => false, // Set to true for debugging
        ]);

        return $client;
    }

    public function testConnection(string $provider, array $credentials, ?array $customSettings = null): array
    {
        // Handle demo mode
        if ($provider === 'demo') {
            return [
                'success' => true,
                'message' => 'Demo connection successful - This is a simulation with sample data',
                'total_emails' => 1247,
                'folders' => ['INBOX', 'Sent', 'Drafts', 'Spam', 'Trash', 'Important', 'Work', 'Personal'],
            ];
        }

        try {
            $client = $this->createConnection($provider, $credentials, $customSettings);

            // Test basic connection first
            $client->connect();

            // Test if we can access folders (this often fails with wrong credentials)
            $folders = $client->getFolders();

            // Test if we can access inbox
            $inbox = $client->getFolder('INBOX');

            // Get email count (this might fail if permissions are wrong)
            $totalEmails = 0;
            try {
                $totalEmails = $inbox->messages()->count();
            } catch (Exception $countException) {
                // If we can't count emails, still consider connection successful
                // but note the limitation
                $totalEmails = 0;
            }

            $client->disconnect();

            return [
                'success' => true,
                'message' => 'Connection successful',
                'total_emails' => $totalEmails,
                'folders' => $folders->map(fn($folder) => $folder->name)->toArray(),
            ];
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            $suggestions = [];

            // Provide specific suggestions based on error type
            if (str_contains($errorMessage, 'Application-specific password required')) {
                $suggestions[] = 'Gmail requires an App Password. Please generate one from your Google Account Security settings.';
                $suggestions[] = 'Make sure 2-Step Verification is enabled on your Google account.';
                $suggestions[] = 'Use the 16-character app password (without spaces) instead of your regular password.';
            } elseif (str_contains($errorMessage, 'Could not parse command') || str_contains($errorMessage, 'BAD')) {
                $suggestions[] = 'There was an IMAP protocol error. This often indicates:';
                if ($provider === 'gmail') {
                    $suggestions[] = '• You\'re using your regular password instead of an App Password';
                    $suggestions[] = '• Gmail requires an App Password for IMAP access';
                } elseif ($provider === 'yahoo') {
                    $suggestions[] = '• You\'re using your regular password instead of an App Password';
                    $suggestions[] = '• Yahoo requires an App Password for IMAP access';
                } else {
                    $suggestions[] = '• Check if your email provider requires an App Password';
                    $suggestions[] = '• Verify that IMAP is enabled in your email account settings';
                }
                $suggestions[] = '• Try using Demo Mode to test the system first';
            } elseif (str_contains($errorMessage, 'Invalid credentials')) {
                $suggestions[] = 'Please check your email address and password.';
                if ($provider === 'gmail') {
                    $suggestions[] = 'Gmail requires an App Password, not your regular password.';
                } elseif ($provider === 'yahoo') {
                    $suggestions[] = 'Yahoo requires an App Password for IMAP access.';
                } elseif ($provider === 'outlook') {
                    $suggestions[] = 'If you have 2FA enabled, you need an App Password for Outlook.';
                    $suggestions[] = 'Try your regular password first, then generate an App Password if needed.';
                } elseif (in_array($provider, ['aol', 'zoho'])) {
                    $suggestions[] = 'Try your regular password first.';
                    $suggestions[] = 'If that fails, check if you need to enable IMAP in your account settings.';
                } else {
                    $suggestions[] = 'Some providers may require enabling IMAP access in account settings.';
                    $suggestions[] = 'Check if your provider requires an App Password for third-party apps.';
                }
            } elseif (str_contains($errorMessage, 'Connection refused') || str_contains($errorMessage, 'timeout')) {
                $suggestions[] = 'Check your internet connection.';
                $suggestions[] = 'Your firewall or antivirus might be blocking the connection.';
                if (in_array($provider, ['imap', 'pop3'])) {
                    $suggestions[] = 'Verify the server host and port settings.';
                }
            } elseif (str_contains($errorMessage, 'Certificate')) {
                $suggestions[] = 'There might be an SSL certificate issue.';
                $suggestions[] = 'Try using a different encryption method (TLS instead of SSL).';
            }

            return [
                'success' => false,
                'message' => 'Connection failed: ' . $errorMessage,
                'error_code' => $e->getCode(),
                'suggestions' => $suggestions,
                'provider' => $provider,
            ];
        }
    }

    public function getEmailCount(Client $client, string $folderName = 'INBOX'): int
    {
        try {
            $folder = $client->getFolder($folderName);
            return $folder->messages()->count();
        } catch (Exception $e) {
            throw new Exception("Failed to get email count: " . $e->getMessage());
        }
    }

    public function getEmails(Client $client, string $folderName = 'INBOX', int $limit = 50, int $offset = 0): array
    {
        try {
            $folder = $client->getFolder($folderName);
            $messages = $folder->messages()
                ->limit($limit, $offset)
                ->get();

            return $messages->map(function ($message) {
                return [
                    'uid' => $message->getUid(),
                    'subject' => $message->getSubject(),
                    'from' => $message->getFrom()[0]->mail ?? 'Unknown',
                    'date' => $message->getDate(),
                    'size' => $message->getSize(),
                    'has_attachments' => $message->hasAttachments(),
                    'attachment_count' => $message->getAttachments()->count(),
                    'body_html' => $message->getHTMLBody(),
                    'body_text' => $message->getTextBody(),
                ];
            })->toArray();
        } catch (Exception $e) {
            throw new Exception("Failed to fetch emails: " . $e->getMessage());
        }
    }

    public function getSupportedProviders(): array
    {
        return array_keys($this->providerConfigs);
    }

    public function getProviderDisplayName(string $provider): string
    {
        $displayNames = [
            'demo' => 'Demo Mode',
            'gmail' => 'Gmail',
            'yahoo' => 'Yahoo Mail',
            'outlook' => 'Outlook/Hotmail',
            'aol' => 'AOL Mail',
            'zoho' => 'Zoho Mail',
            'imap' => 'Custom IMAP',
            'pop3' => 'Custom POP3',
        ];

        return $displayNames[$provider] ?? ucfirst($provider);
    }

    private function getProviderConfig(string $provider, ?array $customSettings = null): array
    {
        if ($provider === 'imap' || $provider === 'pop3') {
            if (!$customSettings) {
                throw new Exception("Custom settings required for {$provider} provider");
            }
            return $customSettings;
        }

        if (!isset($this->providerConfigs[$provider])) {
            throw new Exception("Unsupported email provider: {$provider}");
        }

        return $this->providerConfigs[$provider];
    }
}
