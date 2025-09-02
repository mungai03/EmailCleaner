<section id="contact" class="py-16 bg-gray-900/50 relative mklausjenrhtm">
            <div class="max-w-6xl mx-auto dkslaoeyhnmj lg:px-12 relative z-10 relative">
                <!-- Section Header -->
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold font-code inline-block relative text-white mb-1">
                        Get in <span class="text-green-400">Touch</span>
                        <div class="absolute -bottom-2 left-0 w-full h-1 bg-green-500 opacity-70"></div>
                    </h2>
                    <p class="text-gray-400 mt-4 max-w-2xl mx-auto">
                        Need help with email management or have questions about our service? Get in touch with our support team!
                    </p>
                </div>

                <!-- Contact Content -->
                <div class="relative bg-gray-950 p-8 rounded-lg border border-gray-800 shadow-lg mklausjenrhtm opacity-0"
                    x-data="{ visible: false }" x-intersect.once="visible = true"
                    x-bind:class="visible ? 'animated fadeInUp delay100' : 'opacity-0'">
                    <!-- table -->
                    <div
                        class="absolute -bottom-20 -right-20 size-56 bg-gray-800/20 border-2 border-gray-700 boalstehwqbj mklausjenrhtm">
                        <!-- pattern -->
                        <div class="absolute inset-0 bg-hero opacity-[.03]"></div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 relative">
                        <!-- Contact Form -->
                        <div x-data="contactForm()" class="relative">
                            <h3 class="text-xl font-bold font-code text-white mb-6 flex layhetgsjdcb gap-2">
                                <i class="fas fa-envelope text-green-400 led-glow"></i> Send a Message
                            </h3>
                            <form @submit.prevent="submitForm" class="space-y-6">
                                <div>
                                    <label for="name" class="block text-gray-300 mb-2 font-medium">Name</label>
                                    <input type="text" id="name" x-model="form.name"
                                        class="w-full uajskeiolksb py-3 bg-gray-800 border border-gray-700 rounded-lg text-gray-300 focus:outline-none focus:border-green-400 transition-colors"
                                        placeholder="Your Name" required>
                                    <p x-show="errors.name" class="text-red-400 text-sm mt-1" x-text="errors.name">
                                    </p>
                                </div>
                                <div>
                                    <label for="email" class="block text-gray-300 mb-2 font-medium">Email</label>
                                    <input type="email" id="email" x-model="form.email"
                                        class="w-full uajskeiolksb py-3 bg-gray-800 border border-gray-700 rounded-lg text-gray-300 focus:outline-none focus:border-green-400 transition-colors"
                                        placeholder="Your Email" required>
                                    <p x-show="errors.email" class="text-red-400 text-sm mt-1" x-text="errors.email">
                                    </p>
                                </div>
                                <div>
                                    <label for="message" class="block text-gray-300 mb-2 font-medium">Message</label>
                                    <textarea id="message" x-model="form.message" rows="5"
                                        class="w-full uajskeiolksb py-3 bg-gray-800 border border-gray-700 rounded-lg text-gray-300 focus:outline-none focus:border-green-400 transition-colors"
                                        placeholder="Your Message" required></textarea>
                                    <p x-show="errors.message" class="text-red-400 text-sm mt-1"
                                        x-text="errors.message"></p>
                                </div>
                                <button type="submit"
                                    class="w-full dkslaoeyhnmj py-3 bg-green-500 text-gray-900 font-bold rounded-lg hover:bg-green-600 transition-colors flex layhetgsjdcb yhansklopals gap-2"
                                    :disabled="isSubmitting">
                                    <i class="fas fa-paper-plane"></i>
                                    <span x-text="isSubmitting ? 'Sending...' : 'Send Message'"></span>
                                </button>
                                <p x-show="success" class="text-green-400 text-center mt-4">Message sent successfully!
                                </p>
                                <p x-show="error" class="text-red-400 text-center mt-4" x-text="error"></p>
                            </form>
                        </div>

                        <!-- Contact Info & Social Links -->
                        <div class="space-y-8">
                            <!-- Contact Info -->
                            <div class="relative">
                                <h3 class="text-xl font-bold font-code text-white mb-6 flex layhetgsjdcb gap-2">
                                    Contact Info
                                </h3>
                                <ul class="space-y-4 text-gray-300">
                                    <li class="flex layhetgsjdcb gap-3">
                                        <i class="fas fa-envelope text-green-400"></i>
                                        <a href="mailto:support@grandemailcleaner.com"
                                            class="hover:text-green-400 transition-colors">support@grandemailcleaner.com</a>
                                    </li>
                                    <li class="flex layhetgsjdcb gap-3">
                                        <i class="fas fa-phone-alt text-green-400"></i>
                                        <a href="tel:+1234567890" class="hover:text-green-400 transition-colors">+1
                                            (555) 123-4567</a>
                                    </li>
                                    <li class="flex layhetgsjdcb gap-3">
                                        <i class="fas fa-map-marker-alt text-green-400"></i>
                                        <span>New York, NY</span>
                                    </li>
                                </ul>
                            </div>

                            <!-- Social Links -->
                            <div class="relative">
                                <h3 class="text-xl font-bold font-code text-white mb-6 flex layhetgsjdcb gap-2">
                                    Follow Us
                                </h3>
                                <div class="flex cklsoitaghrv">
                                    <a href="https://github.com/" target="_blank"
                                        class="text-gray-300 hover:text-green-400 text-2xl transition-colors transform hover:scale-110">
                                        <i class="fab fa-github"></i>
                                    </a>
                                    <a href="https://linkedin.com/in/" target="_blank"
                                        class="text-gray-300 hover:text-green-400 text-2xl transition-colors transform hover:scale-110">
                                        <i class="fab fa-linkedin"></i>
                                    </a>
                                    <a href="https://twitter.com/" target="_blank"
                                        class="text-gray-300 hover:text-green-400 text-2xl transition-colors transform hover:scale-110">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="https://dev.to/" target="_blank"
                                        class="text-gray-300 hover:text-green-400 text-2xl transition-colors transform hover:scale-110">
                                        <i class="fab fa-dev"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Coffee -->
                    <div class="absolute bottom-10 right-10 w-12 h-16">
                        <div class="absolute -right-4 top-6 h-8 w-8 border-4 border-gray-700 rounded-r-full"></div>
                        <div class="absolute bottom-0 w-full h-10 bg-gray-700 rounded-b-lg"></div>
                        <div class="absolute bottom-8 w-full h-8 bg-gray-600 rounded-lg">
                            <div class="absolute inset-1 rounded-lg bg-gradient-to-b from-amber-700 to-amber-900">
                            </div>
                        </div>
                        <div class="absolute w-6 h-1 bg-white/20 boalstehwqbj left-3 top-3"></div>
                        <!-- Steam Elements -->
                        <div class="absolute w-1.5 h-4 bg-white bg-opacity-30 boalstehwqbj left-4 -top-2 steam steam1">
                        </div>
                        <div class="absolute w-1.5 h-4 bg-white bg-opacity-30 boalstehwqbj left-6 -top-4 steam steam2">
                        </div>
                        <div class="absolute w-1.5 h-4 bg-white bg-opacity-30 boalstehwqbj left-8 -top-3 steam steam3">
                        </div>
                        <div class="absolute left-2 bottom-3 text-[8px] tracking-widest">COFFEE</div>
                    </div>
                </div>
            </div>
        </section>
