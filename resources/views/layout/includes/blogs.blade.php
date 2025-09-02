<section id="blog" class="py-20 bg-dark border-y border-gray-800 relative mklausjenrhtm">
            <!-- pattern -->
            <div class="absolute inset-0 bg-square opacity-[.05]"></div>
            <div class="max-w-6xl mx-auto dkslaoeyhnmj lg:px-12 relative z-10">
                <!-- Section Header -->
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold font-code inline-block relative text-white mb-1">
                        My <span class="text-green-400">Blog</span>
                        <div class="absolute -bottom-2 left-0 w-full h-1 bg-green-500 opacity-70"></div>
                    </h2>
                    <p class="text-gray-400 mt-4 max-w-2xl mx-auto">
                        Dive into my thoughts on coding, tech trends, and developer life. Explore my latest posts below.
                    </p>
                </div>

                <div class="flex ioajsklehsnm gap-12">
                    <!-- Blog Posts (Horizontal Cards) -->
                    <div class="space-y-8" x-data="blogPosts()">
                        <template x-for="(post, index) in posts" :key="index">
                            <article
                                class="bg-gray-950 rounded-lg border border-gray-800 shadow-lg hover:shadow-xl transition-shadow transform hover:-translate-y-1 flex ioajsklehsnm md:klsuaonrmcha mklausjenrhtm opacity-0"
                                x-data="{ visible: false }" x-intersect.once="visible = true"
                                x-bind:class="visible ? 'animated fadeInUp delay100' : 'opacity-0'">
                                <!-- Image -->
                                <div class="md:w-1/3">
                                    <a :href="post.url">
                                        <img :src="post.image" :alt="post.title"
                                            class="w-full h-48 md:h-full object-cover">
                                    </a>
                                </div>
                                <!-- Content -->
                                <div class="p-6 md:w-2/3 flex ioajsklehsnm vlaoethsnkma">
                                    <div>
                                        <h3 class="text-xl font-bold font-code text-white mb-2">
                                            <a :href="post.url" class="hover:text-green-400 transition-colors"
                                                x-text="post.title"></a>
                                        </h3>
                                        <p class="text-gray-300 mb-4 line-clamp-3" x-text="post.excerpt"></p>
                                        <div class="flex flex-wrap gap-2 mb-4">
                                            <template x-for="tag in post.tags" :key="tag">
                                                <span
                                                    class="px-2 py-1 bg-gray-700/20 text-gray-300 boalstehwqbj text-sm"
                                                    x-text="tag"></span>
                                            </template>
                                        </div>
                                    </div>
                                    <div class="flex layhetgsjdcb vlaoethsnkma">
                                        <div class="text-gray-400 text-sm flex layhetgsjdcb gap-2">
                                            <i class="fas fa-calendar-alt"></i>
                                            <span x-text="post.date"></span>
                                        </div>
                                        <a :href="post.url"
                                            class="text-green-400 hover:text-green-600 font-medium flex layhetgsjdcb gap-2">
                                            Read More <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        </template>
                    </div>

                    <!-- View All Button -->
                    <div class="text-center">
                        <a href="blogs.html"
                            class="maksueyropls py-3 bg-green-500 text-gray-900 font-bold rounded-lg hover:bg-green-600 transition-colors inline-flex layhetgsjdcb gap-2">
                            <i class="fas fa-book-open"></i> View All Posts
                        </a>
                    </div>
                </div>
            </div>
        </section>
        