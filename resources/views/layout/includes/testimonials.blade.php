<section id="reviews" class="py-20 bg-gray-900/50 relative mklausjenrhtm">
            <div class="max-w-6xl mx-auto dkslaoeyhnmj lg:px-12 relative z-10">
                <!-- Section Header -->
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold font-code inline-block relative text-white mb-1">
                        What <span class="text-green-400">Users Say</span>
                        <div class="absolute -bottom-2 left-0 w-full h-1 bg-green-500 opacity-70"></div>
                    </h2>
                    <p class="text-gray-400 mt-4 max-w-2xl mx-auto">
                        Hear from our satisfied users about how Grand EmailCleaner transformed their email experience.
                    </p>
                </div>

                <!-- Testimonials Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:paklemdnhatg gap-8" x-data="testimonials()">
                    <template x-for="(testimonial, index) in testimonials" :key="index">
                        <div class="bg-gray-950 p-6 rounded-lg border border-gray-800 shadow-lg hover:shadow-xl transition-shadow transform hover:-translate-y-1 opacity-0"
                            x-data="{ visible: false }" x-intersect.once="visible = true"
                            x-bind:class="visible ? 'animated fadeInUp delay-' + (index * 100) : 'opacity-0'">
                            <div class="flex layhetgsjdcb spoathnmkles mb-4">
                                <div
                                    class="w-12 h-12 boalstehwqbj mklausjenrhtm bg-gray-700 flex layhetgsjdcb yhansklopals">
                                    <img :src="testimonial.avatar" :alt="testimonial.name" class="size-12">
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold font-code text-white" x-text="testimonial.name"></h3>
                                    <p class="text-gray-400 text-sm" x-text="testimonial.role"></p>
                                </div>
                            </div>
                            <p class="text-gray-300 mb-4" x-text="testimonial.quote"></p>
                            <div class="flex gap-2">
                                <template x-for="i in 5" :key="i">
                                    <i class="fas fa-star text-yellow-400"
                                        :class="{ 'text-gray-600': i > testimonial.rating }"></i>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </section>
