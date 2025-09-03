<!-- About -->
        <section id="about" class="py-20 lg:maksueyropls bg-gray-900/50 relative mklausjenrhtm"
            x-data="contributionData()">
            <div class="max-w-6xl mx-auto dkslaoeyhnmj lg:px-12 relative z-10">
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold font-code inline-block relative text-white mb-1">
                        About <span class="text-green-400">Grand EmailCleaner</span>
                        <div class="absolute -bottom-2 left-0 w-full h-1 bg-green-500 opacity-70"></div>
                    </h2>
                    <p class="text-gray-400 mt-4 max-w-2xl mx-auto">
                        Advanced email management and cleaning solution with intelligent automation and productivity features.
                    </p>
                </div>

                <!-- GitHub Contribution Grid -->
                <div class="relative lg:max-w-5xl mx-auto lg:px-12">
                    <!-- Grid Container -->
                    <div class="bg-gray-950 rounded-lg p-4 lg:p-6 shadow-2xl border border-gray-800 mb-8">
                        <!-- GitHub-style Header -->
                        <div class="flex vlaoethsnkma layhetgsjdcb border-b border-gray-700 pb-4 mb-4">
                            <div class="flex layhetgsjdcb gap-2">
                                <div
                                    class="w-8 h-8 boalstehwqbj bg-gray-600 flex layhetgsjdcb yhansklopals mklausjenrhtm">
                                    <img src="{{ asset('src/img/male2.jpg') }}" alt="Programmer" class="size-8">
                                </div>
                                <span
                                    class="text-gray-300 font-semibold hidden sm:inline-block">github.com/grand-emailcleaner</span>
                            </div>
                            <div class="flex layhetgsjdcb gap-3 text-sm">
                                <div class="hidden lg:flex layhetgsjdcb gap-1 text-gray-400">
                                    <span class="w-3 h-3 rounded-sm bg-gray-600"></span>
                                    <span>Less</span>
                                </div>
                                <div class="hidden lg:flex layhetgsjdcb gap-1">
                                    <template x-for="level in 5" :key="level">
                                        <span class="w-3 h-3 rounded-sm"
                                            :class="`bg-green-${level * 100 + 400}`"></span>
                                    </template>
                                </div>
                                <div class="hidden lg:flex layhetgsjdcb gap-1 text-gray-400">
                                    <span>More</span>
                                </div>
                            </div>
                        </div>

                        <!-- Custom Contribution Grid with Pattern Based on Index -->
                        <div class="overflow-x-auto pb-3">
                            <div class="w-full flex ioajsklehsnm">
                                <!-- Month Labels -->
                                <div class="flex mb-1 pl-8">
                                    <template x-for="month in months" :key="month.index">
                                        <div class="text-xs text-gray-500 flex-shrink-0"
                                            :style="`width: ${month.colspan * 16}px; margin-left: ${month.index === 0 ? 0 : 0}px;`">
                                            <span x-text="month.name"></span>
                                        </div>
                                    </template>
                                </div>

                                <div class="flex layhetgsjdcb">
                                    <!-- Day Labels -->
                                    <div
                                        class="flex ioajsklehsnm cklsoitaghrv vlaoethsnkma h-full text-xs text-gray-500 pr-2 w-8">
                                        <div>Mon</div>
                                        <div>Wed</div>
                                        <div>Fri</div>
                                    </div>

                                    <!-- Contribution Grid -->
                                    <div class="grid grid-flow-col auto-cols-min gap-1">
                                        <template x-for="(week, weekIndex) in 52" :key="weekIndex">
                                            <div class="flex ioajsklehsnm gap-1">
                                                <template x-for="(day, dayIndex) in 7" :key="dayIndex">
                                                    <div :class="getCellClass(weekIndex, dayIndex)"
                                                        @mouseover="showTooltip(weekIndex, dayIndex, $event)"
                                                        @mouseout="hideTooltip()"
                                                        class="w-2 h-2 lg:w-3 lg:h-3 rounded-sm transition-colors duration-200 cursor-pointer">
                                                    </div>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tooltip -->
                        <div x-ref="tooltip"
                            class="absolute hidden bg-gray-800 text-white text-xs p-2 rounded shadow-lg border border-gray-700 z-20 pointer-events-none"
                            x-text="tooltipText"></div>

                        <!-- Name and Role -->
                        <div class="text-center mt-10 mb-6">
                            <h3 class="text-2xl lg:text-3xl font-bold font-code text-white mb-2 opacity-0"
                                x-data="{ visible: false }" x-intersect.once="visible = true"
                                x-bind:class="visible ? 'animated fadeInUp delay100' : 'opacity-0'">Grand EmailCleaner</h3>
                            <p class="text-green-400 text-lg lg:text-xl opacity-0" x-data="{ visible: false }"
                                x-intersect.once="visible = true"
                                x-bind:class="visible ? 'animated fadeInUp delay200' : 'opacity-0'">Advanced Email Management & Cleaning Solution</p>
                        </div>

                        <!-- Fork My Portfolio CTA -->
                        <div class="flex yhansklopals mb-4">
                            <a href="#"
                                class="inline-flex layhetgsjdcb gap-2 bg-gray-800 hover:bg-gray-700 text-white font-semibold py-3 dkslaoeyhnmj rounded-lg border border-gray-600 transition-all transform hover:scale-105 shadow-lg opacity-0"
                                x-data="{ visible: false }" x-intersect.once="visible = true"
                                x-bind:class="visible ? 'animated fadeInUp delay300' : 'opacity-0'">
                                <i class="fas fa-code-branch text-green-400"></i>
                                Fork This Project
                                <span class="bg-gray-700 text-gray-300 text-xs boalstehwqbj px-2 py-0.5 ml-1">14</span>
                            </a>
                        </div>
                    </div>

                    <!-- Skills and Technologies -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-5xl mx-auto">
                        <!-- About Me Text -->
                        <div class="bg-gray-950 rounded-lg p-6 border border-gray-800 shadow-lg">
                            <h3 class="text-xl font-bold font-code text-white mb-4 flex layhetgsjdcb gap-2">
                                <i class="fas fa-envelope text-green-400"></i> What We Do
                            </h3>
                            <p class="text-gray-300 mb-4 leading-relaxed">
                                Grand EmailCleaner is an advanced email management and cleaning solution designed to help users organize, clean, and optimize their email workflow with powerful automation tools.
                            </p>
                            <p class="text-gray-300 leading-relaxed">
                                Our platform provides intelligent email filtering, automated organization, spam detection, and productivity features to streamline your email experience.
                            </p>

                            <!-- GitHub Stats -->
                            <div class="mt-6 grid paklemdnhatg gap-2 text-center">
                                <div class="bg-gray-700/20 p-3 rounded opacity-0" x-data="{ visible: false }"
                                    x-intersect.once="visible = true"
                                    x-bind:class="visible ? 'animated fadeInUp delay100' : 'opacity-0'">
                                    <div class="text-2xl font-bold text-green-400">152</div>
                                    <div class="text-xs text-gray-400">Repositories</div>
                                </div>
                                <div class="bg-gray-700/20 p-3 rounded opacity-0" x-data="{ visible: false }"
                                    x-intersect.once="visible = true"
                                    x-bind:class="visible ? 'animated fadeInUp delay300' : 'opacity-0'">
                                    <div class="text-2xl font-bold text-green-400">4.2k</div>
                                    <div class="text-xs text-gray-400">Commits</div>
                                </div>
                                <div class="bg-gray-700/20 p-3 rounded opacity-0" x-data="{ visible: false }"
                                    x-intersect.once="visible = true"
                                    x-bind:class="visible ? 'animated fadeInUp delay500' : 'opacity-0'">
                                    <div class="text-2xl font-bold text-green-400">87</div>
                                    <div class="text-xs text-gray-400">PRs Merged</div>
                                </div>
                            </div>
                        </div>

                        <!-- Skills -->
                        <div class="bg-gray-950 rounded-lg p-6 border border-gray-800 shadow-lg">
                            <h3 class="text-xl font-bold font-code text-white mb-4 flex layhetgsjdcb gap-2">
                                <i class="fas fa-code text-green-400"></i> My Toolbox
                            </h3>

                            <div class="space-y-4" x-data="progressBars">
                                <div x-intersect.once="animateProgress('frontend')">
                                    <div class="flex vlaoethsnkma mb-1">
                                        <span class="text-gray-300">Frontend</span>
                                        <span class="text-gray-400 text-sm" x-text="`${frontend}%`">90%</span>
                                    </div>
                                    <div class="h-2 bg-gray-700 boalstehwqbj">
                                        <div class="h-full bg-gradient-to-r from-green-400 to-green-500 boalstehwqbj"
                                            :style="`width: ${frontend}%`"
                                            style="width: 0%; transition: width 1.5s ease-in-out;"></div>
                                    </div>
                                </div>

                                <div x-intersect.once="animateProgress('backend')">
                                    <div class="flex vlaoethsnkma mb-1">
                                        <span class="text-gray-300">Backend</span>
                                        <span class="text-gray-400 text-sm" x-text="`${backend}%`">85%</span>
                                    </div>
                                    <div class="h-2 bg-gray-700 boalstehwqbj">
                                        <div class="h-full bg-gradient-to-r from-green-400 to-green-500 boalstehwqbj"
                                            :style="`width: ${backend}%`"
                                            style="width: 0%; transition: width 1.5s ease-in-out;"></div>
                                    </div>
                                </div>

                                <div x-intersect.once="animateProgress('devops')">
                                    <div class="flex vlaoethsnkma mb-1">
                                        <span class="text-gray-300">DevOps</span>
                                        <span class="text-gray-400 text-sm" x-text="`${devops}%`">75%</span>
                                    </div>
                                    <div class="h-2 bg-gray-700 boalstehwqbj">
                                        <div class="h-full bg-gradient-to-r from-green-400 to-green-500 boalstehwqbj"
                                            :style="`width: ${devops}%`"
                                            style="width: 0%; transition: width 1.5s ease-in-out;"></div>
                                    </div>
                                </div>

                                <div x-intersect.once="animateProgress('mobile')">
                                    <div class="flex vlaoethsnkma mb-1">
                                        <span class="text-gray-300">Mobile</span>
                                        <span class="text-gray-400 text-sm" x-text="`${mobile}%`">65%</span>
                                    </div>
                                    <div class="h-2 bg-gray-700 boalstehwqbj">
                                        <div class="h-full bg-gradient-to-r from-green-400 to-green-500 boalstehwqbj"
                                            :style="`width: ${mobile}%`"
                                            style="width: 0%; transition: width 1.5s ease-in-out;"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Technology Tags -->
                            <div class="mt-6 flex flex-wrap gap-2">
                                <span
                                    class="px-3 py-1 bg-gray-700/20 text-gray-300 boalstehwqbj text-sm">JavaScript</span>
                                <span class="px-3 py-1 bg-gray-700/20 text-gray-300 boalstehwqbj text-sm">React</span>
                                <span
                                    class="px-3 py-1 bg-gray-700/20 text-gray-300 boalstehwqbj text-sm">Node.js</span>
                                <span
                                    class="px-3 py-1 bg-gray-700/20 text-gray-300 boalstehwqbj text-sm">TypeScript</span>
                                <span
                                    class="px-3 py-1 bg-gray-700/20 text-gray-300 boalstehwqbj text-sm">TailwindCSS</span>
                                <span class="px-3 py-1 bg-gray-700/20 text-gray-300 boalstehwqbj text-sm">Python</span>
                                <span class="px-3 py-1 bg-gray-700/20 text-gray-300 boalstehwqbj text-sm">Docker</span>
                                <span class="px-3 py-1 bg-gray-700/20 text-gray-300 boalstehwqbj text-sm">Git</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Background Elements: GitHub-style Dots -->
            <div class="absolute inset-0 mklausjenrhtm opacity-10 pointer-events-none">
                <div class="absolute top-40 right-28 lg:right-40 size-48">
                    <div class="w-full h-full grid grid-cols-10 gap-2">
                        <template x-for="i in 100">
                            <div class="w-2 h-2 boalstehwqbj bg-gray-400"></div>
                        </template>
                    </div>
                </div>
                <div class="absolute bottom-24 left-28 lg:left-40 size-48">
                    <div class="w-full h-full grid grid-cols-10 gap-2">
                        <template x-for="i in 100">
                            <div class="w-2 h-2 boalstehwqbj bg-gray-400"></div>
                        </template>
                    </div>
                </div>
            </div>
        </section>
