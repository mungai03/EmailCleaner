<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Exception;

class OAuthService
{
    private array $providerConfigs = [];

    public function __construct()
    {
        $this->providerConfigs = [
            'gmail' => [
                'client_id' => env('GMAIL_CLIENT_ID'),
                'client_secret' => env('GMAIL_CLIENT_SECRET'),
                'redirect_uri' => env('APP_URL') . '/oauth/gmail/callback',
                'auth_url' => 'https://accounts.google.com/o/oauth2/v2/auth',
                'token_url' => 'https://oauth2.googleapis.com/token',
                'user_info_url' => 'https://www.googleapis.com/oauth2/v2/userinfo',
                'revoke_url' => 'https://oauth2.googleapis.com/revoke',
                'scopes' => [
                    'https://www.googleapis.com/auth/gmail.readonly',
                    'https://www.googleapis.com/auth/userinfo.email',
                    'https://www.googleapis.com/auth/userinfo.profile'
                ]
            ],
            'outlook' => [
                'client_id' => env('OUTLOOK_CLIENT_ID'),
                'client_secret' => env('OUTLOOK_CLIENT_SECRET'),
                'redirect_uri' => env('APP_URL') . '/oauth/outlook/callback',
                'auth_url' => 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize',
                'token_url' => 'https://login.microsoftonline.com/common/oauth2/v2.0/token',
                'user_info_url' => 'https://graph.microsoft.com/v1.0/me',
                'revoke_url' => 'https://graph.microsoft.com/v1.0/me/revokeSignInSessions',
                'scopes' => [
                    'https://graph.microsoft.com/Mail.Read',
                    'https://graph.microsoft.com/User.Read'
                ]
            ],
            'yahoo' => [
                'client_id' => env('YAHOO_CLIENT_ID'),
                'client_secret' => env('YAHOO_CLIENT_SECRET'),
                'redirect_uri' => env('APP_URL') . '/oauth/yahoo/callback',
                'auth_url' => 'https://api.login.yahoo.com/oauth2/request_auth',
                'token_url' => 'https://api.login.yahoo.com/oauth2/get_token',
                'user_info_url' => 'https://api.login.yahoo.com/openid/v1/userinfo',
                'revoke_url' => 'https://api.login.yahoo.com/oauth2/revoke',
                'scopes' => [
                    'mail-r',
                    'openid',
                    'profile',
                    'email'
                ]
            ]
        ];
    }

    public function getAuthorizationUrl(string $provider): string
    {
        $config = $this->getProviderConfig($provider);
        $state = Str::random(40);
        
        // Store state in session for validation
        session(['oauth_state_' . $provider => $state]);

        $params = [
            'client_id' => $config['client_id'],
            'redirect_uri' => $config['redirect_uri'],
            'scope' => implode(' ', $config['scopes']),
            'response_type' => 'code',
            'state' => $state,
            'access_type' => 'offline',
            'prompt' => 'consent'
        ];

        return $config['auth_url'] . '?' . http_build_query($params);
    }

    public function exchangeCodeForTokens(string $provider, string $code, string $state): array
    {
        $config = $this->getProviderConfig($provider);
        
        // Validate state
        $storedState = session('oauth_state_' . $provider);
        if (!$storedState || $storedState !== $state) {
            throw new Exception('Invalid state parameter');
        }

        $response = Http::asForm()->post($config['token_url'], [
            'client_id' => $config['client_id'],
            'client_secret' => $config['client_secret'],
            'code' => $code,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $config['redirect_uri'],
        ]);

        if (!$response->successful()) {
            throw new Exception('Failed to exchange code for tokens: ' . $response->body());
        }

        $tokens = $response->json();
        
        if (!isset($tokens['access_token'])) {
            throw new Exception('Access token not received');
        }

        return $tokens;
    }

    public function getUserInfo(string $provider, string $accessToken): array
    {
        $config = $this->getProviderConfig($provider);
        
        $response = Http::withToken($accessToken)->get($config['user_info_url']);
        
        if (!$response->successful()) {
            throw new Exception('Failed to get user info: ' . $response->body());
        }

        $userInfo = $response->json();
        
        // Normalize user info across providers
        return $this->normalizeUserInfo($provider, $userInfo);
    }

    public function refreshTokens(string $provider, string $refreshToken): array
    {
        $config = $this->getProviderConfig($provider);
        
        $response = Http::asForm()->post($config['token_url'], [
            'client_id' => $config['client_id'],
            'client_secret' => $config['client_secret'],
            'refresh_token' => $refreshToken,
            'grant_type' => 'refresh_token',
        ]);

        if (!$response->successful()) {
            throw new Exception('Failed to refresh tokens: ' . $response->body());
        }

        return $response->json();
    }

    public function revokeTokens(string $provider, array $tokens): bool
    {
        $config = $this->getProviderConfig($provider);
        
        try {
            $response = Http::asForm()->post($config['revoke_url'], [
                'token' => $tokens['access_token'] ?? $tokens['refresh_token']
            ]);
            
            return $response->successful();
        } catch (Exception $e) {
            // Log but don't throw - revocation is not critical
            \Log::warning('Failed to revoke tokens: ' . $e->getMessage());
            return false;
        }
    }

    public function testOAuthConnection(string $provider, array $tokens): int
    {
        try {
            // For now, return a mock count. In a real implementation,
            // you would use the OAuth tokens to connect to the email API
            // and get the actual email count
            
            switch ($provider) {
                case 'gmail':
                    return $this->getGmailEmailCount($tokens['access_token']);
                case 'outlook':
                    return $this->getOutlookEmailCount($tokens['access_token']);
                case 'yahoo':
                    return $this->getYahooEmailCount($tokens['access_token']);
                default:
                    return 0;
            }
        } catch (Exception $e) {
            \Log::error('OAuth connection test failed: ' . $e->getMessage());
            return 0;
        }
    }

    public function encryptTokens(array $tokens): string
    {
        return Crypt::encryptString(json_encode($tokens));
    }

    public function decryptTokens(string $encryptedTokens): array
    {
        return json_decode(Crypt::decryptString($encryptedTokens), true);
    }

    public function getSupportedProviders(): array
    {
        return array_keys($this->providerConfigs);
    }

    public function isProviderConfigured(string $provider): bool
    {
        $config = $this->getProviderConfig($provider);
        return !empty($config['client_id']) && !empty($config['client_secret']);
    }

    private function getProviderConfig(string $provider): array
    {
        if (!isset($this->providerConfigs[$provider])) {
            throw new Exception("Unsupported OAuth provider: {$provider}");
        }

        $config = $this->providerConfigs[$provider];
        
        if (empty($config['client_id']) || empty($config['client_secret'])) {
            throw new Exception("OAuth provider {$provider} is not properly configured");
        }

        return $config;
    }

    private function normalizeUserInfo(string $provider, array $userInfo): array
    {
        switch ($provider) {
            case 'gmail':
                return [
                    'email' => $userInfo['email'] ?? '',
                    'name' => $userInfo['name'] ?? '',
                    'id' => $userInfo['id'] ?? '',
                    'picture' => $userInfo['picture'] ?? '',
                    'provider' => 'gmail'
                ];
            case 'outlook':
                return [
                    'email' => $userInfo['mail'] ?? $userInfo['userPrincipalName'] ?? '',
                    'name' => $userInfo['displayName'] ?? '',
                    'id' => $userInfo['id'] ?? '',
                    'picture' => null, // Outlook doesn't provide profile picture in basic scope
                    'provider' => 'outlook'
                ];
            case 'yahoo':
                return [
                    'email' => $userInfo['email'] ?? '',
                    'name' => $userInfo['name'] ?? '',
                    'id' => $userInfo['sub'] ?? '',
                    'picture' => $userInfo['picture'] ?? '',
                    'provider' => 'yahoo'
                ];
            default:
                return $userInfo;
        }
    }

    private function getGmailEmailCount(string $accessToken): int
    {
        try {
            $response = Http::withToken($accessToken)
                ->get('https://gmail.googleapis.com/gmail/v1/users/me/messages', [
                    'maxResults' => 1
                ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['resultSizeEstimate'] ?? 0;
            }
        } catch (Exception $e) {
            \Log::error('Gmail email count error: ' . $e->getMessage());
        }
        
        return 0;
    }

    private function getOutlookEmailCount(string $accessToken): int
    {
        try {
            $response = Http::withToken($accessToken)
                ->get('https://graph.microsoft.com/v1.0/me/mailFolders/inbox/messages', [
                    '$count' => 'true',
                    '$top' => 1
                ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['@odata.count'] ?? 0;
            }
        } catch (Exception $e) {
            \Log::error('Outlook email count error: ' . $e->getMessage());
        }
        
        return 0;
    }

    private function getYahooEmailCount(string $accessToken): int
    {
        // Yahoo doesn't have a simple email count API
        // This would require more complex implementation
        return 0;
    }
}
