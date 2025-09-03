<!DOCTYPE html>
<html lang="en">
@include('layout.includes.head')

<body class="bg-gray-950 text-gray-100 font-sans">
    @include('layout.includes.nav')

    <main class="min-h-screen pt-20">
        <!-- Connect Header -->
        <section class="relative py-16">
            <div class="absolute inset-0 bg-hero opacity-[.03]"></div>
            <div class="max-w-4xl mx-auto px-6 lg:px-12 relative z-10">
                <div class="text-center space-y-6">
                    <div class="space-y-2">
                        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 flex items-center justify-center gap-3">
                            <i class="fas fa-plug text-green-400"></i>
                            Connecting to Email
                        </h1>
                        <p class="text-lg text-gray-300 max-w-2xl mx-auto leading-relaxed">
                            Establishing secure connection to your email account...
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Connection Process -->
        <section class="py-16">
            <div class="max-w-4xl mx-auto px-6 lg:px-12">
                <div class="bg-gray-900/50 backdrop-blur-sm border border-gray-800 rounded-2xl p-8">
                    <!-- Connection Details -->
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                            <i class="fas fa-info-circle text-blue-400"></i>
                            Connection Details
                        </h3>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="bg-gray-800/50 rounded-lg p-4">
                                <div class="flex items-center gap-3 mb-2">
                                    <i class="fas fa-server text-green-400"></i>
                                    <span class="text-gray-300 font-medium">Provider</span>
                                </div>
                                <div class="text-white font-semibold" id="provider-display">{{ $provider ?: 'Not selected' }}</div>
                            </div>
                            
                            <div class="bg-gray-800/50 rounded-lg p-4">
                                <div class="flex items-center gap-3 mb-2">
                                    <i class="fas fa-envelope text-blue-400"></i>
                                    <span class="text-gray-300 font-medium">Email</span>
                                </div>
                                <div class="text-white font-semibold" id="email-display">{{ $email ?: 'Not entered' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Connection Status -->
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                            <i class="fas fa-cog fa-spin text-yellow-400"></i>
                            Connection Status
                        </h3>
                        
                        <div class="bg-gray-800/50 rounded-lg p-6">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-4 h-4 bg-yellow-400 rounded-full animate-pulse"></div>
                                <span class="text-yellow-400 font-medium" id="status-text">Initializing connection...</span>
                            </div>
                            
                            <div class="w-full bg-gray-700 rounded-full h-2 mb-4">
                                <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 h-2 rounded-full transition-all duration-1000" 
                                     id="progress-bar" style="width: 0%"></div>
                            </div>
                            
                            <div class="text-sm text-gray-400" id="status-detail">
                                Preparing to connect to your email server...
                            </div>
                        </div>
                    </div>

                    <!-- Connection Steps -->
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                            <i class="fas fa-list-ol text-purple-400"></i>
                            Connection Steps
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-center gap-4 p-4 bg-gray-800/30 rounded-lg" id="step-1">
                                <div class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center text-sm font-bold text-gray-400">1</div>
                                <div class="flex-1">
                                    <div class="text-white font-medium">Validating credentials</div>
                                    <div class="text-sm text-gray-400">Checking email and password format</div>
                                </div>
                                <div class="text-gray-500">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4 p-4 bg-gray-800/30 rounded-lg" id="step-2">
                                <div class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center text-sm font-bold text-gray-400">2</div>
                                <div class="flex-1">
                                    <div class="text-white font-medium">Connecting to server</div>
                                    <div class="text-sm text-gray-400">Establishing secure IMAP connection</div>
                                </div>
                                <div class="text-gray-500">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4 p-4 bg-gray-800/30 rounded-lg" id="step-3">
                                <div class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center text-sm font-bold text-gray-400">3</div>
                                <div class="flex-1">
                                    <div class="text-white font-medium">Authenticating</div>
                                    <div class="text-sm text-gray-400">Verifying login credentials</div>
                                </div>
                                <div class="text-gray-500">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4 p-4 bg-gray-800/30 rounded-lg" id="step-4">
                                <div class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center text-sm font-bold text-gray-400">4</div>
                                <div class="flex-1">
                                    <div class="text-white font-medium">Loading email data</div>
                                    <div class="text-sm text-gray-400">Fetching folders and email count</div>
                                </div>
                                <div class="text-gray-500">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <button type="button" onclick="window.location.href='/dashboard'" 
                                class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white font-medium rounded-lg transition-all">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Dashboard
                        </button>
                        
                        <button type="button" id="retry-btn" onclick="retryConnection()" 
                                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-all hidden">
                            <i class="fas fa-redo mr-2"></i>
                            Retry Connection
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('layout.includes.footer')

    <!-- Alpine.js Component -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Start the connection process
            startConnection();
        });

        function startConnection() {
            const provider = '{{ $provider }}';
            const email = '{{ $email }}';
            const password = '{{ $password }}';
            
            if (!provider || !email || !password) {
                showError('Missing connection details. Please go back and fill in all fields.');
                return;
            }
            
            // Update provider display
            const providerNames = {
                'gmail': 'Gmail',
                'yahoo': 'Yahoo Mail',
                'outlook': 'Outlook/Hotmail',
                'aol': 'AOL Mail',
                'zoho': 'Zoho Mail',
                'demo': 'Demo Mode',
                'imap': 'Custom IMAP',
                'pop3': 'Custom POP3'
            };
            
            document.getElementById('provider-display').textContent = providerNames[provider] || provider;
            
            // Start connection process
            connectToEmail(provider, email, password);
        }

        async function connectToEmail(provider, email, password) {
            try {
                // Step 1: Validating credentials
                updateStep(1, 'active');
                updateStatus('Validating credentials...', 'yellow', 25);
                await sleep(1000);
                
                // Step 2: Connecting to server
                updateStep(1, 'completed');
                updateStep(2, 'active');
                updateStatus('Connecting to email server...', 'yellow', 50);
                await sleep(1500);
                
                // Step 3: Authenticating
                updateStep(2, 'completed');
                updateStep(3, 'active');
                updateStatus('Authenticating with server...', 'yellow', 75);
                await sleep(1000);
                
                // Make actual connection request
                const formData = new FormData();
                formData.append('provider', provider);
                formData.append('email', email);
                formData.append('password', password);
                
                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                const response = await fetch('/dashboard/test-connection', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });
                
                const data = await response.json();
                
                // Step 4: Loading email data
                updateStep(3, 'completed');
                updateStep(4, 'active');
                updateStatus('Loading email data...', 'yellow', 90);
                await sleep(1000);
                
                if (data.success) {
                    // Success
                    updateStep(4, 'completed');
                    updateStatus('Connection successful!', 'green', 100);
                    
                    setTimeout(() => {
                        // Redirect to emails page
                        window.location.href = `/dashboard/emails/${data.session_id}`;
                    }, 2000);
                } else {
                    // Error
                    showError(data.message || 'Connection failed');
                }
                
            } catch (error) {
                console.error('Connection error:', error);
                showError('Connection failed: ' + error.message);
            }
        }

        function updateStep(stepNumber, status) {
            const step = document.getElementById(`step-${stepNumber}`);
            const icon = step.querySelector('div:first-child');
            const statusIcon = step.querySelector('div:last-child');
            
            if (status === 'active') {
                icon.className = 'w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center text-sm font-bold text-white';
                statusIcon.innerHTML = '<i class="fas fa-spinner fa-spin text-yellow-400"></i>';
            } else if (status === 'completed') {
                icon.className = 'w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-sm font-bold text-white';
                statusIcon.innerHTML = '<i class="fas fa-check text-green-400"></i>';
            } else if (status === 'error') {
                icon.className = 'w-8 h-8 bg-red-500 rounded-full flex items-center justify-center text-sm font-bold text-white';
                statusIcon.innerHTML = '<i class="fas fa-times text-red-400"></i>';
            }
        }

        function updateStatus(text, color, progress) {
            document.getElementById('status-text').textContent = text;
            document.getElementById('status-text').className = `text-${color}-400 font-medium`;
            document.getElementById('progress-bar').style.width = progress + '%';
            
            if (color === 'green') {
                document.getElementById('progress-bar').className = 'bg-gradient-to-r from-green-400 to-green-500 h-2 rounded-full transition-all duration-1000';
            } else if (color === 'red') {
                document.getElementById('progress-bar').className = 'bg-gradient-to-r from-red-400 to-red-500 h-2 rounded-full transition-all duration-1000';
            } else {
                document.getElementById('progress-bar').className = 'bg-gradient-to-r from-yellow-400 to-yellow-500 h-2 rounded-full transition-all duration-1000';
            }
        }

        function showError(message) {
            updateStatus('Connection failed', 'red', 100);
            document.getElementById('status-detail').textContent = message;
            document.getElementById('retry-btn').classList.remove('hidden');
            
            // Mark all steps as error
            for (let i = 1; i <= 4; i++) {
                updateStep(i, 'error');
            }
        }

        function retryConnection() {
            // Reset everything
            document.getElementById('retry-btn').classList.add('hidden');
            document.getElementById('status-detail').textContent = 'Preparing to connect to your email server...';
            
            // Reset all steps
            for (let i = 1; i <= 4; i++) {
                const step = document.getElementById(`step-${i}`);
                const icon = step.querySelector('div:first-child');
                const statusIcon = step.querySelector('div:last-child');
                
                icon.className = 'w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center text-sm font-bold text-gray-400';
                statusIcon.innerHTML = '<i class="fas fa-clock"></i>';
            }
            
            // Restart connection
            startConnection();
        }

        function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }
    </script>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
