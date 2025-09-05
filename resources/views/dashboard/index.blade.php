<!DOCTYPE html>
<html lang="en">
@include('layout.includes.head')

<body class="bg-gray-950 text-gray-100 font-sans">
    @include('layout.includes.nav')

    <main class="min-h-screen pt-20">
        <!-- Hero Section -->
        <section class="relative py-20">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-900/20 via-purple-900/20 to-green-900/20"></div>
            <div class="max-w-7xl mx-auto px-4 lg:px-12 relative z-10">
                <div class="text-center space-y-8">
                    <div class="space-y-4">
                        <div class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-blue-500/20 to-purple-500/20 border border-blue-500/30 rounded-full backdrop-blur-sm">
                            <div class="w-3 h-3 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full animate-pulse"></div>
                            <span class="text-blue-300 text-sm font-medium">OAuth 2.0 Secure Authentication</span>
                        </div>
                        <h1 class="text-5xl lg:text-7xl font-bold font-code tracking-tight bg-gradient-to-r from-white via-blue-100 to-purple-100 bg-clip-text text-transparent">
                            EmailCleaner Pro
                        </h1>
                        <p class="text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed">
                            Securely connect your email accounts using OAuth 2.0 and transform your emails into organized, searchable documents with advanced analytics.
                        </p>
                    </div>

                    <!-- Quick Stats -->
                    <div class="flex flex-wrap justify-center gap-8 mt-12">
                        <div class="flex items-center gap-3 text-gray-300">
                            <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-shield-alt text-white"></i>
                            </div>
                            <div class="text-left">
                                <div class="text-sm font-medium">OAuth 2.0 Security</div>
                                <div class="text-xs text-gray-400">No passwords stored</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 text-gray-300">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-chart-line text-white"></i>
                            </div>
                            <div class="text-left">
                                <div class="text-sm font-medium">Real-time Analytics</div>
                                <div class="text-xs text-gray-400">Live processing stats</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 text-gray-300">
                            <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-file-word text-white"></i>
                            </div>
                            <div class="text-left">
                                <div class="text-sm font-medium">Smart Conversion</div>
                                <div class="text-xs text-gray-400">Word documents</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- OAuth Connection Section -->
        <section class="py-16">
            <div class="max-w-6xl mx-auto px-4 lg:px-12">
                <div class="bg-gray-900/50 border border-gray-800 rounded-2xl p-8 backdrop-blur-sm" x-data="oauthDashboard()">
                    
                    <!-- Success/Error Messages -->
                    <div x-show="message" x-transition
                         :class="messageType === 'success' ? 'bg-green-900/30 border-green-400/50' : 'bg-red-900/30 border-red-400/50'"
                         class="p-4 border rounded-lg mb-8">
                        <div class="flex items-center gap-3">
                            <i :class="messageType === 'success' ? 'fas fa-check-circle text-green-400' : 'fas fa-exclamation-triangle text-red-400'"></i>
                            <span :class="messageType === 'success' ? 'text-green-200' : 'text-red-200'" x-text="message"></span>
                        </div>
                    </div>

                    <!-- Header -->
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-white mb-4 flex items-center justify-center gap-3">
                            <i class="fas fa-plug text-green-400"></i>
                            Connect Your Email Account
                        </h2>
                        <p class="text-gray-300 text-lg max-w-2xl mx-auto">
                            Choose your email provider and connect securely using OAuth 2.0. No passwords required - just click and authorize!
                        </p>
                    </div>

                    <!-- OAuth Provider Cards -->
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                        <!-- Gmail -->
                        <div class="group relative bg-gradient-to-br from-red-500/10 to-red-600/10 border border-red-500/20 rounded-xl p-6 hover:border-red-400/40 transition-all duration-300 cursor-pointer"
                             @click="connectProvider('gmail')">
                            <div class="absolute inset-0 bg-gradient-to-br from-red-500/5 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="relative z-10">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center">
                                        <i class="fab fa-google text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-white">Gmail</h3>
                                        <p class="text-sm text-gray-400">Google Workspace</p>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-300 mb-4">Connect your Gmail account securely with OAuth 2.0</p>
                                <div class="flex items-center gap-2 text-sm text-green-400">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>OAuth 2.0 Secure</span>
                                </div>
                            </div>
                        </div>

                        <!-- Outlook -->
                        <div class="group relative bg-gradient-to-br from-blue-500/10 to-blue-600/10 border border-blue-500/20 rounded-xl p-6 hover:border-blue-400/40 transition-all duration-300 cursor-pointer"
                             @click="connectProvider('outlook')">
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="relative z-10">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                        <i class="fab fa-microsoft text-white text-xl"></i>
                                    </div>
                                <div>
                                        <h3 class="text-lg font-semibold text-white">Outlook</h3>
                                        <p class="text-sm text-gray-400">Microsoft 365</p>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-300 mb-4">Connect your Outlook/Hotmail account with OAuth 2.0</p>
                                <div class="flex items-center gap-2 text-sm text-green-400">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>OAuth 2.0 Secure</span>
                                </div>
                            </div>
                        </div>

                        <!-- Yahoo -->
                        <div class="group relative bg-gradient-to-br from-purple-500/10 to-purple-600/10 border border-purple-500/20 rounded-xl p-6 hover:border-purple-400/40 transition-all duration-300 cursor-pointer"
                             @click="connectProvider('yahoo')">
                            <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="relative z-10">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                                        <i class="fab fa-yahoo text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-white">Yahoo Mail</h3>
                                        <p class="text-sm text-gray-400">Yahoo Account</p>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-300 mb-4">Connect your Yahoo Mail account securely</p>
                                <div class="flex items-center gap-2 text-sm text-green-400">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>OAuth 2.0 Secure</span>
                                </div>
                                </div>
                            </div>
                        </div>

                    <!-- Demo Mode -->
                    <div class="bg-gradient-to-r from-purple-900/30 to-pink-900/30 border border-purple-500/30 rounded-xl p-6 mb-8">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-magic text-white text-xl"></i>
                            </div>
                                <div>
                                <h3 class="text-lg font-semibold text-white">Demo Mode</h3>
                                <p class="text-sm text-gray-400">Try without connecting real accounts</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-300 mb-4">
                            Experience the full EmailCleaner functionality with simulated data. Perfect for testing and demonstrations.
                        </p>
                        <button @click="connectProvider('demo')" 
                                class="px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white rounded-lg transition-all flex items-center gap-2">
                            <i class="fas fa-play"></i>
                            <span>Try Demo Mode</span>
                        </button>
                            </div>

                    <!-- Connected Accounts -->
                    <div x-show="connectedAccounts.length > 0" x-transition class="mt-12">
                        <h3 class="text-xl font-semibold text-white mb-6 flex items-center gap-2">
                            <i class="fas fa-check-circle text-green-400"></i>
                            Connected Accounts
                        </h3>
                        <div class="grid gap-4">
                            <template x-for="account in connectedAccounts" :key="account.session_id">
                                <div class="bg-gray-800/50 border border-gray-700 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-500 rounded-lg flex items-center justify-center">
                                                <i :class="getProviderIcon(account.provider)" class="text-white"></i>
                                            </div>
                                            <div>
                                                <div class="text-white font-medium" x-text="account.email_address"></div>
                                                <div class="text-sm text-gray-400" x-text="getProviderName(account.provider)"></div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <div class="text-right">
                                                <div class="text-sm text-gray-300" x-text="account.total_emails + ' emails'"></div>
                                                <div class="text-xs text-green-400">Connected</div>
                                            </div>
                                            <div class="flex gap-2">
                                                <a :href="`/dashboard/emails/${account.session_id}`" 
                                                   class="px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm transition-colors">
                                                    <i class="fas fa-envelope mr-1"></i>
                                                    View Emails
                                                </a>
                                                <button @click="disconnectAccount(account.session_id)"
                                                        class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm transition-colors">
                                                    <i class="fas fa-unlink mr-1"></i>
                                                    Disconnect
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Security Notice -->
                    <div class="mt-12 p-6 bg-gray-800/30 border border-gray-700 rounded-xl">
                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-shield-alt text-white"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-white mb-2">Security & Privacy</h4>
                                <div class="text-sm text-gray-300 space-y-2">
                                    <p>• <strong>OAuth 2.0:</strong> We never store your passwords. All authentication is handled securely by your email provider.</p>
                                    <p>• <strong>Encrypted Storage:</strong> Access tokens are encrypted and stored temporarily only for processing.</p>
                                    <p>• <strong>Limited Access:</strong> We only request read-only access to your emails for processing purposes.</p>
                                    <p>• <strong>Revocable:</strong> You can revoke access at any time from your email provider's security settings.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-20 bg-gray-900/30">
            <div class="max-w-7xl mx-auto px-4 lg:px-12">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-white mb-4">Why Choose EmailCleaner Pro?</h2>
                    <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                        Advanced email management with enterprise-grade security and powerful analytics
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-8 hover:border-blue-500/30 transition-all">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center mb-6">
                            <i class="fas fa-shield-alt text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-4">OAuth 2.0 Security</h3>
                        <p class="text-gray-300">Industry-standard authentication with no password storage. Your credentials stay with your email provider.</p>
                    </div>

                    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-8 hover:border-green-500/30 transition-all">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center mb-6">
                            <i class="fas fa-chart-line text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-4">Real-time Analytics</h3>
                        <p class="text-gray-300">Live processing statistics, storage optimization insights, and detailed conversion reports.</p>
                    </div>

                    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-8 hover:border-purple-500/30 transition-all">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center mb-6">
                            <i class="fas fa-file-word text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-4">Smart Conversion</h3>
                        <p class="text-gray-300">Transform emails into organized Word documents with preserved formatting and metadata.</p>
                    </div>

                    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-8 hover:border-yellow-500/30 transition-all">
                        <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center mb-6">
                            <i class="fas fa-bolt text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-4">Lightning Fast</h3>
                        <p class="text-gray-300">Optimized processing algorithms with background job queues for maximum performance.</p>
                    </div>

                    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-8 hover:border-red-500/30 transition-all">
                        <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-pink-500 rounded-xl flex items-center justify-center mb-6">
                            <i class="fas fa-download text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-4">Easy Downloads</h3>
                        <p class="text-gray-300">Download individual files or complete ZIP archives with organized folder structures.</p>
                    </div>

                    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-8 hover:border-indigo-500/30 transition-all">
                        <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center mb-6">
                            <i class="fas fa-cogs text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-4">Multi-Provider</h3>
                        <p class="text-gray-300">Support for Gmail, Outlook, Yahoo, and more with unified processing workflows.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('layout.includes.footer')

    <!-- Alpine.js Component -->
    <script>
        function oauthDashboard() {
            return {
                message: '',
                messageType: 'success',
                connectedAccounts: [],
                loading: false,

                init() {
                    this.loadConnectedAccounts();
                    this.checkForMessages();
                },

                checkForMessages() {
                    // Check for success/error messages from session
                    @if(session('success'))
                        this.message = '{{ session('success') }}';
                        this.messageType = 'success';
                        setTimeout(() => this.message = '', 5000);
                    @endif
                    
                    @if(session('error'))
                        this.message = '{{ session('error') }}';
                        this.messageType = 'error';
                        setTimeout(() => this.message = '', 5000);
                    @endif
                },

                async loadConnectedAccounts() {
                    try {
                        // In a real implementation, you would fetch this from an API
                        // For now, we'll use the session_id from the success message
                        @if(session('session_id'))
                            this.connectedAccounts = [{
                                session_id: '{{ session('session_id') }}',
                                provider: 'gmail',
                                email_address: 'Connected Account',
                                total_emails: 0
                            }];
                        @endif
                    } catch (error) {
                        console.error('Failed to load connected accounts:', error);
                    }
                },

                connectProvider(provider) {
                    if (provider === 'demo') {
                        // Handle demo mode
                        window.location.href = '/dashboard/test-connection?provider=demo&email=demo@emailcleaner.com&password=demo123';
                        return;
                    }

                    // Redirect to OAuth provider
                    window.location.href = `/oauth/${provider}/redirect`;
                },

                async disconnectAccount(sessionId) {
                    if (!confirm('Are you sure you want to disconnect this account?')) {
                        return;
                    }

                    try {
                        const response = await fetch(`/oauth/${sessionId}/disconnect`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            }
                        });

                        const data = await response.json();

                        if (data.success) {
                            this.message = data.message;
                            this.messageType = 'success';
                            this.loadConnectedAccounts();
                        } else {
                            this.message = data.message;
                            this.messageType = 'error';
                        }

                        setTimeout(() => this.message = '', 5000);
                    } catch (error) {
                        this.message = 'Failed to disconnect account';
                        this.messageType = 'error';
                        setTimeout(() => this.message = '', 5000);
                    }
                },

                getProviderIcon(provider) {
                    const icons = {
                        'gmail': 'fab fa-google',
                        'outlook': 'fab fa-microsoft',
                        'yahoo': 'fab fa-yahoo',
                        'demo': 'fas fa-magic'
                    };
                    return icons[provider] || 'fas fa-envelope';
                },

                getProviderName(provider) {
                    const names = {
                        'gmail': 'Gmail',
                        'outlook': 'Outlook',
                        'yahoo': 'Yahoo Mail',
                        'demo': 'Demo Mode'
                    };
                    return names[provider] || provider;
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script src="{{ asset('vendors/alpinejs/dist/cdn.min.js') }}?v={{ time() }}" defer></script>
    @include('layout.includes.scripts')
</body>
</html>