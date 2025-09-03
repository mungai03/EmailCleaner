<!DOCTYPE html>
<html lang="en">
@include('layout.includes.head')

<body class="bg-gray-950 text-gray-100 font-sans">
    @include('layout.includes.nav')

    <main class="min-h-screen pt-20">
        <!-- Email Viewer Header -->
        <section class="relative py-16">
            <div class="absolute inset-0 bg-hero opacity-[.03]"></div>
            <div class="max-w-7xl mx-auto dkslaoeyhnmj lg:px-12 relative z-10">
                <div class="text-center space-y-6">
                    <div class="space-y-2">
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500/10 border border-blue-500/20 rounded-full">
                            <div class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></div>
                            <span class="text-blue-400 text-sm font-medium">Email Viewer</span>
                        </div>
                        <h1 class="text-4xl lg:text-6xl font-bold font-code tracking-tight text-white">
                            Your Emails
                        </h1>
                    </div>
                    <p class="text-lg text-gray-300 max-w-2xl mx-auto leading-relaxed">
                        View and manage all emails from your connected account: <strong class="text-green-400">{{ $session->email_address }}</strong>
                    </p>
                </div>
            </div>
        </section>

        <!-- Email List Section -->
        <section class="py-8">
            <div class="max-w-7xl mx-auto px-4 lg:px-12">
                <div class="bg-gray-900 border border-gray-800 rounded-lg p-6" x-data="emailViewer()">


                    <!-- Controls -->
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
                        <div class="flex items-center gap-4">
                            <h3 class="text-2xl font-bold text-white flex items-center gap-3">
                                <i class="fas fa-envelope text-blue-400"></i>
                                Email Inbox
                            </h3>
                            <div class="flex items-center gap-2 px-3 py-1 bg-gray-800 rounded-full">
                                <i class="fas fa-folder text-gray-400"></i>
                                <span class="text-sm text-gray-300" x-text="currentFolder"></span>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <!-- Search -->
                            <div class="relative">
                                <input type="text" x-model="searchQuery" @input="filterEmails()" 
                                       placeholder="Search emails..." 
                                       class="w-64 px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-blue-400 focus:outline-none">
                                <i class="fas fa-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                            
                            <!-- Refresh Button -->
                            <button @click="loadEmails()" :disabled="loading"
                                    class="px-4 py-2 bg-blue-500 hover:bg-blue-600 disabled:bg-gray-700 text-white rounded-lg transition-all flex items-center gap-2">
                                <i :class="loading ? 'fas fa-spinner fa-spin' : 'fas fa-sync-alt'"></i>
                                <span x-text="loading ? 'Loading...' : 'Refresh'"></span>
                            </button>
                        </div>
                    </div>

                    <!-- Email Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                        <div class="bg-gray-800 rounded-lg p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-envelope text-white"></i>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-white" x-text="totalEmails"></div>
                                    <div class="text-sm text-gray-400">Total Emails</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-800 rounded-lg p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-envelope-open text-white"></i>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-white" x-text="readEmails"></div>
                                    <div class="text-sm text-gray-400">Read</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-800 rounded-lg p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-exclamation text-white"></i>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-white" x-text="importantEmails"></div>
                                    <div class="text-sm text-gray-400">Important</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-800 rounded-lg p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-paperclip text-white"></i>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-white" x-text="emailsWithAttachments"></div>
                                    <div class="text-sm text-gray-400">With Attachments</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Email List -->
                    <div class="space-y-3" x-show="!loading && filteredEmails.length > 0" x-transition>
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-white font-medium" x-text="`Showing ${filteredEmails.length} emails`"></div>
                            <div class="text-sm text-gray-400" x-text="`Folder: ${currentFolder}`"></div>
                        </div>
                        <template x-for="email in filteredEmails" :key="email.uid">
                            <div @click="viewEmail(email)" 
                                 class="bg-gray-800 hover:bg-gray-700 border border-gray-700 hover:border-gray-600 rounded-lg p-4 cursor-pointer transition-all group">
                                <div class="flex items-start gap-4">
                                    <!-- Email Status Icons -->
                                    <div class="flex flex-col items-center gap-1 mt-1">
                                        <div class="w-3 h-3 rounded-full" 
                                             :class="email.is_read ? 'bg-gray-500' : 'bg-blue-500'"></div>
                                        <i x-show="email.is_important" class="fas fa-star text-yellow-400 text-xs"></i>
                                        <i x-show="email.has_attachments" class="fas fa-paperclip text-gray-400 text-xs"></i>
                                    </div>
                                    
                                    <!-- Email Content -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="font-semibold text-white truncate" x-text="email.from_name || email.from"></span>
                                            <span class="text-gray-400 text-sm" x-text="email.from"></span>
                                        </div>
                                        <div class="text-white font-medium mb-1" x-text="email.subject"></div>
                                        <div class="text-gray-400 text-sm line-clamp-2" x-text="email.preview"></div>
                                    </div>
                                    
                                    <!-- Email Meta -->
                                    <div class="flex flex-col items-end gap-1 text-sm text-gray-400">
                                        <div x-text="formatDate(email.date)"></div>
                                        <div class="flex items-center gap-2">
                                            <span x-show="email.attachment_count > 0" 
                                                  class="px-2 py-1 bg-purple-500/20 text-purple-400 rounded text-xs">
                                                <i class="fas fa-paperclip mr-1"></i>
                                                <span x-text="email.attachment_count"></span>
                                            </span>
                                            <span class="text-xs" x-text="formatSize(email.size)"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Loading State -->
                    <div x-show="loading" class="text-center py-16">
                        <div class="inline-flex items-center gap-3">
                            <div class="w-8 h-8 border-2 border-blue-400 border-t-transparent rounded-full animate-spin"></div>
                            <span class="text-gray-400 text-lg">Loading emails...</span>
                        </div>
                        <p class="text-gray-500 mt-2">Please wait while we fetch your emails</p>
                    </div>

                    <!-- Empty State -->
                    <div x-show="!loading && emails.length === 0" class="text-center py-16">
                        <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-inbox text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-semibold text-white mb-3">No emails found</h3>
                        <p class="text-gray-400 mb-6">We couldn't find any emails in your inbox. This might be due to a connection issue.</p>
                        <div class="space-y-3">
                            <button @click="loadEmails()" class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors">
                                <i class="fas fa-sync-alt mr-2"></i>
                                Try Again
                            </button>
                            <div class="text-sm text-gray-500">
                                <p>If the problem persists, please:</p>
                                <ul class="list-disc list-inside mt-2 space-y-1">
                                    <li>Ensure you're using an App Password (not your regular Gmail password)</li>
                                    <li>Check that IMAP is enabled in your Gmail settings</li>
                                    <li>Try creating a new connection from the dashboard</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Email Detail Modal -->
        <div x-show="selectedEmail" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" style="display: none;">
            <div class="bg-gray-900 border border-gray-800 rounded-lg max-w-4xl w-full max-h-[90vh] overflow-hidden">
                <div class="flex items-center justify-between p-6 border-b border-gray-800">
                    <h3 class="text-xl font-bold text-white" x-text="selectedEmail?.subject"></h3>
                    <button @click="selectedEmail = null" class="text-gray-400 hover:text-white">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
                    <div x-show="selectedEmail" class="space-y-4">
                        <!-- Email Headers -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-400">From:</span>
                                <span class="text-white ml-2" x-text="selectedEmail?.from_name || selectedEmail?.from"></span>
                            </div>
                            <div>
                                <span class="text-gray-400">To:</span>
                                <span class="text-white ml-2" x-text="selectedEmail?.to"></span>
                            </div>
                            <div>
                                <span class="text-gray-400">Date:</span>
                                <span class="text-white ml-2" x-text="formatDate(selectedEmail?.date)"></span>
                            </div>
                            <div>
                                <span class="text-gray-400">Size:</span>
                                <span class="text-white ml-2" x-text="formatSize(selectedEmail?.size)"></span>
                            </div>
                        </div>

                        <!-- Attachments -->
                        <div x-show="selectedEmail?.has_attachments" class="bg-gray-800 rounded-lg p-4">
                            <h4 class="text-white font-semibold mb-3 flex items-center gap-2">
                                <i class="fas fa-paperclip"></i>
                                Attachments (<span x-text="selectedEmail?.attachment_count"></span>)
                            </h4>
                            <div class="space-y-2">
                                <template x-for="attachment in selectedEmail?.attachments || []" :key="attachment.name">
                                    <div class="flex items-center gap-3 p-2 bg-gray-700 rounded">
                                        <i class="fas fa-file text-gray-400"></i>
                                        <span class="text-white" x-text="attachment.name"></span>
                                        <span class="text-gray-400 text-sm" x-text="formatSize(attachment.size)"></span>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Email Content -->
                        <div class="bg-gray-800 rounded-lg p-4">
                            <div class="prose prose-invert max-w-none" x-html="selectedEmail?.html_content || selectedEmail?.text_content"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('layout.includes.footer')

    <!-- Alpine.js Component -->
    <script>
        function emailViewer() {
            return {
                emails: [],
                filteredEmails: [],
                selectedEmail: null,
                loading: false,
                searchQuery: '',
                currentFolder: 'INBOX',
                sessionId: '{{ $session->session_id }}',

                init() {
                    this.loadEmails();
                },

                async loadEmails() {
                    this.loading = true;
                    try {
                        const response = await fetch(`/dashboard/emails/${this.sessionId}/fetch?limit=100`);
                        const data = await response.json();
                        
                        if (data.success) {
                            this.emails = data.emails;
                            this.filteredEmails = data.emails;
                            this.currentFolder = data.folder;
                        } else {
                            console.error('Failed to load emails:', data.message);
                        }
                    } catch (error) {
                        console.error('Error loading emails:', error);
                    } finally {
                        this.loading = false;
                    }
                },

                async viewEmail(email) {
                    try {
                        const response = await fetch(`/dashboard/emails/${this.sessionId}/content/${email.uid}`);
                        const data = await response.json();
                        
                        if (data.success) {
                            this.selectedEmail = data.email;
                        } else {
                            console.error('Failed to load email content:', data.message);
                        }
                    } catch (error) {
                        console.error('Error loading email content:', error);
                    }
                },

                filterEmails() {
                    if (!this.searchQuery) {
                        this.filteredEmails = this.emails;
                        return;
                    }
                    
                    const query = this.searchQuery.toLowerCase();
                    this.filteredEmails = this.emails.filter(email => 
                        email.subject.toLowerCase().includes(query) ||
                        email.from.toLowerCase().includes(query) ||
                        email.from_name.toLowerCase().includes(query) ||
                        email.preview.toLowerCase().includes(query)
                    );
                },

                formatDate(dateString) {
                    const date = new Date(dateString);
                    return date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
                },

                formatSize(bytes) {
                    if (bytes < 1024) return bytes + ' B';
                    if (bytes < 1024 * 1024) return Math.round(bytes / 1024) + ' KB';
                    return Math.round(bytes / (1024 * 1024)) + ' MB';
                },

                get totalEmails() {
                    return this.emails.length;
                },

                get readEmails() {
                    return this.emails.filter(email => email.is_read).length;
                },

                get importantEmails() {
                    return this.emails.filter(email => email.is_important).length;
                },

                get emailsWithAttachments() {
                    return this.emails.filter(email => email.has_attachments).length;
                }
            }
        }
    </script>
</body>
</html>
