<!DOCTYPE html>
<html lang="en">
@include('layout.includes.head')

<body class="bg-gray-950 text-gray-100 font-sans">
    @include('layout.includes.nav')

    <main class="min-h-screen pt-20">
        <!-- Processing Header -->
        <section class="relative py-16">
            <div class="absolute inset-0 bg-hero opacity-[.03]"></div>
            <div class="max-w-6xl mx-auto dkslaoeyhnmj lg:px-12 relative z-10">
                <div class="text-center space-y-6">
                    <div class="space-y-2">
                        <h2 class="text-green-500 text-xl md:text-2xl font-semibold">Processing Emails</h2>
                        <h1 class="text-4xl lg:text-6xl font-bold font-code tracking-tight text-white">
                            {{ $session->email_address }}
                        </h1>
                    </div>
                    <p class="text-lg text-gray-300 max-w-xl mx-auto leading-relaxed">
                        Converting your emails to Word documents with real-time progress tracking and analytics.
                    </p>
                </div>
            </div>
        </section>

        <!-- Processing Dashboard -->
        <section class="py-16">
            <div class="max-w-6xl mx-auto dkslaoeyhnmj lg:px-12" x-data="processingDashboard('{{ $session->session_id }}')">
                
                <!-- Progress Overview -->
                <div class="grid md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-gray-900 border border-gray-800 rounded-lg p-6 text-center">
                        <div class="text-3xl font-bold text-green-400" x-text="progress.processed_emails || 0"></div>
                        <div class="text-sm text-gray-400">Processed</div>
                    </div>
                    <div class="bg-gray-900 border border-gray-800 rounded-lg p-6 text-center">
                        <div class="text-3xl font-bold text-blue-400" x-text="progress.remaining_emails || 0"></div>
                        <div class="text-sm text-gray-400">Remaining</div>
                    </div>
                    <div class="bg-gray-900 border border-gray-800 rounded-lg p-6 text-center">
                        <div class="text-3xl font-bold text-purple-400" x-text="progress.storage_saved_mb || 0"></div>
                        <div class="text-sm text-gray-400">MB Saved</div>
                    </div>
                    <div class="bg-gray-900 border border-gray-800 rounded-lg p-6 text-center">
                        <div class="text-3xl font-bold text-yellow-400" x-text="Math.round(progress.progress_percentage || 0)"></div>
                        <div class="text-sm text-gray-400">% Complete</div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="bg-gray-900 border border-gray-800 rounded-lg p-6 mb-8">
                    <div class="flex layhetgsjdcb mb-4">
                        <h3 class="text-xl font-bold text-white">Processing Progress</h3>
                        <div class="flex gap-2">
                            <button @click="pauseProcessing()" x-show="session.status === 'processing'"
                                    class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-medium rounded transition-all">
                                <i class="fas fa-pause mr-2"></i>Pause
                            </button>
                            <button @click="resumeProcessing()" x-show="session.status === 'paused'"
                                    class="px-4 py-2 bg-green-500 hover:bg-green-600 text-gray-900 font-medium rounded transition-all">
                                <i class="fas fa-play mr-2"></i>Resume
                            </button>
                        </div>
                    </div>
                    
                    <div class="w-full bg-gray-800 rounded-full h-4 mb-4">
                        <div class="bg-gradient-to-r from-green-500 to-blue-500 h-4 rounded-full transition-all duration-500"
                             :style="`width: ${progress.progress_percentage || 0}%`"></div>
                    </div>
                    
                    <div class="flex layhetgsjdcb text-sm text-gray-400">
                        <span x-text="`${progress.processed_emails || 0} of ${progress.total_emails || 0} emails`"></span>
                        <span x-text="progress.estimated_completion || 'Calculating...'"></span>
                    </div>
                </div>

                <!-- Real-time Stats -->
                <div class="grid md:grid-cols-2 gap-8 mb-8">
                    <!-- Storage Breakdown -->
                    <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                        <h3 class="text-xl font-bold text-white mb-4 flex layhetgsjdcb gap-2">
                            <i class="fas fa-chart-pie text-green-400"></i>
                            Storage Breakdown
                        </h3>
                        <div class="space-y-4">
                            <template x-for="(item, type) in progress.storage_breakdown" :key="type">
                                <div class="flex layhetgsjdcb">
                                    <div class="flex layhetgsjdcb gap-3">
                                        <div class="w-3 h-3 rounded-full" 
                                             :class="{
                                                 'bg-green-400': type === 'text_emails',
                                                 'bg-blue-400': type === 'html_emails',
                                                 'bg-purple-400': type === 'attachments',
                                                 'bg-yellow-400': type === 'images'
                                             }"></div>
                                        <span class="text-gray-300 capitalize" x-text="type.replace('_', ' ')"></span>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-white font-medium" x-text="`${item.saved_mb.toFixed(1)} MB`"></div>
                                        <div class="text-xs text-gray-400" x-text="`${item.count} items`"></div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                        <h3 class="text-xl font-bold text-white mb-4 flex layhetgsjdcb gap-2">
                            <i class="fas fa-clock text-blue-400"></i>
                            Recent Activity
                        </h3>
                        <div class="space-y-3 max-h-64 overflow-y-auto">
                            <template x-for="item in progress.recent_processed" :key="item.processed_at">
                                <div class="flex layhetgsjdcb p-3 bg-gray-800 rounded">
                                    <div class="flex-1 min-w-0">
                                        <div class="text-sm font-medium text-white truncate" x-text="item.subject"></div>
                                        <div class="text-xs text-gray-400" x-text="item.processed_at"></div>
                                    </div>
                                    <div class="text-sm text-green-400" x-text="`+${item.storage_saved_mb} MB`"></div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Status Messages -->
                <div x-show="session.status === 'completed'" x-transition
                     class="bg-green-900/50 border border-green-400 rounded-lg p-6 mb-8">
                    <div class="flex layhetgsjdcb gap-4">
                        <i class="fas fa-check-circle text-green-400 text-2xl"></i>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-green-300 mb-2">Processing Complete!</h3>
                            <p class="text-green-200 mb-4">
                                All emails have been successfully converted to Word documents. 
                                You saved <span class="font-bold" x-text="progress.storage_saved_mb"></span> MB 
                                (<span x-text="progress.storage_saved_gb"></span> GB) of storage space.
                            </p>
                            <a :href="`/dashboard/results/${session.id}`"
                               class="inline-flex layhetgsjdcb gap-2 px-6 py-3 bg-green-500 hover:bg-green-600 text-gray-900 font-bold rounded-lg transition-all">
                                <i class="fas fa-chart-bar"></i>
                                View Results & Download
                            </a>
                        </div>
                    </div>
                </div>

                <div x-show="session.status === 'failed'" x-transition
                     class="bg-red-900/50 border border-red-400 rounded-lg p-6 mb-8">
                    <div class="flex layhetgsjdcb gap-4">
                        <i class="fas fa-exclamation-triangle text-red-400 text-2xl"></i>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-red-300 mb-2">Processing Failed</h3>
                            <p class="text-red-200 mb-2" x-text="session.error_message"></p>
                            <button @click="retryProcessing()"
                                    class="inline-flex layhetgsjdcb gap-2 px-6 py-3 bg-red-500 hover:bg-red-600 text-white font-bold rounded-lg transition-all">
                                <i class="fas fa-redo"></i>
                                Retry Processing
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Processing Controls -->
                <div x-show="session.status === 'processing' || session.status === 'paused'" 
                     class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                    <h3 class="text-xl font-bold text-white mb-4">Processing Controls</h3>
                    <div class="flex flex-wrap gap-4">
                        <button @click="pauseProcessing()" x-show="session.status === 'processing'"
                                class="px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold rounded-lg transition-all flex layhetgsjdcb gap-2">
                            <i class="fas fa-pause"></i>
                            Pause Processing
                        </button>
                        <button @click="resumeProcessing()" x-show="session.status === 'paused'"
                                class="px-6 py-3 bg-green-500 hover:bg-green-600 text-gray-900 font-bold rounded-lg transition-all flex layhetgsjdcb gap-2">
                            <i class="fas fa-play"></i>
                            Resume Processing
                        </button>
                        <button @click="viewLogs()"
                                class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-lg transition-all flex layhetgsjdcb gap-2">
                            <i class="fas fa-list"></i>
                            View Logs
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('layout.includes.footer')

    <!-- Alpine.js Component -->
    <script>
        function processingDashboard(sessionId) {
            return {
                sessionId: sessionId,
                session: {},
                progress: {},
                updateInterval: null,

                init() {
                    this.startProcessing();
                    this.startUpdates();
                },

                async startProcessing() {
                    try {
                        const response = await fetch(`/processing/start/${this.sessionId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });
                        const data = await response.json();
                        console.log('Processing started:', data);
                    } catch (error) {
                        console.error('Failed to start processing:', error);
                    }
                },

                startUpdates() {
                    this.updateStatus();
                    this.updateInterval = setInterval(() => {
                        this.updateStatus();
                    }, 2000); // Update every 2 seconds
                },

                async updateStatus() {
                    try {
                        const response = await fetch(`/dashboard/session/${this.sessionId}/status`);
                        const data = await response.json();
                        this.session = data.session;
                        this.progress = data.progress;

                        // Stop updates if processing is complete or failed
                        if (this.session.status === 'completed' || this.session.status === 'failed') {
                            if (this.updateInterval) {
                                clearInterval(this.updateInterval);
                                this.updateInterval = null;
                            }
                        }
                    } catch (error) {
                        console.error('Failed to update status:', error);
                    }
                },

                async pauseProcessing() {
                    try {
                        const response = await fetch(`/processing/pause/${this.sessionId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });
                        const data = await response.json();
                        console.log('Processing paused:', data);
                    } catch (error) {
                        console.error('Failed to pause processing:', error);
                    }
                },

                async resumeProcessing() {
                    try {
                        const response = await fetch(`/processing/resume/${this.sessionId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });
                        const data = await response.json();
                        console.log('Processing resumed:', data);
                        this.startUpdates(); // Restart updates
                    } catch (error) {
                        console.error('Failed to resume processing:', error);
                    }
                },

                retryProcessing() {
                    window.location.reload();
                },

                viewLogs() {
                    // Open logs in a new window or modal
                    window.open(`/processing/logs/${this.sessionId}`, '_blank');
                },

                destroy() {
                    if (this.updateInterval) {
                        clearInterval(this.updateInterval);
                    }
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
