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


                    </div>
                    <p class="text-lg text-gray-300 max-w-2xl mx-auto leading-relaxed">
                        Connect your email account and start converting your emails to organized Word documents with real-time analytics and intelligent processing.
                    </p>

                    <!-- Quick Stats -->
                    <div class="flex flex-wrap justify-center gap-6 mt-8">
                        <div class="flex items-center gap-2 text-gray-400">
                            <i class="fas fa-shield-alt text-green-400"></i>
                            <span class="text-sm">Secure & Encrypted</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-400">
                            <i class="fas fa-clock text-blue-400"></i>
                            <span class="text-sm">Real-time Processing</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-400">
                            <i class="fas fa-download text-purple-400"></i>
                            <span class="text-sm">Instant Downloads</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Connection Form -->
        <section class="py-16">
            <div class="max-w-4xl mx-auto dkslaoeyhnmj lg:px-12">
                <div class="bg-gray-900 border border-gray-800 rounded-lg p-8" x-data="emailConnection()">
                    <div class="text-center mb-8">
                        <h3 class="text-3xl font-bold text-white mb-4 flex items-center justify-center gap-3">
                            <i class="fas fa-plug text-green-400"></i>
                            Connect Your Email Account
                        </h3>
                        <p class="text-gray-300 text-lg max-w-2xl mx-auto">
                            Securely connect your email account to start organizing and cleaning your emails with advanced automation tools.
                        </p>

                        <!-- Quick Connect Prompts -->
                        <div class="mt-6 flex flex-wrap justify-center gap-3">
                            <button @click="selectedProvider = 'gmail'; credentials.email = 'johnmuthee548@gmail.com'; credentials.password = 'dwtv tqnk fmaq czyz'"
                                    class="px-4 py-2 bg-gray-800 hover:bg-gray-700 border border-gray-600 rounded-lg text-sm text-gray-300 hover:text-white transition-all">
                                <i class="fas fa-envelope mr-2"></i>Use Gmail
                            </button>
                            <button @click="selectedProvider = 'demo'; credentials.email = 'demo@emailcleaner.com'; credentials.password = 'demo123'"
                                    class="px-4 py-2 bg-purple-800 hover:bg-purple-700 border border-purple-600 rounded-lg text-sm text-purple-300 hover:text-white transition-all">
                                <i class="fas fa-magic mr-2"></i>Try Demo
                            </button>
                        </div>
                    </div>

                    <!-- Provider Selection -->
                    <div class="mb-8">
                        <label class="block text-lg font-semibold text-white mb-4 flex items-center gap-2">
                            <i class="fas fa-server text-green-400"></i>
                            Choose Your Email Provider
                        </label>

                        <!-- Provider Dropdown -->
                        <div class="relative">
                            <select x-model="selectedProvider" 
                                    class="w-full px-4 py-4 bg-gray-800/50 border border-gray-700 rounded-xl text-white focus:border-green-400 focus:outline-none focus:ring-2 focus:ring-green-400/20 transition-all duration-300 appearance-none cursor-pointer">
                                <option value="">Select your email provider...</option>
                                <option value="gmail">Gmail</option>
                                <option value="yahoo">Yahoo Mail</option>
                                <option value="outlook">Outlook/Hotmail</option>
                                <option value="aol">AOL Mail</option>
                                <option value="zoho">Zoho Mail</option>
                                <option value="imap">Custom IMAP</option>
                                <option value="pop3">Custom POP3</option>
                                <option value="demo">Demo Mode</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>

                        <!-- Provider Selection Indicator -->
                        <div x-show="selectedProvider" x-transition class="mt-4 p-4 bg-gray-800/50 border border-gray-700 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                                <span class="text-green-400 font-medium">
                                    Selected: <span x-text="selectedProvider ? providerDisplayNames[selectedProvider] || selectedProvider : ''"></span>
                                </span>
                            </div>
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
                    <form @submit.prevent="testConnection()" class="space-y-8">
                        <!-- Basic Credentials -->
                        <div class="grid md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-white mb-3 flex items-center gap-2">
                                    <i class="fas fa-envelope text-blue-400"></i>
                                    Email Address
                                </label>
                                <div class="relative">
                                <input type="email" x-model="credentials.email" required
                                           class="w-full px-4 py-4 bg-gray-800/50 border border-gray-700 rounded-xl text-white focus:border-green-400 focus:outline-none focus:ring-2 focus:ring-green-400/20 transition-all duration-300"
                                           placeholder="your.email@example.com">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <i class="fas fa-check text-green-400" x-show="credentials.email && isValidEmail(credentials.email)"></i>
                                    </div>
                                </div>
                                <div x-show="credentials.email && !isValidEmail(credentials.email)" class="text-red-400 text-sm flex items-center gap-1">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <span>Please enter a valid email address</span>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-white mb-3 flex items-center gap-2">
                                    <i class="fas fa-lock text-purple-400"></i>
                                    <span x-show="selectedProvider === 'gmail'">App Password (Required for Gmail)</span>
                                    <span x-show="selectedProvider === 'yahoo'">App Password (Required for Yahoo)</span>
                                    <span x-show="!['gmail', 'yahoo'].includes(selectedProvider)">Password / App Password</span>
                                </label>
                                <div class="relative">
                                <input type="password" x-model="credentials.password" required
                                       :placeholder="getPasswordPlaceholder()"
                                           class="w-full px-4 py-4 bg-gray-800/50 border border-gray-700 rounded-xl text-white focus:border-green-400 focus:outline-none focus:ring-2 focus:ring-green-400/20 transition-all duration-300">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <i class="fas fa-eye text-gray-400 cursor-pointer hover:text-gray-300"
                                           @click="togglePasswordVisibility"
                                           x-show="!showPassword"></i>
                                        <i class="fas fa-eye-slash text-gray-400 cursor-pointer hover:text-gray-300"
                                           @click="togglePasswordVisibility"
                                           x-show="showPassword"></i>
                                    </div>
                                </div>

                                <!-- Try Regular Password Option -->
                                <div x-show="['gmail', 'yahoo', 'outlook'].includes(selectedProvider)" class="mt-3">
                                    <label class="flex items-center gap-3 text-sm text-gray-400 hover:text-gray-300 cursor-pointer transition-colors">
                                        <input type="checkbox" x-model="tryRegularPassword"
                                               class="w-4 h-4 rounded bg-gray-800 border-gray-600 text-green-500 focus:ring-green-500 focus:ring-2">
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
                             :class="connectionStatus.success ? 'bg-green-900/30 border-green-400/50' : 'bg-red-900/30 border-red-400/50'"
                             class="p-6 border-2 rounded-xl">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <div :class="connectionStatus.success ? 'bg-green-500' : 'bg-red-500'"
                                         class="w-12 h-12 rounded-full flex items-center justify-center">
                                        <i :class="connectionStatus.success ? 'fas fa-check text-white text-xl' : 'fas fa-exclamation-triangle text-white text-xl'"></i>
                                    </div>
                            </div>
                                <div class="flex-1">
                                    <h4 :class="connectionStatus.success ? 'text-green-400' : 'text-red-400'"
                                        class="text-lg font-semibold mb-2" x-text="connectionStatus.success ? 'Connection Successful!' : 'Connection Failed'"></h4>
                                    <p :class="connectionStatus.success ? 'text-green-200' : 'text-red-200'"
                                       class="text-sm mb-4" x-text="connectionStatus.message"></p>

                            <!-- Success Details -->
                                    <div x-show="connectionStatus.success && connectionStatus.details"
                                         class="bg-green-800/20 border border-green-400/30 rounded-lg p-4 mb-4">
                                        <h5 class="text-green-300 font-semibold mb-3 flex items-center gap-2">
                                            <i class="fas fa-info-circle"></i>
                                            Account Information
                                        </h5>
                                        <div class="grid md:grid-cols-2 gap-4 text-sm">
                                            <div class="flex items-center gap-2">
                                                <i class="fas fa-envelope text-green-400"></i>
                                                <span class="text-green-200">Total Emails: <strong x-text="connectionStatus.details.total_emails"></strong></span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <i class="fas fa-folder text-green-400"></i>
                                                <span class="text-green-200">Folders: <strong x-text="connectionStatus.details.folders ? connectionStatus.details.folders.length : 0"></strong></span>
                                            </div>
                                        </div>
                                        <div x-show="connectionStatus.details.folders && connectionStatus.details.folders.length > 0" class="mt-3">
                                            <div class="text-green-300 text-sm font-medium mb-2">Available Folders:</div>
                                            <div class="flex flex-wrap gap-2">
                                                <template x-for="folder in connectionStatus.details.folders" :key="folder">
                                                    <span class="px-2 py-1 bg-green-700/30 text-green-200 text-xs rounded-full" x-text="folder"></span>
                                                </template>
                                            </div>
                                        </div>
                            </div>

                            <!-- Error Suggestions -->
                                    <div x-show="!connectionStatus.success && connectionStatus.suggestions && connectionStatus.suggestions.length > 0"
                                         class="bg-red-800/20 border border-red-400/30 rounded-lg p-4">
                                        <h5 class="text-red-300 font-semibold mb-3 flex items-center gap-2">
                                            <i class="fas fa-lightbulb"></i>
                                            Troubleshooting Tips
                                        </h5>
                                        <ul class="text-sm text-red-200 space-y-2">
                                    <template x-for="suggestion in connectionStatus.suggestions" :key="suggestion">
                                                <li class="flex items-start gap-2">
                                                    <i class="fas fa-arrow-right text-red-400 mt-1 text-xs"></i>
                                                    <span x-text="suggestion"></span>
                                                </li>
                                    </template>
                                </ul>
                            </div>

                            <!-- Quick Setup Links for Gmail -->
                                    <div x-show="!connectionStatus.success && connectionStatus.provider === 'gmail'" class="mt-4">
                                <a href="https://myaccount.google.com/apppasswords" target="_blank"
                                           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition-all transform hover:scale-105">
                                    <i class="fas fa-external-link-alt"></i>
                                    Generate Gmail App Password
                                </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-6 pt-6">
                            <!-- Main Connect Button -->
                            <div class="text-center">
                            <button type="submit" :disabled="testing || !selectedProvider || !credentials.email || !credentials.password"
                                        class="group relative px-12 py-5 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 disabled:from-gray-700 disabled:to-gray-800 disabled:cursor-not-allowed text-white font-bold rounded-2xl transition-all duration-300 flex items-center gap-4 shadow-xl hover:shadow-green-500/30 disabled:shadow-none transform hover:scale-105 disabled:scale-100 mx-auto text-xl">
                                    <div class="relative">
                                        <i :class="testing ? 'fas fa-spinner fa-spin' : 'fas fa-plug'" class="text-2xl"></i>
                                        <div x-show="testing" class="absolute inset-0 flex items-center justify-center">
                                            <div class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                                        </div>
                                    </div>
                                    <span x-text="testing ? 'Connecting...' : 'Connect Email Account'" class="text-xl font-bold"></span>
                                    <div x-show="testing" class="ml-3">
                                        <div class="flex space-x-1">
                                            <div class="w-2 h-2 bg-white rounded-full animate-bounce"></div>
                                            <div class="w-2 h-2 bg-white rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                                            <div class="w-2 h-2 bg-white rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                                        </div>
                                    </div>
                            </button>

                                <!-- Connection Status Indicator -->
                                <div x-show="testing" class="mt-4 text-center">
                                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500/10 border border-blue-400/20 rounded-full">
                                        <div class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></div>
                                        <span class="text-blue-400 text-sm font-medium">Establishing secure connection...</span>
                                    </div>
                                </div>
                            </div>

                                                        <!-- Secondary Action Buttons -->
                            <div class="flex flex-wrap justify-center gap-4">
                                <!-- View Emails Button -->
                                <a :href="`/dashboard/emails/${sessionId}`" x-show="connectionStatus.success && sessionId"
                                   class="group px-8 py-4 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold rounded-xl transition-all duration-300 flex items-center gap-3 shadow-lg hover:shadow-green-500/25 transform hover:scale-105">
                                    <i class="fas fa-envelope text-lg group-hover:scale-110 transition-transform"></i>
                                    <span class="text-lg">View All Emails</span>
                                    <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                                </a>

                                <button type="button" @click="startProcessing()" x-show="connectionStatus.success && sessionId"
                                        class="group px-8 py-4 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold rounded-xl transition-all duration-300 flex items-center gap-3 shadow-lg hover:shadow-blue-500/25 transform hover:scale-105">
                                    <i class="fas fa-play text-lg group-hover:scale-110 transition-transform"></i>
                                    <span class="text-lg">Start Processing</span>
                                    <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                                </button>

                                <!-- Quick Demo Button -->
                                <button type="button" @click="quickDemo()" x-show="!connectionStatus.success"
                                        class="group px-8 py-4 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-bold rounded-xl transition-all duration-300 flex items-center gap-3 shadow-lg hover:shadow-purple-500/25 transform hover:scale-105">
                                    <i class="fas fa-rocket text-lg group-hover:scale-110 transition-transform"></i>
                                    <span class="text-lg">Try Demo Mode</span>
                                    <i class="fas fa-magic text-sm group-hover:rotate-12 transition-transform"></i>
                                </button>
                            </div>
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

        <!-- Floating Connect Button -->
        <div class="fixed bottom-8 right-8 z-50" x-data="{ showFloating: false }" x-init="setTimeout(() => showFloating = true, 2000)">
            <div x-show="showFloating" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-0" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-0">
                <button @click="document.querySelector('form').scrollIntoView({ behavior: 'smooth' })"
                        class="group relative w-16 h-16 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-full shadow-2xl hover:shadow-green-500/30 transition-all duration-300 transform hover:scale-110 flex items-center justify-center">
                    <i class="fas fa-plug text-xl group-hover:rotate-12 transition-transform"></i>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 rounded-full flex items-center justify-center">
                        <span class="text-xs font-bold">!</span>
                    </div>
                    <div class="absolute right-20 top-1/2 transform -translate-y-1/2 bg-gray-900 text-white px-3 py-2 rounded-lg text-sm font-medium opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                        Connect Email Account
                        <div class="absolute right-0 top-1/2 transform translate-x-1 -translate-y-1/2 w-0 h-0 border-l-4 border-l-gray-900 border-t-4 border-t-transparent border-b-4 border-b-transparent"></div>
                    </div>
                </button>
            </div>
        </div>
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
                    details: {
                        total_emails: 0,
                        folders: []
                    }
                },
                sessionId: null,
                tryRegularPassword: false,
                showPassword: false,
                providerDisplayNames: {
                    'demo': 'Demo Mode',
                    'gmail': 'Gmail',
                    'yahoo': 'Yahoo Mail',
                    'outlook': 'Outlook/Hotmail',
                    'aol': 'AOL Mail',
                    'zoho': 'Zoho Mail',
                    'imap': 'Custom IMAP',
                    'pop3': 'Custom POP3'
                },

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
                    this.connectionStatus = { 
                        success: false, 
                        message: '', 
                        details: { total_emails: 0, folders: [] } 
                    };

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

                        // Get CSRF token
                        let csrfToken = document.querySelector('meta[name="csrf-token"]');
                        if (!csrfToken) {
                            // Fallback: try to get from form
                            csrfToken = document.querySelector('input[name="_token"]');
                            if (!csrfToken) {
                                throw new Error('CSRF token not found in page head or forms');
                            }
                        }

                        const tokenValue = csrfToken.getAttribute('content') || csrfToken.value;
                        console.log('CSRF Token:', tokenValue);

                        const response = await fetch('/dashboard/test-connection', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': tokenValue,
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const contentType = response.headers.get('content-type');
                        if (!contentType || !contentType.includes('application/json')) {
                            const text = await response.text();
                            throw new Error(`Expected JSON response but got: ${text.substring(0, 100)}...`);
                        }

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
                                details: { total_emails: 0, folders: [] },
                                suggestions: data.suggestions || [],
                                provider: data.provider
                            };
                        }
                    } catch (error) {
                        console.error('Connection test error:', error);
                        this.connectionStatus = {
                            success: false,
                            message: 'Connection failed: ' + error.message,
                            details: { total_emails: 0, folders: [] },
                            suggestions: [
                                'Please check your internet connection and try again.',
                                'Verify your email credentials are correct.',
                                'For Gmail/Yahoo, make sure you\'re using an App Password.',
                                'Check if your email provider allows IMAP access.'
                            ],
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
                },

                isValidEmail(email) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    return emailRegex.test(email);
                },

                togglePasswordVisibility() {
                    this.showPassword = !this.showPassword;
                    const passwordInput = document.querySelector('input[type="password"]');
                    if (passwordInput) {
                        passwordInput.type = this.showPassword ? 'text' : 'password';
                    }
                }
            }
        }
    </script>

    <!-- intersect -->
    <script defer src="{{ asset('vendors/@alpinejs/intersect/dist/cdn.min.js') }}?v={{ time() }}"></script>
    <!-- alpine js -->
    <script src="{{ asset('vendors/alpinejs/dist/cdn.min.js') }}?v={{ time() }}" defer></script>
    @include('layout.includes.scripts')
</body>
</html>
