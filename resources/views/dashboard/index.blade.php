<!DOCTYPE html>
<html lang="en">
@include('layout.includes.head')

<body class="bg-gray-950 text-gray-100 font-sans">
    @include('layout.includes.nav')

    <main class="min-h-screen pt-20">
        <!-- Dashboard Header -->
        <section class="relative py-16">
            <div class="absolute inset-0 bg-hero opacity-[.03]"></div>
            <div class="max-w-6xl mx-auto dkslaoeyhnmj lg:px-12 relative z-10">
                <div class="text-center space-y-6">
                    <div class="space-y-2">
                        <h2 class="text-green-500 text-xl md:text-2xl font-semibold">Email Processing</h2>
                        <h1 class="text-4xl lg:text-6xl font-bold font-code tracking-tight text-white">
                            Dashboard
                        </h1>
                    </div>
                    <p class="text-lg text-gray-300 max-w-xl mx-auto leading-relaxed">
                        Connect your email account and start converting your emails to organized Word documents with real-time analytics.
                    </p>
                </div>
            </div>
        </section>

        <!-- Connection Form -->
        <section class="py-16">
            <div class="max-w-4xl mx-auto dkslaoeyhnmj lg:px-12">
                <div class="bg-gray-900 border border-gray-800 rounded-lg p-8" x-data="emailConnection()">
                    <h3 class="text-2xl font-bold text-white mb-6 flex layhetgsjdcb gap-3">
                        <i class="fas fa-plug text-green-400"></i>
                        Connect Your Email Account
                    </h3>

                    <!-- Provider Selection -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-300 mb-3">Email Provider</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($supported_providers as $provider)
                            <button @click="selectedProvider = '{{ $provider }}'"
                                    :class="selectedProvider === '{{ $provider }}' ? 'border-green-400 bg-green-400/10' : 'border-gray-700 hover:border-gray-600'"
                                    class="p-4 border-2 rounded-lg transition-all text-center">
                                <i class="fas fa-envelope text-2xl mb-2"
                                   :class="selectedProvider === '{{ $provider }}' ? 'text-green-400' : 'text-gray-400'"></i>
                                <div class="text-sm font-medium"
                                     :class="selectedProvider === '{{ $provider }}' ? 'text-green-400' : 'text-gray-300'">
                                    {{ $provider_display_names[$provider] }}
                                </div>
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Alternative Authentication Methods -->
                    <div class="mb-6 p-4 bg-yellow-900/30 border border-yellow-400/50 rounded-lg">
                        <div class="flex gap-3">
                            <i class="fas fa-lightbulb text-yellow-400 mt-1"></i>
                            <div>
                                <h4 class="font-semibold text-yellow-300 mb-2">Why Not Regular Passwords?</h4>
                                <p class="text-sm text-yellow-200 mb-3">
                                    Major email providers (Gmail, Yahoo, Outlook) require App Passwords for security reasons:
                                </p>
                                <ul class="text-sm text-yellow-200 space-y-1 ml-4 list-disc">
                                    <li><strong>Enhanced Security:</strong> App passwords can be revoked without changing your main password</li>
                                    <li><strong>2FA Protection:</strong> Works even when two-factor authentication is enabled</li>
                                    <li><strong>Provider Policy:</strong> Required by Gmail (since 2022), Yahoo, and Outlook for IMAP access</li>
                                </ul>
                                <div class="mt-3 p-3 bg-yellow-800/50 rounded">
                                    <div class="text-sm font-medium text-yellow-200 mb-1">💡 Easy Alternatives:</div>
                                    <ul class="text-sm text-yellow-300 space-y-1 ml-4 list-disc">
                                        <li><strong>Try Demo Mode:</strong> Test the system without any real credentials</li>
                                        <li><strong>Use Custom IMAP:</strong> Some smaller providers still allow regular passwords</li>
                                        <li><strong>One-time Setup:</strong> App passwords only need to be generated once</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Connection Form -->
                    <form @submit.prevent="testConnection()" class="space-y-6">
                        <!-- Basic Credentials -->
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                                <input type="email" x-model="credentials.email" required
                                       class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-green-400 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">
                                    <span x-show="selectedProvider === 'gmail'">App Password (Required for Gmail)</span>
                                    <span x-show="selectedProvider === 'yahoo'">App Password (Required for Yahoo)</span>
                                    <span x-show="!['gmail', 'yahoo'].includes(selectedProvider)">Password / App Password</span>
                                </label>
                                <input type="password" x-model="credentials.password" required
                                       :placeholder="getPasswordPlaceholder()"
                                       class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-green-400 focus:outline-none">

                                <!-- Try Regular Password Option -->
                                <div x-show="['gmail', 'yahoo', 'outlook'].includes(selectedProvider)" class="mt-2">
                                    <label class="flex layhetgsjdcb gap-2 text-sm text-gray-400">
                                        <input type="checkbox" x-model="tryRegularPassword"
                                               class="rounded bg-gray-800 border-gray-600 text-green-500 focus:ring-green-500">
                                        <span>Try my regular password first (may not work for Gmail/Yahoo)</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Provider-specific Instructions -->
                        <div x-show="selectedProvider === 'demo'" x-transition class="bg-green-900/30 border border-green-400/50 rounded-lg p-4">
                            <div class="flex gap-3">
                                <i class="fas fa-play-circle text-green-400 mt-1"></i>
                                <div>
                                    <h4 class="font-semibold text-green-300 mb-2">Demo Mode</h4>
                                    <p class="text-sm text-green-200 mb-3">
                                        Try the email processing system with simulated data. No real email account required!
                                    </p>
                                    <ul class="text-sm text-green-200 space-y-1 ml-4 list-disc">
                                        <li>Use any email address (e.g., demo@example.com)</li>
                                        <li>Use any password (e.g., demo123)</li>
                                        <li>Experience the full processing workflow with sample emails</li>
                                        <li>See real-time analytics and download sample converted files</li>
                                    </ul>
                                    <div class="mt-3 p-3 bg-green-800/50 rounded">
                                        <div class="text-sm font-medium text-green-200">Quick Demo Credentials:</div>
                                        <div class="text-sm text-green-300 mt-1">
                                            Email: <code class="bg-green-700/50 px-1 rounded">demo@emailcleaner.com</code><br>
                                            Password: <code class="bg-green-700/50 px-1 rounded">demo123</code>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div x-show="selectedProvider === 'gmail'" x-transition class="bg-blue-900/30 border border-blue-400/50 rounded-lg p-4">
                            <div class="flex gap-3">
                                <i class="fas fa-info-circle text-blue-400 mt-1"></i>
                                <div>
                                    <h4 class="font-semibold text-blue-300 mb-2">Gmail Setup Required</h4>
                                    <p class="text-sm text-blue-200 mb-3">
                                        Gmail requires an App Password for IMAP access. Follow these steps:
                                    </p>
                                    <ol class="text-sm text-blue-200 space-y-1 ml-4 list-decimal">
                                        <li>Go to your <a href="https://myaccount.google.com/security" target="_blank" class="text-blue-300 hover:text-blue-100 underline">Google Account Security</a></li>
                                        <li>Enable 2-Step Verification if not already enabled</li>
                                        <li>Go to "App passwords" section</li>
                                        <li>Generate a new app password for "Mail"</li>
                                        <li>Use the 16-character password (without spaces) above</li>
                                    </ol>
                                    <div class="mt-3">
                                        <a href="https://support.google.com/accounts/answer/185833" target="_blank"
                                           class="inline-flex layhetgsjdcb gap-2 text-blue-300 hover:text-blue-100 text-sm">
                                            <i class="fas fa-external-link-alt"></i>
                                            Detailed Instructions
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div x-show="selectedProvider === 'yahoo'" x-transition class="bg-purple-900/30 border border-purple-400/50 rounded-lg p-4">
                            <div class="flex gap-3">
                                <i class="fas fa-info-circle text-purple-400 mt-1"></i>
                                <div>
                                    <h4 class="font-semibold text-purple-300 mb-2">Yahoo Mail Setup Required</h4>
                                    <p class="text-sm text-purple-200 mb-3">
                                        Yahoo Mail requires an App Password for IMAP access. Follow these steps:
                                    </p>
                                    <ol class="text-sm text-purple-200 space-y-1 ml-4 list-decimal">
                                        <li>Go to <a href="https://login.yahoo.com/account/security" target="_blank" class="text-purple-300 hover:text-purple-100 underline">Yahoo Account Security</a></li>
                                        <li>Scroll down to "How you sign in" section</li>
                                        <li>Click "Generate app password" or "App passwords"</li>
                                        <li>Select "Other app" and enter "Email Cleaner"</li>
                                        <li>Click "Generate" and copy the 16-character password</li>
                                        <li>Use this app password (not your regular password) above</li>
                                    </ol>
                                    <div class="mt-3 p-3 bg-purple-800/50 rounded">
                                        <div class="text-sm font-medium text-purple-200 mb-1">Important Notes:</div>
                                        <ul class="text-sm text-purple-300 space-y-1 ml-4 list-disc">
                                            <li>App passwords are required even without 2FA enabled</li>
                                            <li>Make sure "Allow apps that use less secure sign in" is enabled</li>
                                            <li>The app password is different from your Yahoo account password</li>
                                        </ul>
                                    </div>
                                    <div class="mt-3">
                                        <a href="https://help.yahoo.com/kb/generate-manage-third-party-passwords-sln15241.html" target="_blank"
                                           class="inline-flex layhetgsjdcb gap-2 text-purple-300 hover:text-purple-100 text-sm">
                                            <i class="fas fa-external-link-alt"></i>
                                            Yahoo Help Guide
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div x-show="selectedProvider === 'outlook'" x-transition class="bg-orange-900/30 border border-orange-400/50 rounded-lg p-4">
                            <div class="flex gap-3">
                                <i class="fas fa-info-circle text-orange-400 mt-1"></i>
                                <div>
                                    <h4 class="font-semibold text-orange-300 mb-2">Outlook/Hotmail Setup</h4>
                                    <p class="text-sm text-orange-200 mb-2">
                                        For Outlook.com/Hotmail accounts:
                                    </p>
                                    <ul class="text-sm text-orange-200 space-y-1 ml-4 list-disc">
                                        <li><strong>Try your regular password first</strong> - it may work if 2FA is disabled</li>
                                        <li>If 2FA is enabled, generate an app password from your Microsoft account security settings</li>
                                        <li>Make sure IMAP is enabled in your Outlook settings</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div x-show="selectedProvider === 'aol'" x-transition class="bg-indigo-900/30 border border-indigo-400/50 rounded-lg p-4">
                            <div class="flex gap-3">
                                <i class="fas fa-info-circle text-indigo-400 mt-1"></i>
                                <div>
                                    <h4 class="font-semibold text-indigo-300 mb-2">AOL Mail Setup</h4>
                                    <p class="text-sm text-indigo-200 mb-2">
                                        AOL Mail often works with regular passwords:
                                    </p>
                                    <ul class="text-sm text-indigo-200 space-y-1 ml-4 list-disc">
                                        <li><strong>Use your regular AOL password</strong></li>
                                        <li>Make sure IMAP is enabled in your AOL Mail settings</li>
                                        <li>If you have 2-step verification, you may need an app password</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div x-show="selectedProvider === 'zoho'" x-transition class="bg-teal-900/30 border border-teal-400/50 rounded-lg p-4">
                            <div class="flex gap-3">
                                <i class="fas fa-info-circle text-teal-400 mt-1"></i>
                                <div>
                                    <h4 class="font-semibold text-teal-300 mb-2">Zoho Mail Setup</h4>
                                    <p class="text-sm text-teal-200 mb-2">
                                        Zoho Mail typically works with regular passwords:
                                    </p>
                                    <ul class="text-sm text-teal-200 space-y-1 ml-4 list-disc">
                                        <li><strong>Use your regular Zoho password</strong></li>
                                        <li>Ensure IMAP is enabled in your Zoho Mail settings</li>
                                        <li>Check "Settings" → "Mail Accounts" → "IMAP Access"</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Custom IMAP/POP3 Settings -->
                        <div x-show="selectedProvider === 'imap' || selectedProvider === 'pop3'" x-transition class="space-y-4">
                            <h4 class="text-lg font-semibold text-white">Custom Server Settings</h4>
                            <div class="grid md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Server Host</label>
                                    <input type="text" x-model="customSettings.host" placeholder="mail.example.com"
                                           class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-green-400 focus:outline-none">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Port</label>
                                    <input type="number" x-model="customSettings.port" placeholder="993"
                                           class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-green-400 focus:outline-none">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Encryption</label>
                                    <select x-model="customSettings.encryption"
                                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-green-400 focus:outline-none">
                                        <option value="ssl">SSL</option>
                                        <option value="tls">TLS</option>
                                        <option value="none">None</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Connection Status -->
                        <div x-show="connectionStatus.message" x-transition
                             :class="connectionStatus.success ? 'bg-green-900/50 border-green-400 text-green-300' : 'bg-red-900/50 border-red-400 text-red-300'"
                             class="p-4 border rounded-lg">
                            <div class="flex layhetgsjdcb gap-3">
                                <i :class="connectionStatus.success ? 'fas fa-check-circle' : 'fas fa-exclamation-triangle'"></i>
                                <span x-text="connectionStatus.message"></span>
                            </div>

                            <!-- Success Details -->
                            <div x-show="connectionStatus.success && connectionStatus.details" class="mt-2 text-sm">
                                <div>Total Emails: <span x-text="connectionStatus.details.total_emails"></span></div>
                                <div>Folders: <span x-text="connectionStatus.details.folders ? connectionStatus.details.folders.join(', ') : ''"></span></div>
                            </div>

                            <!-- Error Suggestions -->
                            <div x-show="!connectionStatus.success && connectionStatus.suggestions && connectionStatus.suggestions.length > 0" class="mt-3">
                                <div class="text-sm font-medium mb-2">Suggestions:</div>
                                <ul class="text-sm space-y-1 ml-4 list-disc">
                                    <template x-for="suggestion in connectionStatus.suggestions" :key="suggestion">
                                        <li x-text="suggestion"></li>
                                    </template>
                                </ul>
                            </div>

                            <!-- Quick Setup Links for Gmail -->
                            <div x-show="!connectionStatus.success && connectionStatus.provider === 'gmail'" class="mt-3">
                                <a href="https://myaccount.google.com/apppasswords" target="_blank"
                                   class="inline-flex layhetgsjdcb gap-2 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded transition-all">
                                    <i class="fas fa-external-link-alt"></i>
                                    Generate Gmail App Password
                                </a>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-wrap gap-4">
                            <button type="submit" :disabled="testing || !selectedProvider || !credentials.email || !credentials.password"
                                    class="maksueyropls py-3 bg-green-500 hover:bg-green-600 disabled:bg-gray-700 disabled:cursor-not-allowed text-gray-900 disabled:text-gray-500 font-bold rounded-lg transition-all flex layhetgsjdcb gap-2">
                                <i :class="testing ? 'fas fa-spinner fa-spin' : 'fas fa-plug'"></i>
                                <span x-text="testing ? 'Testing Connection...' : 'Test Connection'"></span>
                            </button>

                            <button type="button" @click="startProcessing()" x-show="connectionStatus.success && sessionId"
                                    class="maksueyropls py-3 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-lg transition-all flex layhetgsjdcb gap-2">
                                <i class="fas fa-play"></i>
                                Start Processing
                            </button>

                            <!-- Quick Demo Button -->
                            <button type="button" @click="quickDemo()" x-show="!connectionStatus.success"
                                    class="maksueyropls py-3 bg-purple-500 hover:bg-purple-600 text-white font-bold rounded-lg transition-all flex layhetgsjdcb gap-2">
                                <i class="fas fa-rocket"></i>
                                Try Demo Mode
                            </button>
                        </div>
                    </form>

                    <!-- Troubleshooting Section -->
                    <div x-show="!connectionStatus.success && connectionStatus.message" class="mt-8 p-4 bg-red-900/20 border border-red-400/30 rounded-lg">
                        <div class="flex gap-3">
                            <i class="fas fa-tools text-red-400 mt-1"></i>
                            <div>
                                <h4 class="font-semibold text-red-300 mb-2">Troubleshooting Tips</h4>
                                <div class="text-sm text-red-200 space-y-2">
                                    <div><strong>Common Solutions:</strong></div>
                                    <ul class="ml-4 list-disc space-y-1">
                                        <li>For Gmail/Yahoo: Use App Password instead of regular password</li>
                                        <li>Check if IMAP is enabled in your email account settings</li>
                                        <li>Try Demo Mode to test the system without real credentials</li>
                                        <li>For Outlook: Try regular password first, then App Password if needed</li>
                                        <li>Ensure your email address is correct and properly formatted</li>
                                    </ul>
                                    <div class="mt-3 p-3 bg-red-800/30 rounded">
                                        <strong>Still having issues?</strong> Try Demo Mode to experience the full system,
                                        then return to set up your real email account.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security Notice -->
                    <div class="mt-8 p-4 bg-gray-800 border border-gray-700 rounded-lg">
                        <div class="flex gap-3">
                            <i class="fas fa-shield-alt text-green-400 mt-1"></i>
                            <div>
                                <h4 class="font-semibold text-white mb-1">Security Notice</h4>
                                <p class="text-sm text-gray-300">
                                    Your credentials are encrypted and stored temporarily only for the duration of processing.
                                    We recommend using app-specific passwords for Gmail and other providers that support them.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Overview -->
        <section class="py-16 bg-gray-900/50">
            <div class="max-w-6xl mx-auto dkslaoeyhnmj lg:px-12">
                <h3 class="text-3xl font-bold text-white text-center mb-12">What You'll Get</h3>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center space-y-4">
                        <div class="w-16 h-16 bg-green-500/20 rounded-full flex layhetgsjdcb mx-auto">
                            <i class="fas fa-chart-line text-green-400 text-2xl"></i>
                        </div>
                        <h4 class="text-xl font-semibold text-white">Real-time Analytics</h4>
                        <p class="text-gray-300">Track storage savings, processing progress, and detailed statistics in real-time.</p>
                    </div>
                    <div class="text-center space-y-4">
                        <div class="w-16 h-16 bg-blue-500/20 rounded-full flex layhetgsjdcb mx-auto">
                            <i class="fas fa-file-word text-blue-400 text-2xl"></i>
                        </div>
                        <h4 class="text-xl font-semibold text-white">Word Documents</h4>
                        <p class="text-gray-300">Convert emails to organized Word documents with attachments and images cataloged.</p>
                    </div>
                    <div class="text-center space-y-4">
                        <div class="w-16 h-16 bg-purple-500/20 rounded-full flex layhetgsjdcb mx-auto">
                            <i class="fas fa-download text-purple-400 text-2xl"></i>
                        </div>
                        <h4 class="text-xl font-semibold text-white">Easy Downloads</h4>
                        <p class="text-gray-300">Download individual files or complete ZIP archives of all converted emails.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('layout.includes.footer')

    <!-- Alpine.js Component -->
    <script>
        function emailConnection() {
            return {
                selectedProvider: '',
                credentials: {
                    email: '',
                    password: ''
                },
                customSettings: {
                    host: '',
                    port: 993,
                    encryption: 'ssl'
                },
                testing: false,
                connectionStatus: {
                    success: false,
                    message: '',
                    details: null
                },
                sessionId: null,
                tryRegularPassword: false,

                getPasswordPlaceholder() {
                    if (this.selectedProvider === 'gmail') {
                        return this.tryRegularPassword ? 'Try regular password first' : 'Enter 16-character app password';
                    } else if (this.selectedProvider === 'yahoo') {
                        return this.tryRegularPassword ? 'Try regular password first' : 'Enter app password';
                    } else if (this.selectedProvider === 'outlook') {
                        return 'Enter password or app password';
                    } else if (['aol', 'zoho'].includes(this.selectedProvider)) {
                        return 'Enter your regular password';
                    } else if (this.selectedProvider === 'demo') {
                        return 'Any password (e.g., demo123)';
                    } else {
                        return 'Enter your password';
                    }
                },

                async testConnection() {
                    this.testing = true;
                    this.connectionStatus = { success: false, message: '', details: null };

                    try {
                        const formData = new FormData();
                        formData.append('provider', this.selectedProvider);
                        formData.append('email', this.credentials.email);
                        formData.append('password', this.credentials.password);

                        if (this.selectedProvider === 'imap' || this.selectedProvider === 'pop3') {
                            formData.append('custom_host', this.customSettings.host);
                            formData.append('custom_port', this.customSettings.port);
                            formData.append('custom_encryption', this.customSettings.encryption);
                        }

                        const response = await fetch('/dashboard/test-connection', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });

                        const data = await response.json();

                        if (data.success) {
                            this.connectionStatus = {
                                success: true,
                                message: data.message,
                                details: {
                                    total_emails: data.total_emails,
                                    folders: data.folders
                                }
                            };
                            this.sessionId = data.session_id;
                        } else {
                            this.connectionStatus = {
                                success: false,
                                message: data.message,
                                details: null,
                                suggestions: data.suggestions || [],
                                provider: data.provider
                            };
                        }
                    } catch (error) {
                        this.connectionStatus = {
                            success: false,
                            message: 'Connection failed: ' + error.message,
                            details: null,
                            suggestions: ['Please check your internet connection and try again.'],
                            provider: this.selectedProvider
                        };
                    } finally {
                        this.testing = false;
                    }
                },

                startProcessing() {
                    if (this.sessionId) {
                        window.location.href = `/dashboard/processing/${this.sessionId}`;
                    }
                },

                quickDemo() {
                    this.selectedProvider = 'demo';
                    this.credentials.email = 'demo@emailcleaner.com';
                    this.credentials.password = 'demo123';
                    this.testConnection();
                }
            }
        }
    </script>

    <!-- intersect -->
    <script defer src="vendors/%40alpinejs/intersect/dist/cdn.min.js"></script>
    <!-- alpine js -->
    <script src="vendors/alpinejs/dist/cdn.min.js" defer></script>
    @include('layout.includes.scripts')
</body>
</html>
