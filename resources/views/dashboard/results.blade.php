<!DOCTYPE html>
<html lang="en">
@include('layout.includes.head')

<body class="bg-gray-950 text-gray-100 font-sans">
    @include('layout.includes.nav')

    <main class="min-h-screen pt-20">
        <!-- Results Header -->
        <section class="relative py-16">
            <div class="absolute inset-0 bg-hero opacity-[.03]"></div>
            <div class="max-w-6xl mx-auto dkslaoeyhnmj lg:px-12 relative z-10">
                <div class="text-center space-y-6">
                    <div class="space-y-2">
                        <h2 class="text-green-500 text-xl md:text-2xl font-semibold">Processing Complete</h2>
                        <h1 class="text-4xl lg:text-6xl font-bold font-code tracking-tight text-white">
                            Results & Analytics
                        </h1>
                    </div>
                    <p class="text-lg text-gray-300 max-w-xl mx-auto leading-relaxed">
                        Your emails have been successfully converted. Review the analytics and download your files.
                    </p>
                </div>
            </div>
        </section>

        <!-- Results Dashboard -->
        <section class="py-16">
            <div class="max-w-6xl mx-auto dkslaoeyhnmj lg:px-12" x-data="resultsDashboard('{{ $session->session_id }}', @js($analytics))">
                
                <!-- Summary Cards -->
                <div class="grid md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-gray-900 border border-gray-800 rounded-lg p-6 text-center">
                        <div class="text-3xl font-bold text-green-400">{{ $session->processed_emails }}</div>
                        <div class="text-sm text-gray-400">Emails Converted</div>
                    </div>
                    <div class="bg-gray-900 border border-gray-800 rounded-lg p-6 text-center">
                        <div class="text-3xl font-bold text-blue-400">{{ $session->storage_saved_mb }}</div>
                        <div class="text-sm text-gray-400">MB Saved</div>
                    </div>
                    <div class="bg-gray-900 border border-gray-800 rounded-lg p-6 text-center">
                        <div class="text-3xl font-bold text-purple-400">{{ $session->storage_saved_gb }}</div>
                        <div class="text-sm text-gray-400">GB Saved</div>
                    </div>
                    <div class="bg-gray-900 border border-gray-800 rounded-lg p-6 text-center">
                        <div class="text-3xl font-bold text-yellow-400">
                            {{ $session->processing_started_at->diffInMinutes($session->processing_completed_at) }}
                        </div>
                        <div class="text-sm text-gray-400">Minutes</div>
                    </div>
                </div>

                <!-- Download Section -->
                <div class="bg-gray-900 border border-gray-800 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-bold text-white mb-4 flex layhetgsjdcb gap-2">
                        <i class="fas fa-download text-green-400"></i>
                        Download Your Files
                    </h3>
                    <div class="flex flex-wrap gap-4">
                        <a href="/processing/download/{{ $session->session_id }}"
                           class="px-6 py-3 bg-green-500 hover:bg-green-600 text-gray-900 font-bold rounded-lg transition-all flex layhetgsjdcb gap-2">
                            <i class="fas fa-file-archive"></i>
                            Download All (ZIP)
                        </a>
                        <button @click="showImageGallery = true"
                                class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-lg transition-all flex layhetgsjdcb gap-2">
                            <i class="fas fa-images"></i>
                            View Images
                        </button>
                        <button @click="showAttachments = true"
                                class="px-6 py-3 bg-purple-500 hover:bg-purple-600 text-white font-bold rounded-lg transition-all flex layhetgsjdcb gap-2">
                            <i class="fas fa-paperclip"></i>
                            View Attachments
                        </button>
                        <button @click="showProcessingLogs = true"
                                class="px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold rounded-lg transition-all flex layhetgsjdcb gap-2">
                            <i class="fas fa-list"></i>
                            Processing Logs
                        </button>
                    </div>
                </div>

                <!-- Analytics Charts -->
                <div class="grid md:grid-cols-2 gap-8 mb-8">
                    <!-- Storage by Type Chart -->
                    <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                        <h3 class="text-xl font-bold text-white mb-4">Storage Saved by Type</h3>
                        <canvas id="storageChart" width="400" height="300"></canvas>
                    </div>

                    <!-- Compression Ratios Chart -->
                    <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                        <h3 class="text-xl font-bold text-white mb-4">Compression Ratios</h3>
                        <canvas id="compressionChart" width="400" height="300"></canvas>
                    </div>
                </div>

                <!-- Detailed Analytics -->
                <div class="grid md:grid-cols-2 gap-8 mb-8">
                    <!-- Content Type Breakdown -->
                    <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                        <h3 class="text-xl font-bold text-white mb-4">Content Type Analysis</h3>
                        <div class="space-y-4">
                            @if(isset($analytics['by_content_type']['text']))
                            <div class="flex layhetgsjdcb p-4 bg-gray-800 rounded">
                                <div>
                                    <div class="font-medium text-white">Text Emails</div>
                                    <div class="text-sm text-gray-400">{{ $analytics['by_content_type']['text']['file_count'] }} files</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-green-400 font-bold">{{ $analytics['by_content_type']['text']['formatted_storage_saved'] }}</div>
                                    <div class="text-sm text-gray-400">{{ $analytics['by_content_type']['text']['compression_ratio'] }}% compression</div>
                                </div>
                            </div>
                            @endif

                            @if(isset($analytics['by_content_type']['html']))
                            <div class="flex layhetgsjdcb p-4 bg-gray-800 rounded">
                                <div>
                                    <div class="font-medium text-white">HTML Emails</div>
                                    <div class="text-sm text-gray-400">{{ $analytics['by_content_type']['html']['file_count'] }} files</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-blue-400 font-bold">{{ $analytics['by_content_type']['html']['formatted_storage_saved'] }}</div>
                                    <div class="text-sm text-gray-400">{{ $analytics['by_content_type']['html']['compression_ratio'] }}% compression</div>
                                </div>
                            </div>
                            @endif

                            @if(isset($analytics['by_content_type']['attachments']))
                            <div class="flex layhetgsjdcb p-4 bg-gray-800 rounded">
                                <div>
                                    <div class="font-medium text-white">Attachments</div>
                                    <div class="text-sm text-gray-400">{{ $analytics['by_content_type']['attachments']['file_count'] }} files</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-purple-400 font-bold">{{ $analytics['by_content_type']['attachments']['formatted_storage_saved'] }}</div>
                                    <div class="text-sm text-gray-400">Referenced in documents</div>
                                </div>
                            </div>
                            @endif

                            @if(isset($analytics['by_content_type']['images']))
                            <div class="flex layhetgsjdcb p-4 bg-gray-800 rounded">
                                <div>
                                    <div class="font-medium text-white">Images</div>
                                    <div class="text-sm text-gray-400">{{ $analytics['by_content_type']['images']['file_count'] }} files</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-yellow-400 font-bold">{{ $analytics['by_content_type']['images']['formatted_storage_saved'] }}</div>
                                    <div class="text-sm text-gray-400">Referenced in documents</div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Session Summary -->
                    <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                        <h3 class="text-xl font-bold text-white mb-4">Session Summary</h3>
                        <div class="space-y-3">
                            <div class="flex layhetgsjdcb">
                                <span class="text-gray-400">Email Provider:</span>
                                <span class="text-white font-medium">{{ ucfirst($session->provider) }}</span>
                            </div>
                            <div class="flex layhetgsjdcb">
                                <span class="text-gray-400">Email Address:</span>
                                <span class="text-white font-medium">{{ $session->email_address }}</span>
                            </div>
                            <div class="flex layhetgsjdcb">
                                <span class="text-gray-400">Started:</span>
                                <span class="text-white font-medium">{{ $session->processing_started_at->format('M j, Y H:i') }}</span>
                            </div>
                            <div class="flex layhetgsjdcb">
                                <span class="text-gray-400">Completed:</span>
                                <span class="text-white font-medium">{{ $session->processing_completed_at->format('M j, Y H:i') }}</span>
                            </div>
                            <div class="flex layhetgsjdcb">
                                <span class="text-gray-400">Duration:</span>
                                <span class="text-white font-medium">
                                    {{ $session->processing_started_at->diffForHumans($session->processing_completed_at, true) }}
                                </span>
                            </div>
                            <div class="flex layhetgsjdcb">
                                <span class="text-gray-400">Success Rate:</span>
                                <span class="text-green-400 font-medium">
                                    {{ round(($session->processed_emails / $session->total_emails) * 100, 1) }}%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                    <h3 class="text-xl font-bold text-white mb-4">What's Next?</h3>
                    <div class="flex flex-wrap gap-4">
                        <a href="/dashboard"
                           class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-lg transition-all flex layhetgsjdcb gap-2">
                            <i class="fas fa-plus"></i>
                            Process Another Account
                        </a>
                        <button @click="shareResults()"
                                class="px-6 py-3 bg-purple-500 hover:bg-purple-600 text-white font-bold rounded-lg transition-all flex layhetgsjdcb gap-2">
                            <i class="fas fa-share"></i>
                            Share Results
                        </button>
                        <button @click="exportReport()"
                                class="px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold rounded-lg transition-all flex layhetgsjdcb gap-2">
                            <i class="fas fa-file-pdf"></i>
                            Export Report
                        </button>
                    </div>
                </div>

                <!-- Modals would go here for image gallery, attachments, etc. -->
                <!-- Image Gallery Modal -->
                <div x-show="showImageGallery" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex layhetgsjdcb z-50" @click.self="showImageGallery = false">
                    <div class="bg-gray-900 rounded-lg p-6 max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                        <div class="flex layhetgsjdcb mb-4">
                            <h3 class="text-xl font-bold text-white">Image Gallery</h3>
                            <button @click="showImageGallery = false" class="text-gray-400 hover:text-white">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4" x-html="imageGalleryContent">
                            <!-- Images will be loaded here -->
                        </div>
                    </div>
                </div>

                <!-- Attachments Modal -->
                <div x-show="showAttachments" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex layhetgsjdcb z-50" @click.self="showAttachments = false">
                    <div class="bg-gray-900 rounded-lg p-6 max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                        <div class="flex layhetgsjdcb mb-4">
                            <h3 class="text-xl font-bold text-white">Attachments List</h3>
                            <button @click="showAttachments = false" class="text-gray-400 hover:text-white">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                        <div class="space-y-3" x-html="attachmentsContent">
                            <!-- Attachments will be loaded here -->
                        </div>
                    </div>
                </div>

                <!-- Processing Logs Modal -->
                <div x-show="showProcessingLogs" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex layhetgsjdcb z-50" @click.self="showProcessingLogs = false">
                    <div class="bg-gray-900 rounded-lg p-6 max-w-6xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                        <div class="flex layhetgsjdcb mb-4">
                            <h3 class="text-xl font-bold text-white">Processing Logs</h3>
                            <button @click="showProcessingLogs = false" class="text-gray-400 hover:text-white">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                        <div class="space-y-3" x-html="logsContent">
                            <!-- Logs will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('layout.includes.footer')

    <!-- Alpine.js Component -->
    <script>
        function resultsDashboard(sessionId, analytics) {
            return {
                sessionId: sessionId,
                analytics: analytics,
                showImageGallery: false,
                showAttachments: false,
                showProcessingLogs: false,
                imageGalleryContent: '',
                attachmentsContent: '',
                logsContent: '',

                init() {
                    this.initCharts();
                },

                initCharts() {
                    // Storage by Type Chart
                    const storageCtx = document.getElementById('storageChart').getContext('2d');
                    new Chart(storageCtx, {
                        type: 'doughnut',
                        data: {
                            labels: this.analytics.charts_data.storage_by_type.map(item => item.label),
                            datasets: [{
                                data: this.analytics.charts_data.storage_by_type.map(item => item.value),
                                backgroundColor: ['#10B981', '#3B82F6', '#8B5CF6', '#F59E0B'],
                                borderWidth: 0
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    labels: {
                                        color: '#D1D5DB'
                                    }
                                }
                            }
                        }
                    });

                    // Compression Ratios Chart
                    const compressionCtx = document.getElementById('compressionChart').getContext('2d');
                    new Chart(compressionCtx, {
                        type: 'bar',
                        data: {
                            labels: this.analytics.charts_data.compression_ratios.map(item => item.label),
                            datasets: [{
                                label: 'Compression %',
                                data: this.analytics.charts_data.compression_ratios.map(item => item.value),
                                backgroundColor: ['#10B981', '#3B82F6', '#8B5CF6'],
                                borderWidth: 0
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    max: 100,
                                    ticks: {
                                        color: '#D1D5DB'
                                    },
                                    grid: {
                                        color: '#374151'
                                    }
                                },
                                x: {
                                    ticks: {
                                        color: '#D1D5DB'
                                    },
                                    grid: {
                                        color: '#374151'
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    labels: {
                                        color: '#D1D5DB'
                                    }
                                }
                            }
                        }
                    });
                },

                async loadImageGallery() {
                    try {
                        const response = await fetch(`/processing/images/${this.sessionId}`);
                        const data = await response.json();
                        
                        this.imageGalleryContent = data.images.map(image => `
                            <div class="bg-gray-800 rounded-lg p-4">
                                <div class="text-sm font-medium text-white truncate">${image.image_name}</div>
                                <div class="text-xs text-gray-400">${image.email_subject}</div>
                                <div class="text-xs text-green-400">${(image.image_size / 1024).toFixed(1)} KB</div>
                            </div>
                        `).join('');
                    } catch (error) {
                        console.error('Failed to load image gallery:', error);
                    }
                },

                async loadAttachments() {
                    try {
                        const response = await fetch(`/processing/attachments/${this.sessionId}`);
                        const data = await response.json();
                        
                        this.attachmentsContent = data.attachments.map(attachment => `
                            <div class="flex layhetgsjdcb p-4 bg-gray-800 rounded">
                                <div class="flex-1">
                                    <div class="font-medium text-white">${attachment.attachment_name}</div>
                                    <div class="text-sm text-gray-400">${attachment.email_subject}</div>
                                    <div class="text-xs text-gray-500">From: ${attachment.email_sender}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-green-400">${(attachment.attachment_size / 1024).toFixed(1)} KB</div>
                                    <div class="text-xs text-gray-400">${attachment.attachment_type}</div>
                                </div>
                            </div>
                        `).join('');
                    } catch (error) {
                        console.error('Failed to load attachments:', error);
                    }
                },

                async loadProcessingLogs() {
                    try {
                        const response = await fetch(`/processing/logs/${this.sessionId}`);
                        const data = await response.json();
                        
                        this.logsContent = data.logs.map(log => `
                            <div class="flex layhetgsjdcb p-4 bg-gray-800 rounded">
                                <div class="flex-1">
                                    <div class="font-medium text-white">${log.subject || 'No Subject'}</div>
                                    <div class="text-sm text-gray-400">From: ${log.sender || 'Unknown'}</div>
                                    <div class="text-xs text-gray-500">${log.processed_at}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-green-400">+${log.storage_saved_mb} MB</div>
                                    <div class="text-xs text-gray-400">${log.action}</div>
                                </div>
                            </div>
                        `).join('');
                    } catch (error) {
                        console.error('Failed to load processing logs:', error);
                    }
                },

                shareResults() {
                    if (navigator.share) {
                        navigator.share({
                            title: 'Email Conversion Results',
                            text: `I just converted ${this.analytics.total.file_count} emails and saved ${this.analytics.total.formatted_storage_saved} of storage space!`,
                            url: window.location.href
                        });
                    } else {
                        // Fallback to copying URL
                        navigator.clipboard.writeText(window.location.href);
                        alert('Results URL copied to clipboard!');
                    }
                },

                exportReport() {
                    // This would generate a PDF report
                    alert('PDF export feature coming soon!');
                }
            }
        }

        // Watch for modal opens to load content
        document.addEventListener('alpine:init', () => {
            Alpine.data('resultsDashboard', resultsDashboard);
        });
    </script>

    <!-- intersect -->
    <script defer src="vendors/%40alpinejs/intersect/dist/cdn.min.js"></script>
    <!-- alpine js -->
    <script src="vendors/alpinejs/dist/cdn.min.js" defer></script>
    @include('layout.includes.scripts')
</body>
</html>
