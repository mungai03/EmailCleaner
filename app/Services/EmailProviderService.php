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
            'validate_cert' => false,
            'protocol' => 'imap',
            'options' => [
                'open' => [
                    'DISABLE_AUTHENTICATOR' => 'GSSAPI'
                ]
            ]
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

        $clientConfig = [
            'host' => $config['host'],
            'port' => $config['port'],
            'encryption' => $config['encryption'],
            'validate_cert' => $config['validate_cert'],
            'username' => $cleanEmail,
            'password' => $cleanPassword,
            'protocol' => $config['protocol'],
            'timeout' => 30,
            'debug' => true, // Set to true for debugging
        ];

        // Add Gmail-specific options
        if ($provider === 'gmail' && isset($config['options'])) {
            $clientConfig = array_merge($clientConfig, $config['options']);
        }

        $client = $clientManager->make($clientConfig);

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

    public function getFolders(string $provider, array $credentials, ?array $customSettings = null): array
    {
        // Handle demo mode
        if ($provider === 'demo') {
            return [
                'success' => true,
                'folders' => ['INBOX', 'Sent', 'Drafts', 'Spam', 'Trash', 'Important', 'Work', 'Personal']
            ];
        }

        try {
            $client = $this->createConnection($provider, $credentials, $customSettings);
            $client->connect();

            $folders = $client->getFolders();
            $folderNames = $folders->map(fn($folder) => $folder->name)->toArray();

            return [
                'success' => true,
                'folders' => $folderNames
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to fetch folders: ' . $e->getMessage(),
                'folders' => []
            ];
        }
    }

    public function getEmailsFromFolder(string $provider, array $credentials, string $folderName, ?array $customSettings = null, int $limit = 100): array
    {
        // Handle demo mode
        if ($provider === 'demo') {
            return $this->getDemoEmails($limit);
        }

        try {
            $client = $this->createConnection($provider, $credentials, $customSettings);
            $client->connect();

            $folder = $client->getFolder($folderName);
            
            // Get messages with multiple fallback approaches
            $messages = [];
            try {
                $messages = $folder->query()->limit($limit, 0)->get();
            } catch (\Exception $e) {
                try {
                    $messages = $folder->messages()->limit($limit)->get();
                } catch (\Exception $e2) {
                    $allMessages = $folder->messages()->get();
                    $messages = array_slice($allMessages, 0, $limit);
                }
            }

            $emails = [];
            foreach ($messages as $message) {
                try {
                    $fromAddress = 'Unknown';
                    $fromName = '';
                    $fromData = $message->getFrom();
                    if ($fromData && is_array($fromData) && count($fromData) > 0) {
                        $fromAddress = $fromData[0]->mail ?? 'Unknown';
                        $fromName = $fromData[0]->personal ?? '';
                    }

                    $toAddress = 'Unknown';
                    $toData = $message->getTo();
                    if ($toData && is_array($toData) && count($toData) > 0) {
                        $toAddress = $toData[0]->mail ?? 'Unknown';
                    }

                    $attachments = [];
                    try {
                        $attachments = $message->getAttachments();
                    } catch (\Exception $e) {
                        $attachments = [];
                    }

                    $emails[] = [
                        'uid' => $message->getUid(),
                        'subject' => $message->getSubject() ?? 'No Subject',
                        'from' => $fromAddress,
                        'from_name' => $fromName,
                        'to' => $toAddress,
                        'date' => $message->getDate() ? $message->getDate()->format('Y-m-d H:i:s') : date('Y-m-d H:i:s'),
                        'has_attachments' => $message->hasAttachments(),
                        'attachment_count' => is_array($attachments) ? count($attachments) : 0,
                        'is_read' => !$message->isUnseen(),
                        'is_important' => $message->isFlagged(),
                        'size' => $message->getSize() ?? 0,
                        'preview' => $this->getEmailPreview($message),
                    ];
                } catch (\Exception $e) {
                    continue;
                }
            }

            return [
                'success' => true,
                'emails' => $emails,
                'total_count' => count($emails),
                'folder' => $folderName
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to fetch emails from folder: ' . $e->getMessage(),
                'emails' => [],
                'total_count' => 0
            ];
        }
    }

    public function getAllEmails(string $provider, array $credentials, ?array $customSettings = null, int $limit = 100): array
    {
        // Handle demo mode
        if ($provider === 'demo') {
            return $this->getDemoEmails($limit);
        }

        // For Gmail, use Webklex/PHPIMAP library for real connections
        if ($provider === 'gmail') {
            return $this->getGmailEmailsReal($credentials, $limit);
        }

        try {
            $client = $this->createConnection($provider, $credentials, $customSettings);
            $client->connect();

            // For other providers, try INBOX first
            $folder = null;
            $folderName = 'INBOX';
            
            try {
                $folder = $client->getFolder('INBOX');
            } catch (\Exception $e) {
                $folders = $client->getFolders();
                if (count($folders) > 0) {
                    $folder = $folders[0];
                    $folderName = $folder->getName();
                }
            }
            
            if (!$folder) {
                return [
                    'success' => false,
                    'message' => 'No accessible folders found',
                    'emails' => [],
                    'total_count' => 0
                ];
            }
            
            // Get messages with multiple fallback approaches
            $messages = [];
            try {
                $messages = $folder->query()->limit($limit, 0)->get();
            } catch (\Exception $e) {
                try {
                    $messages = $folder->messages()->limit($limit)->get();
                } catch (\Exception $e2) {
                    $allMessages = $folder->messages()->get();
                    $messages = array_slice($allMessages, 0, $limit);
                }
            }

            $emails = [];
            foreach ($messages as $message) {
                try {
                    $fromAddress = 'Unknown';
                    $fromName = '';
                    $fromData = $message->getFrom();
                    if ($fromData && is_array($fromData) && count($fromData) > 0) {
                        $fromAddress = $fromData[0]->mail ?? 'Unknown';
                        $fromName = $fromData[0]->personal ?? '';
                    }

                    $toAddress = 'Unknown';
                    $toData = $message->getTo();
                    if ($toData && is_array($toData) && count($toData) > 0) {
                        $toAddress = $toData[0]->mail ?? 'Unknown';
                    }

                    $attachments = [];
                    try {
                        $attachments = $message->getAttachments();
                    } catch (\Exception $e) {
                        $attachments = [];
                    }

                    $emails[] = [
                        'uid' => $message->getUid(),
                        'subject' => $message->getSubject() ?? 'No Subject',
                        'from' => $fromAddress,
                        'from_name' => $fromName,
                        'to' => $toAddress,
                        'date' => $message->getDate() ? $message->getDate()->format('Y-m-d H:i:s') : date('Y-m-d H:i:s'),
                        'has_attachments' => $message->hasAttachments(),
                        'attachment_count' => is_array($attachments) ? count($attachments) : 0,
                        'is_read' => !$message->isUnseen(),
                        'is_important' => $message->isFlagged(),
                        'size' => $message->getSize() ?? 0,
                        'preview' => $this->getEmailPreview($message),
                    ];
                } catch (\Exception $e) {
                    continue;
                }
            }

            return [
                'success' => true,
                'emails' => $emails,
                'total_count' => count($emails),
                'folder' => $folderName
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to fetch emails: ' . $e->getMessage(),
                'emails' => [],
                'total_count' => 0
            ];
        }
    }

    private function getGmailEmailsReal(array $credentials, int $limit = 100): array
    {
        try {
            // Create Gmail IMAP connection
            $client = $this->createConnection('gmail', $credentials);
            $client->connect();

            // Get INBOX folder
            $folder = $client->getFolder('INBOX');
            
            // Get messages with multiple fallback approaches
            $messages = [];
            try {
                $messages = $folder->query()->limit($limit, 0)->get();
            } catch (\Exception $e) {
                try {
                    $messages = $folder->messages()->limit($limit)->get();
                } catch (\Exception $e2) {
                    $allMessages = $folder->messages()->get();
                    $messages = array_slice($allMessages, 0, $limit);
                }
            }

            $emails = [];
            foreach ($messages as $message) {
                try {
                    $fromAddress = 'Unknown';
                    $fromName = '';
                    $fromData = $message->getFrom();
                    if ($fromData && is_array($fromData) && count($fromData) > 0) {
                        $fromAddress = $fromData[0]->mail ?? 'Unknown';
                        $fromName = $fromData[0]->personal ?? '';
                    }

                    $toAddress = 'Unknown';
                    $toData = $message->getTo();
                    if ($toData && is_array($toData) && count($toData) > 0) {
                        $toAddress = $toData[0]->mail ?? 'Unknown';
                    }

                    $attachments = [];
                    try {
                        $attachments = $message->getAttachments();
                    } catch (\Exception $e) {
                        $attachments = [];
                    }

                    $emails[] = [
                        'uid' => $message->getUid(),
                        'subject' => $message->getSubject() ?? 'No Subject',
                        'from' => $fromAddress,
                        'from_name' => $fromName,
                        'to' => $toAddress,
                        'date' => $message->getDate() ? $message->getDate()->format('Y-m-d H:i:s') : date('Y-m-d H:i:s'),
                        'has_attachments' => $message->hasAttachments(),
                        'attachment_count' => is_array($attachments) ? count($attachments) : 0,
                        'is_read' => !$message->isUnseen(),
                        'is_important' => $message->isFlagged(),
                        'size' => $message->getSize() ?? 0,
                        'preview' => $this->getEmailPreview($message),
                    ];
                } catch (\Exception $e) {
                    continue;
                }
            }

            return [
                'success' => true,
                'emails' => $emails,
                'total_count' => count($emails),
                'folder' => 'INBOX',
                'debug_info' => [
                    'provider' => 'gmail',
                    'method' => 'real_imap_connection',
                    'emails_processed' => count($emails)
                ]
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to connect to Gmail. Please ensure you are using an App Password and that IMAP is enabled in your Gmail settings. Error: ' . $e->getMessage(),
                'emails' => [],
                'total_count' => 0,
                'debug_info' => [
                    'provider' => 'gmail',
                    'method' => 'real_imap_connection',
                    'error' => $e->getMessage(),
                    'suggestion' => 'Please go to the dashboard and create a new connection with your Gmail credentials and App Password'
                ]
            ];
        }
    }

    private function getSimulatedGmailEmails(array $credentials, int $limit = 100): array
    {
        $emails = [
            [
                'uid' => 1,
                'subject' => 'Welcome to Gmail - Your Account is Ready!',
                'from' => 'noreply@gmail.com',
                'from_name' => 'Gmail Team',
                'to' => $credentials['email'],
                'date' => '2025-01-15 14:30:00',
                'has_attachments' => false,
                'attachment_count' => 0,
                'is_read' => true,
                'is_important' => false,
                'size' => 2048,
                'preview' => 'Welcome to Gmail! Your account has been successfully set up and you can now start using all the features...',
            ],
            [
                'uid' => 2,
                'subject' => 'Security Alert: New Login Detected',
                'from' => 'security-noreply@google.com',
                'from_name' => 'Google Security',
                'to' => $credentials['email'],
                'date' => '2025-01-15 12:15:00',
                'has_attachments' => false,
                'attachment_count' => 0,
                'is_read' => false,
                'is_important' => true,
                'size' => 1536,
                'preview' => 'We detected a new login to your Google account from a new device. If this was you, no action is needed...',
            ],
            [
                'uid' => 3,
                'subject' => 'Your Weekly Google Drive Storage Report',
                'from' => 'drive-noreply@google.com',
                'from_name' => 'Google Drive',
                'to' => $credentials['email'],
                'date' => '2025-01-14 09:00:00',
                'has_attachments' => true,
                'attachment_count' => 1,
                'is_read' => true,
                'is_important' => false,
                'size' => 5120,
                'preview' => 'Here is your weekly Google Drive storage report. You are currently using 2.3 GB of your 15 GB storage quota...',
            ],
            [
                'uid' => 4,
                'subject' => 'Meeting Invitation: Project Discussion',
                'from' => 'john.doe@company.com',
                'from_name' => 'John Doe',
                'to' => $credentials['email'],
                'date' => '2025-01-13 16:45:00',
                'has_attachments' => true,
                'attachment_count' => 2,
                'is_read' => false,
                'is_important' => false,
                'size' => 8192,
                'preview' => 'Hi! I would like to invite you to a meeting to discuss the new project requirements. Please find the agenda attached...',
            ],
            [
                'uid' => 5,
                'subject' => 'Newsletter: Tech Updates This Week',
                'from' => 'newsletter@techcrunch.com',
                'from_name' => 'TechCrunch Newsletter',
                'to' => $credentials['email'],
                'date' => '2025-01-12 08:30:00',
                'has_attachments' => false,
                'attachment_count' => 0,
                'is_read' => true,
                'is_important' => false,
                'size' => 3072,
                'preview' => 'This week in tech: AI developments, startup funding rounds, and the latest in mobile technology. Read more...',
            ],
            [
                'uid' => 6,
                'subject' => 'Invoice #INV-2025-001 - Payment Due',
                'from' => 'billing@serviceprovider.com',
                'from_name' => 'Service Provider Billing',
                'to' => $credentials['email'],
                'date' => '2025-01-11 14:20:00',
                'has_attachments' => true,
                'attachment_count' => 1,
                'is_read' => false,
                'is_important' => true,
                'size' => 4096,
                'preview' => 'Your invoice #INV-2025-001 is now due. Please find the detailed invoice attached. Payment is due within 30 days...',
            ],
            [
                'uid' => 7,
                'subject' => 'Social Media Notification: New Followers',
                'from' => 'notifications@linkedin.com',
                'from_name' => 'LinkedIn',
                'to' => $credentials['email'],
                'date' => '2025-01-10 11:15:00',
                'has_attachments' => false,
                'attachment_count' => 0,
                'is_read' => true,
                'is_important' => false,
                'size' => 1024,
                'preview' => 'You have 5 new followers on LinkedIn this week. Check out their profiles and expand your network...',
            ],
            [
                'uid' => 8,
                'subject' => 'Password Reset Request',
                'from' => 'security@bank.com',
                'from_name' => 'Your Bank Security',
                'to' => $credentials['email'],
                'date' => '2025-01-09 15:45:00',
                'has_attachments' => false,
                'attachment_count' => 0,
                'is_read' => false,
                'is_important' => true,
                'size' => 1792,
                'preview' => 'We received a request to reset your password. If you did not make this request, please contact us immediately...',
            ]
        ];

        // Limit the results
        $emails = array_slice($emails, 0, $limit);

        return [
            'success' => true,
            'emails' => $emails,
            'total_count' => count($emails),
            'folder' => 'INBOX',
            'debug_info' => [
                'provider' => 'gmail',
                'method' => 'simulated_data',
                'note' => 'IMAP extension not available - showing simulated Gmail emails',
                'emails_processed' => count($emails)
            ]
        ];
    }

    public function getEmailContent(string $provider, array $credentials, int $uid, ?array $customSettings = null): array
    {
        // Handle demo mode
        if ($provider === 'demo') {
            return $this->getDemoEmailContent($uid);
        }

        // For Gmail, use real IMAP connection
        if ($provider === 'gmail') {
            return $this->getGmailEmailContentReal($credentials, $uid);
        }

        try {
            $client = $this->createConnection($provider, $credentials, $customSettings);
            $client->connect();

            $folder = $client->getFolder('INBOX');
            $message = $folder->query()->getMessageByUid($uid);

            $content = [
                'uid' => $message->getUid(),
                'subject' => $message->getSubject(),
                'from' => $message->getFrom()[0]->mail ?? 'Unknown',
                'from_name' => $message->getFrom()[0]->personal ?? '',
                'to' => $message->getTo()[0]->mail ?? 'Unknown',
                'date' => $message->getDate()->format('Y-m-d H:i:s'),
                'html_content' => $message->getHTMLBody(),
                'text_content' => $message->getTextBody(),
                'attachments' => $this->getAttachmentsInfo($message),
                'headers' => $message->getHeaders(),
            ];

            return [
                'success' => true,
                'email' => $content
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to fetch email content: ' . $e->getMessage(),
                'email' => null
            ];
        }
    }

    private function getEmailPreview($message): string
    {
        try {
            $textBody = $message->getTextBody();
            if ($textBody && is_string($textBody)) {
                return substr(strip_tags($textBody), 0, 150) . '...';
            }
            
            $htmlBody = $message->getHTMLBody();
            if ($htmlBody && is_string($htmlBody)) {
                return substr(strip_tags($htmlBody), 0, 150) . '...';
            }
        } catch (\Exception $e) {
            // If we can't get the body, return a generic message
        }
        
        return 'No preview available';
    }

    private function getAttachmentsInfo($message): array
    {
        $attachments = [];
        foreach ($message->getAttachments() as $attachment) {
            $attachments[] = [
                'name' => $attachment->getName(),
                'size' => $attachment->getSize(),
                'type' => $attachment->getMimeType(),
                'disposition' => $attachment->getDisposition(),
            ];
        }
        return $attachments;
    }

    private function getDemoEmails(int $limit): array
    {
        $demoEmails = [
            [
                'uid' => 1,
                'subject' => 'Welcome to Grand EmailCleaner!',
                'from' => 'support@grandemailcleaner.com',
                'from_name' => 'Grand EmailCleaner Support',
                'to' => 'demo@emailcleaner.com',
                'date' => '2025-09-02 10:30:00',
                'has_attachments' => false,
                'attachment_count' => 0,
                'is_read' => true,
                'is_important' => false,
                'size' => 2048,
                'preview' => 'Thank you for choosing Grand EmailCleaner! This is a demo email to show you how the system works...',
            ],
            [
                'uid' => 2,
                'subject' => 'Your Email Processing Report',
                'from' => 'reports@emailcleaner.com',
                'from_name' => 'Email Reports',
                'to' => 'demo@emailcleaner.com',
                'date' => '2025-09-02 09:15:00',
                'has_attachments' => true,
                'attachment_count' => 2,
                'is_read' => false,
                'is_important' => true,
                'size' => 15360,
                'preview' => 'Here is your weekly email processing report. You have successfully cleaned 1,247 emails and saved 2.3GB of storage...',
            ],
            [
                'uid' => 3,
                'subject' => 'Meeting Reminder: Project Discussion',
                'from' => 'john.doe@company.com',
                'from_name' => 'John Doe',
                'to' => 'demo@emailcleaner.com',
                'date' => '2025-09-01 16:45:00',
                'has_attachments' => true,
                'attachment_count' => 1,
                'is_read' => true,
                'is_important' => false,
                'size' => 8192,
                'preview' => 'Hi there! Just a reminder about our meeting tomorrow at 2 PM to discuss the new project requirements...',
            ],
        ];

        return [
            'success' => true,
            'emails' => array_slice($demoEmails, 0, $limit),
            'total_count' => count($demoEmails),
            'folder' => 'INBOX'
        ];
    }

    private function getGmailEmailContentReal(array $credentials, int $uid): array
    {
        try {
            // Create Gmail IMAP connection
            $client = $this->createConnection('gmail', $credentials);
            $client->connect();

            // Get INBOX folder
            $folder = $client->getFolder('INBOX');
            $message = $folder->query()->getMessageByUid($uid);

            $content = [
                'uid' => $message->getUid(),
                'subject' => $message->getSubject() ?? 'No Subject',
                'from' => $message->getFrom()[0]->mail ?? 'Unknown',
                'from_name' => $message->getFrom()[0]->personal ?? '',
                'to' => $message->getTo()[0]->mail ?? 'Unknown',
                'date' => $message->getDate() ? $message->getDate()->format('Y-m-d H:i:s') : date('Y-m-d H:i:s'),
                'html_content' => $message->getHTMLBody(),
                'text_content' => $message->getTextBody(),
                'attachments' => $this->getAttachmentsInfo($message),
                'has_attachments' => $message->hasAttachments(),
                'attachment_count' => $message->getAttachments()->count(),
            ];

            return [
                'success' => true,
                'email' => $content
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to fetch email content: ' . $e->getMessage(),
                'email' => null
            ];
        }
    }

    private function getSimulatedGmailEmailContent(int $uid): array
    {
        $simulatedContent = [
            1 => [
                'uid' => 1,
                'subject' => 'Welcome to Gmail - Your Account is Ready!',
                'from' => 'noreply@gmail.com',
                'from_name' => 'Gmail Team',
                'to' => 'johnmuthee548@gmail.com',
                'date' => '2025-01-15 14:30:00',
                'html_content' => '<h2>Welcome to Gmail!</h2><p>Your account has been successfully set up and you can now start using all the features that Gmail has to offer.</p><p>Here are some things you can do:</p><ul><li>Send and receive emails</li><li>Organize your inbox with labels</li><li>Use powerful search to find any email</li><li>Access your emails from any device</li></ul><p>If you have any questions, please visit our Help Center.</p><p>Best regards,<br>The Gmail Team</p>',
                'text_content' => 'Welcome to Gmail!\n\nYour account has been successfully set up and you can now start using all the features that Gmail has to offer.\n\nHere are some things you can do:\n- Send and receive emails\n- Organize your inbox with labels\n- Use powerful search to find any email\n- Access your emails from any device\n\nIf you have any questions, please visit our Help Center.\n\nBest regards,\nThe Gmail Team',
                'attachments' => [],
                'has_attachments' => false,
                'attachment_count' => 0
            ],
            2 => [
                'uid' => 2,
                'subject' => 'Security Alert: New Login Detected',
                'from' => 'security-noreply@google.com',
                'from_name' => 'Google Security',
                'to' => 'johnmuthee548@gmail.com',
                'date' => '2025-01-15 12:15:00',
                'html_content' => '<h2>Security Alert</h2><p>We detected a new login to your Google account from a new device.</p><p><strong>Details:</strong></p><ul><li>Time: January 15, 2025 at 12:15 PM</li><li>Location: Nairobi, Kenya</li><li>Device: Chrome on Windows</li></ul><p>If this was you, no action is needed. If you don\'t recognize this activity, please secure your account immediately.</p><p><a href="#" style="background: #4285f4; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;">Secure Account</a></p>',
                'text_content' => 'Security Alert\n\nWe detected a new login to your Google account from a new device.\n\nDetails:\n- Time: January 15, 2025 at 12:15 PM\n- Location: Nairobi, Kenya\n- Device: Chrome on Windows\n\nIf this was you, no action is needed. If you don\'t recognize this activity, please secure your account immediately.\n\nSecure Account: [Link]',
                'attachments' => [],
                'has_attachments' => false,
                'attachment_count' => 0
            ],
            3 => [
                'uid' => 3,
                'subject' => 'Your Weekly Google Drive Storage Report',
                'from' => 'drive-noreply@google.com',
                'from_name' => 'Google Drive',
                'to' => 'johnmuthee548@gmail.com',
                'date' => '2025-01-14 09:00:00',
                'html_content' => '<h2>Weekly Storage Report</h2><p>Here is your weekly Google Drive storage report.</p><p><strong>Storage Usage:</strong></p><ul><li>Used: 2.3 GB of 15 GB</li><li>Available: 12.7 GB</li><li>Usage: 15%</li></ul><p>Your storage is in good shape! You still have plenty of space available.</p><p>Need more storage? <a href="#">Upgrade to Google One</a></p>',
                'text_content' => 'Weekly Storage Report\n\nHere is your weekly Google Drive storage report.\n\nStorage Usage:\n- Used: 2.3 GB of 15 GB\n- Available: 12.7 GB\n- Usage: 15%\n\nYour storage is in good shape! You still have plenty of space available.\n\nNeed more storage? Upgrade to Google One: [Link]',
                'attachments' => [
                    ['name' => 'storage_report.pdf', 'size' => 245760, 'type' => 'application/pdf']
                ],
                'has_attachments' => true,
                'attachment_count' => 1
            ],
            4 => [
                'uid' => 4,
                'subject' => 'Meeting Invitation: Project Discussion',
                'from' => 'john.doe@company.com',
                'from_name' => 'John Doe',
                'to' => 'johnmuthee548@gmail.com',
                'date' => '2025-01-13 16:45:00',
                'html_content' => '<h2>Meeting Invitation</h2><p>Hi!</p><p>I would like to invite you to a meeting to discuss the new project requirements. Please find the agenda and project brief attached.</p><p><strong>Meeting Details:</strong></p><ul><li>Date: January 20, 2025</li><li>Time: 2:00 PM - 3:30 PM</li><li>Location: Conference Room A</li></ul><p>Please let me know if you can attend.</p><p>Best regards,<br>John Doe</p>',
                'text_content' => 'Meeting Invitation\n\nHi!\n\nI would like to invite you to a meeting to discuss the new project requirements. Please find the agenda and project brief attached.\n\nMeeting Details:\n- Date: January 20, 2025\n- Time: 2:00 PM - 3:30 PM\n- Location: Conference Room A\n\nPlease let me know if you can attend.\n\nBest regards,\nJohn Doe',
                'attachments' => [
                    ['name' => 'project_agenda.docx', 'size' => 51200, 'type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
                    ['name' => 'project_brief.pdf', 'size' => 102400, 'type' => 'application/pdf']
                ],
                'has_attachments' => true,
                'attachment_count' => 2
            ],
            5 => [
                'uid' => 5,
                'subject' => 'Newsletter: Tech Updates This Week',
                'from' => 'newsletter@techcrunch.com',
                'from_name' => 'TechCrunch Newsletter',
                'to' => 'johnmuthee548@gmail.com',
                'date' => '2025-01-12 08:30:00',
                'html_content' => '<h2>Tech Updates This Week</h2><p>This week in tech: AI developments, startup funding rounds, and the latest in mobile technology.</p><h3>Top Stories:</h3><ul><li>OpenAI releases new GPT model</li><li>Apple announces new iPhone features</li><li>Google updates search algorithm</li></ul><p>Read more on our website!</p>',
                'text_content' => 'Tech Updates This Week\n\nThis week in tech: AI developments, startup funding rounds, and the latest in mobile technology.\n\nTop Stories:\n- OpenAI releases new GPT model\n- Apple announces new iPhone features\n- Google updates search algorithm\n\nRead more on our website!',
                'attachments' => [],
                'has_attachments' => false,
                'attachment_count' => 0
            ],
            6 => [
                'uid' => 6,
                'subject' => 'Invoice #INV-2025-001 - Payment Due',
                'from' => 'billing@serviceprovider.com',
                'from_name' => 'Service Provider Billing',
                'to' => 'johnmuthee548@gmail.com',
                'date' => '2025-01-11 14:20:00',
                'html_content' => '<h2>Invoice #INV-2025-001</h2><p>Your invoice is now due. Please find the detailed invoice attached.</p><p><strong>Amount Due:</strong> $299.00</p><p><strong>Due Date:</strong> February 10, 2025</p><p>Payment is due within 30 days. You can pay online through our secure portal.</p><p>Thank you for your business!</p>',
                'text_content' => 'Invoice #INV-2025-001\n\nYour invoice is now due. Please find the detailed invoice attached.\n\nAmount Due: $299.00\nDue Date: February 10, 2025\n\nPayment is due within 30 days. You can pay online through our secure portal.\n\nThank you for your business!',
                'attachments' => [
                    ['name' => 'invoice_INV-2025-001.pdf', 'size' => 81920, 'type' => 'application/pdf']
                ],
                'has_attachments' => true,
                'attachment_count' => 1
            ],
            7 => [
                'uid' => 7,
                'subject' => 'Social Media Notification: New Followers',
                'from' => 'notifications@linkedin.com',
                'from_name' => 'LinkedIn',
                'to' => 'johnmuthee548@gmail.com',
                'date' => '2025-01-10 11:15:00',
                'html_content' => '<h2>New Followers This Week</h2><p>You have 5 new followers on LinkedIn this week!</p><p>Check out their profiles and expand your network:</p><ul><li>Sarah Johnson - Software Engineer</li><li>Mike Chen - Product Manager</li><li>Emily Davis - UX Designer</li><li>David Wilson - Marketing Director</li><li>Lisa Brown - Data Scientist</li></ul>',
                'text_content' => 'New Followers This Week\n\nYou have 5 new followers on LinkedIn this week!\n\nCheck out their profiles and expand your network:\n- Sarah Johnson - Software Engineer\n- Mike Chen - Product Manager\n- Emily Davis - UX Designer\n- David Wilson - Marketing Director\n- Lisa Brown - Data Scientist',
                'attachments' => [],
                'has_attachments' => false,
                'attachment_count' => 0
            ],
            8 => [
                'uid' => 8,
                'subject' => 'Password Reset Request',
                'from' => 'security@bank.com',
                'from_name' => 'Your Bank Security',
                'to' => 'johnmuthee548@gmail.com',
                'date' => '2025-01-09 15:45:00',
                'html_content' => '<h2>Password Reset Request</h2><p>We received a request to reset your password for your online banking account.</p><p>If you did not make this request, please contact us immediately at 1-800-BANK-HELP.</p><p>If you did request this reset, please click the link below to create a new password:</p><p><a href="#" style="background: #dc3545; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;">Reset Password</a></p><p>This link will expire in 24 hours.</p>',
                'text_content' => 'Password Reset Request\n\nWe received a request to reset your password for your online banking account.\n\nIf you did not make this request, please contact us immediately at 1-800-BANK-HELP.\n\nIf you did request this reset, please click the link below to create a new password:\n\nReset Password: [Link]\n\nThis link will expire in 24 hours.',
                'attachments' => [],
                'has_attachments' => false,
                'attachment_count' => 0
            ]
        ];

        if (isset($simulatedContent[$uid])) {
            return [
                'success' => true,
                'email' => $simulatedContent[$uid]
            ];
        }

        return [
            'success' => false,
            'message' => 'Email not found',
            'email' => null
        ];
    }

    private function getDemoEmailContent(int $uid): array
    {
        $demoContent = [
            1 => [
                'uid' => 1,
                'subject' => 'Welcome to Grand EmailCleaner!',
                'from' => 'support@grandemailcleaner.com',
                'from_name' => 'Grand EmailCleaner Support',
                'to' => 'demo@emailcleaner.com',
                'date' => '2025-09-02 10:30:00',
                'html_content' => '<h2>Welcome to Grand EmailCleaner!</h2><p>Thank you for choosing our advanced email management solution.</p><p>This is a demo email to show you how the system works.</p>',
                'text_content' => 'Welcome to Grand EmailCleaner!\n\nThank you for choosing our advanced email management solution.\n\nThis is a demo email to show you how the system works.',
                'attachments' => [],
                'headers' => [],
            ],
            2 => [
                'uid' => 2,
                'subject' => 'Your Email Processing Report',
                'from' => 'reports@emailcleaner.com',
                'from_name' => 'Email Reports',
                'to' => 'demo@emailcleaner.com',
                'date' => '2025-09-02 09:15:00',
                'html_content' => '<h2>Email Processing Report</h2><p>Here is your weekly email processing report.</p><p>You have successfully cleaned 1,247 emails and saved 2.3GB of storage.</p>',
                'text_content' => 'Email Processing Report\n\nHere is your weekly email processing report.\n\nYou have successfully cleaned 1,247 emails and saved 2.3GB of storage.',
                'attachments' => [
                    ['name' => 'report.pdf', 'size' => 1024000, 'type' => 'application/pdf', 'disposition' => 'attachment'],
                    ['name' => 'data.xlsx', 'size' => 512000, 'type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'disposition' => 'attachment'],
                ],
                'headers' => [],
            ],
        ];

        return [
            'success' => true,
            'email' => $demoContent[$uid] ?? $demoContent[1]
        ];
    }
}
