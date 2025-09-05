<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class OAuthEmailService
{
    public function getEmails(string $provider, array $tokens, int $limit = 50, int $offset = 0): array
    {
        switch ($provider) {
            case 'gmail':
                return $this->getGmailEmails($tokens, $limit, $offset);
            case 'outlook':
                return $this->getOutlookEmails($tokens, $limit, $offset);
            case 'yahoo':
                return $this->getYahooEmails($tokens, $limit, $offset);
            default:
                throw new Exception("Unsupported OAuth provider: {$provider}");
        }
    }

    public function getEmailContent(string $provider, array $tokens, string $emailId): array
    {
        switch ($provider) {
            case 'gmail':
                return $this->getGmailEmailContent($tokens, $emailId);
            case 'outlook':
                return $this->getOutlookEmailContent($tokens, $emailId);
            case 'yahoo':
                return $this->getYahooEmailContent($tokens, $emailId);
            default:
                throw new Exception("Unsupported OAuth provider: {$provider}");
        }
    }

    public function getFolders(string $provider, array $tokens): array
    {
        switch ($provider) {
            case 'gmail':
                return $this->getGmailFolders($tokens);
            case 'outlook':
                return $this->getOutlookFolders($tokens);
            case 'yahoo':
                return $this->getYahooFolders($tokens);
            default:
                throw new Exception("Unsupported OAuth provider: {$provider}");
        }
    }

    public function getEmailsFromFolder(string $provider, array $tokens, string $folderId, int $limit = 50): array
    {
        switch ($provider) {
            case 'gmail':
                return $this->getGmailEmailsFromFolder($tokens, $folderId, $limit);
            case 'outlook':
                return $this->getOutlookEmailsFromFolder($tokens, $folderId, $limit);
            case 'yahoo':
                return $this->getYahooEmailsFromFolder($tokens, $folderId, $limit);
            default:
                throw new Exception("Unsupported OAuth provider: {$provider}");
        }
    }

    private function getGmailEmails(array $tokens, int $limit, int $offset): array
    {
        try {
            $response = Http::withToken($tokens['access_token'])
                ->get('https://gmail.googleapis.com/gmail/v1/users/me/messages', [
                    'maxResults' => $limit,
                    'pageToken' => $offset > 0 ? base64_encode($offset) : null
                ]);

            if (!$response->successful()) {
                throw new Exception('Failed to fetch Gmail messages: ' . $response->body());
            }

            $data = $response->json();
            $emails = [];

            foreach ($data['messages'] ?? [] as $message) {
                $emailDetail = $this->getGmailEmailContent($tokens, $message['id']);
                if ($emailDetail['success']) {
                    $emails[] = $emailDetail['email'];
                }
            }

            return [
                'success' => true,
                'emails' => $emails,
                'total_count' => $data['resultSizeEstimate'] ?? count($emails),
                'folder' => 'INBOX'
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to fetch Gmail emails: ' . $e->getMessage(),
                'emails' => [],
                'total_count' => 0
            ];
        }
    }

    private function getGmailEmailContent(array $tokens, string $messageId): array
    {
        try {
            $response = Http::withToken($tokens['access_token'])
                ->get("https://gmail.googleapis.com/gmail/v1/users/me/messages/{$messageId}");

            if (!$response->successful()) {
                throw new Exception('Failed to fetch Gmail message: ' . $response->body());
            }

            $message = $response->json();
            $headers = $this->parseGmailHeaders($message['payload']['headers'] ?? []);

            $body = $this->extractGmailBody($message['payload']);

            return [
                'success' => true,
                'email' => [
                    'uid' => $messageId,
                    'subject' => $headers['subject'] ?? 'No Subject',
                    'from' => $headers['from'] ?? 'Unknown',
                    'from_name' => $this->extractNameFromEmail($headers['from'] ?? ''),
                    'to' => $headers['to'] ?? 'Unknown',
                    'date' => $headers['date'] ?? date('Y-m-d H:i:s'),
                    'html_content' => $body['html'] ?? '',
                    'text_content' => $body['text'] ?? '',
                    'has_attachments' => $this->hasGmailAttachments($message['payload']),
                    'attachment_count' => $this->countGmailAttachments($message['payload']),
                    'size' => $message['sizeEstimate'] ?? 0,
                    'preview' => $this->createPreview($body['text'] ?? $body['html'] ?? ''),
                ]
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to fetch Gmail email content: ' . $e->getMessage(),
                'email' => null
            ];
        }
    }

    private function getGmailFolders(array $tokens): array
    {
        try {
            $response = Http::withToken($tokens['access_token'])
                ->get('https://gmail.googleapis.com/gmail/v1/users/me/labels');

            if (!$response->successful()) {
                throw new Exception('Failed to fetch Gmail labels: ' . $response->body());
            }

            $data = $response->json();
            $folders = [];

            foreach ($data['labels'] ?? [] as $label) {
                if ($label['type'] === 'user' || in_array($label['name'], ['INBOX', 'SENT', 'DRAFT', 'SPAM', 'TRASH'])) {
                    $folders[] = $label['name'];
                }
            }

            return [
                'success' => true,
                'folders' => $folders
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to fetch Gmail folders: ' . $e->getMessage(),
                'folders' => ['INBOX']
            ];
        }
    }

    private function getGmailEmailsFromFolder(array $tokens, string $folderId, int $limit): array
    {
        try {
            $response = Http::withToken($tokens['access_token'])
                ->get('https://gmail.googleapis.com/gmail/v1/users/me/messages', [
                    'labelIds' => $folderId,
                    'maxResults' => $limit
                ]);

            if (!$response->successful()) {
                throw new Exception('Failed to fetch Gmail messages from folder: ' . $response->body());
            }

            $data = $response->json();
            $emails = [];

            foreach ($data['messages'] ?? [] as $message) {
                $emailDetail = $this->getGmailEmailContent($tokens, $message['id']);
                if ($emailDetail['success']) {
                    $emails[] = $emailDetail['email'];
                }
            }

            return [
                'success' => true,
                'emails' => $emails,
                'total_count' => $data['resultSizeEstimate'] ?? count($emails),
                'folder' => $folderId
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to fetch Gmail emails from folder: ' . $e->getMessage(),
                'emails' => [],
                'total_count' => 0
            ];
        }
    }

    private function getOutlookEmails(array $tokens, int $limit, int $offset): array
    {
        try {
            $response = Http::withToken($tokens['access_token'])
                ->get('https://graph.microsoft.com/v1.0/me/mailFolders/inbox/messages', [
                    '$top' => $limit,
                    '$skip' => $offset,
                    '$orderby' => 'receivedDateTime desc'
                ]);

            if (!$response->successful()) {
                throw new Exception('Failed to fetch Outlook messages: ' . $response->body());
            }

            $data = $response->json();
            $emails = [];

            foreach ($data['value'] ?? [] as $message) {
                $emails[] = [
                    'uid' => $message['id'],
                    'subject' => $message['subject'] ?? 'No Subject',
                    'from' => $message['from']['emailAddress']['address'] ?? 'Unknown',
                    'from_name' => $message['from']['emailAddress']['name'] ?? '',
                    'to' => $message['toRecipients'][0]['emailAddress']['address'] ?? 'Unknown',
                    'date' => $message['receivedDateTime'] ?? date('Y-m-d H:i:s'),
                    'html_content' => $message['body']['content'] ?? '',
                    'text_content' => strip_tags($message['body']['content'] ?? ''),
                    'has_attachments' => $message['hasAttachments'] ?? false,
                    'attachment_count' => count($message['attachments'] ?? []),
                    'size' => $message['size'] ?? 0,
                    'preview' => $this->createPreview($message['bodyPreview'] ?? ''),
                ];
            }

            return [
                'success' => true,
                'emails' => $emails,
                'total_count' => count($emails),
                'folder' => 'INBOX'
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to fetch Outlook emails: ' . $e->getMessage(),
                'emails' => [],
                'total_count' => 0
            ];
        }
    }

    private function getOutlookEmailContent(array $tokens, string $messageId): array
    {
        try {
            $response = Http::withToken($tokens['access_token'])
                ->get("https://graph.microsoft.com/v1.0/me/messages/{$messageId}");

            if (!$response->successful()) {
                throw new Exception('Failed to fetch Outlook message: ' . $response->body());
            }

            $message = $response->json();

            return [
                'success' => true,
                'email' => [
                    'uid' => $message['id'],
                    'subject' => $message['subject'] ?? 'No Subject',
                    'from' => $message['from']['emailAddress']['address'] ?? 'Unknown',
                    'from_name' => $message['from']['emailAddress']['name'] ?? '',
                    'to' => $message['toRecipients'][0]['emailAddress']['address'] ?? 'Unknown',
                    'date' => $message['receivedDateTime'] ?? date('Y-m-d H:i:s'),
                    'html_content' => $message['body']['content'] ?? '',
                    'text_content' => strip_tags($message['body']['content'] ?? ''),
                    'has_attachments' => $message['hasAttachments'] ?? false,
                    'attachment_count' => count($message['attachments'] ?? []),
                    'size' => $message['size'] ?? 0,
                    'preview' => $this->createPreview($message['bodyPreview'] ?? ''),
                ]
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to fetch Outlook email content: ' . $e->getMessage(),
                'email' => null
            ];
        }
    }

    private function getOutlookFolders(array $tokens): array
    {
        try {
            $response = Http::withToken($tokens['access_token'])
                ->get('https://graph.microsoft.com/v1.0/me/mailFolders');

            if (!$response->successful()) {
                throw new Exception('Failed to fetch Outlook folders: ' . $response->body());
            }

            $data = $response->json();
            $folders = [];

            foreach ($data['value'] ?? [] as $folder) {
                $folders[] = $folder['displayName'];
            }

            return [
                'success' => true,
                'folders' => $folders
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to fetch Outlook folders: ' . $e->getMessage(),
                'folders' => ['INBOX']
            ];
        }
    }

    private function getOutlookEmailsFromFolder(array $tokens, string $folderId, int $limit): array
    {
        try {
            $response = Http::withToken($tokens['access_token'])
                ->get("https://graph.microsoft.com/v1.0/me/mailFolders/{$folderId}/messages", [
                    '$top' => $limit,
                    '$orderby' => 'receivedDateTime desc'
                ]);

            if (!$response->successful()) {
                throw new Exception('Failed to fetch Outlook messages from folder: ' . $response->body());
            }

            $data = $response->json();
            $emails = [];

            foreach ($data['value'] ?? [] as $message) {
                $emails[] = [
                    'uid' => $message['id'],
                    'subject' => $message['subject'] ?? 'No Subject',
                    'from' => $message['from']['emailAddress']['address'] ?? 'Unknown',
                    'from_name' => $message['from']['emailAddress']['name'] ?? '',
                    'to' => $message['toRecipients'][0]['emailAddress']['address'] ?? 'Unknown',
                    'date' => $message['receivedDateTime'] ?? date('Y-m-d H:i:s'),
                    'html_content' => $message['body']['content'] ?? '',
                    'text_content' => strip_tags($message['body']['content'] ?? ''),
                    'has_attachments' => $message['hasAttachments'] ?? false,
                    'attachment_count' => count($message['attachments'] ?? []),
                    'size' => $message['size'] ?? 0,
                    'preview' => $this->createPreview($message['bodyPreview'] ?? ''),
                ];
            }

            return [
                'success' => true,
                'emails' => $emails,
                'total_count' => count($emails),
                'folder' => $folderId
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to fetch Outlook emails from folder: ' . $e->getMessage(),
                'emails' => [],
                'total_count' => 0
            ];
        }
    }

    private function getYahooEmails(array $tokens, int $limit, int $offset): array
    {
        // Yahoo OAuth implementation would go here
        // For now, return empty result
        return [
            'success' => false,
            'message' => 'Yahoo OAuth implementation not yet available',
            'emails' => [],
            'total_count' => 0
        ];
    }

    private function getYahooEmailContent(array $tokens, string $emailId): array
    {
        return [
            'success' => false,
            'message' => 'Yahoo OAuth implementation not yet available',
            'email' => null
        ];
    }

    private function getYahooFolders(array $tokens): array
    {
        return [
            'success' => false,
            'message' => 'Yahoo OAuth implementation not yet available',
            'folders' => ['INBOX']
        ];
    }

    private function getYahooEmailsFromFolder(array $tokens, string $folderId, int $limit): array
    {
        return [
            'success' => false,
            'message' => 'Yahoo OAuth implementation not yet available',
            'emails' => [],
            'total_count' => 0
        ];
    }

    // Helper methods
    private function parseGmailHeaders(array $headers): array
    {
        $parsed = [];
        foreach ($headers as $header) {
            $parsed[strtolower($header['name'])] = $header['value'];
        }
        return $parsed;
    }

    private function extractGmailBody(array $payload): array
    {
        $html = '';
        $text = '';

        if (isset($payload['body']['data'])) {
            $content = base64_decode(str_replace(['-', '_'], ['+', '/'], $payload['body']['data']));
            if ($payload['mimeType'] === 'text/html') {
                $html = $content;
            } else {
                $text = $content;
            }
        }

        if (isset($payload['parts'])) {
            foreach ($payload['parts'] as $part) {
                $partContent = $this->extractGmailBody($part);
                $html .= $partContent['html'];
                $text .= $partContent['text'];
            }
        }

        return ['html' => $html, 'text' => $text];
    }

    private function hasGmailAttachments(array $payload): bool
    {
        if (isset($payload['parts'])) {
            foreach ($payload['parts'] as $part) {
                if (isset($part['filename']) && !empty($part['filename'])) {
                    return true;
                }
                if (isset($part['parts']) && $this->hasGmailAttachments($part)) {
                    return true;
                }
            }
        }
        return false;
    }

    private function countGmailAttachments(array $payload): int
    {
        $count = 0;
        if (isset($payload['parts'])) {
            foreach ($payload['parts'] as $part) {
                if (isset($part['filename']) && !empty($part['filename'])) {
                    $count++;
                }
                if (isset($part['parts'])) {
                    $count += $this->countGmailAttachments($part);
                }
            }
        }
        return $count;
    }

    private function extractNameFromEmail(string $email): string
    {
        if (preg_match('/^(.+?)\s*<(.+)>$/', $email, $matches)) {
            return trim($matches[1], '"');
        }
        return '';
    }

    private function createPreview(string $content): string
    {
        $preview = strip_tags($content);
        return strlen($preview) > 150 ? substr($preview, 0, 150) . '...' : $preview;
    }
}
