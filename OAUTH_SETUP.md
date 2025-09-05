# OAuth 2.0 Setup Guide for EmailCleaner

This guide will help you set up OAuth 2.0 authentication for Gmail, Outlook, and Yahoo Mail providers.

## Environment Configuration

Add these variables to your `.env` file:

```env
# Gmail OAuth Configuration
GMAIL_CLIENT_ID=your_gmail_client_id_here
GMAIL_CLIENT_SECRET=your_gmail_client_secret_here

# Outlook/Microsoft OAuth Configuration
OUTLOOK_CLIENT_ID=your_outlook_client_id_here
OUTLOOK_CLIENT_SECRET=your_outlook_client_secret_here

# Yahoo OAuth Configuration
YAHOO_CLIENT_ID=your_yahoo_client_id_here
YAHOO_CLIENT_SECRET=your_yahoo_client_secret_here

# Application URL (used for OAuth redirects)
APP_URL=http://127.0.0.1:8000
```

## Provider Setup Instructions

### 1. Gmail OAuth Setup

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select an existing one
3. Enable the Gmail API:
   - Go to "APIs & Services" > "Library"
   - Search for "Gmail API" and enable it
4. Create OAuth 2.0 credentials:
   - Go to "APIs & Services" > "Credentials"
   - Click "Create Credentials" > "OAuth 2.0 Client IDs"
   - Choose "Web application"
   - Add authorized redirect URI: `http://127.0.0.1:8000/oauth/gmail/callback`
   - Copy the Client ID and Client Secret to your `.env` file

### 2. Outlook/Microsoft OAuth Setup

1. Go to [Azure Portal](https://portal.azure.com/)
2. Navigate to "Azure Active Directory" > "App registrations"
3. Click "New registration"
4. Fill in the details:
   - Name: "EmailCleaner"
   - Supported account types: "Accounts in any organizational directory and personal Microsoft accounts"
   - Redirect URI: `http://127.0.0.1:8000/oauth/outlook/callback`
5. After creation, go to "API permissions":
   - Add "Microsoft Graph" permissions:
     - `Mail.Read` (Delegated)
     - `User.Read` (Delegated)
6. Go to "Certificates & secrets":
   - Create a new client secret
   - Copy the Application (client) ID and the client secret to your `.env` file

### 3. Yahoo OAuth Setup

1. Go to [Yahoo Developer Network](https://developer.yahoo.com/)
2. Sign in with your Yahoo account
3. Create a new application:
   - Go to "My Apps" > "Create an App"
   - Choose "Web Application"
   - Set redirect URI: `http://127.0.0.1:8000/oauth/yahoo/callback`
   - Request permissions: `mail-r`, `openid`, `profile`, `email`
4. Copy the Client ID and Client Secret to your `.env` file

## Testing the Setup

1. Start your Laravel application: `php artisan serve`
2. Navigate to `http://127.0.0.1:8000/dashboard`
3. Click on any provider card to test the OAuth flow
4. You should be redirected to the provider's authorization page
5. After authorization, you'll be redirected back to the dashboard

## Security Notes

- OAuth 2.0 provides much better security than password-based authentication
- Access tokens are encrypted and stored temporarily
- Users can revoke access at any time from their provider's security settings
- No passwords are stored in the application

## Troubleshooting

### Common Issues:

1. **"Invalid redirect URI"**: Make sure the redirect URI in your OAuth app matches exactly: `http://127.0.0.1:8000/oauth/{provider}/callback`

2. **"Client ID not found"**: Verify that your environment variables are set correctly and restart your application

3. **"Insufficient permissions"**: Make sure you've granted the required permissions in your OAuth app configuration

4. **"Token expired"**: The application will automatically refresh tokens when possible

### For Production:

- Update `APP_URL` to your production domain
- Update all redirect URIs in your OAuth apps to use HTTPS
- Consider using environment-specific OAuth apps for better security
