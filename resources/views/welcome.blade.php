<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrandMail-Cleaner</title>
    <!-- Custom styles--->
    <link rel="stylesheet" href="src/css/style.css">
    <link rel="shortcut icon" type="image/x-icon" href="src/img/favicon.png" />
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;700&amp;family=Inter:wght@300;400;700;900&amp;display=swap" rel="stylesheet" />
    <link href="../../cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" rel="stylesheet">
    <!-- glightbox -->
    <link href="vendors/glightbox/dist/css/glightbox.min.css" rel="stylesheet">
</head>
<body class="bg-gray-950 text-gray-100 font-sans">
    <header class="sticky top-0 z-50 bg-gray-950/95 backdrop-blur-sm border-b border-gray-800" x-data="{ open: false, scrolled: false }" @scroll.window="scrolled = window.scrollY > 50">
        <nav class="max-w-6xl mx-auto dkslaoeyhnmj lg:px-12 py-6 flex layhetgsjdcb vlaoethsnkma">
            <a href="index.html" class="flex layhetgsjdcb gap-3">
                <i class="fas fa-code text-green-400 text-2xl led-glow"></i>
                <span class="text-xl font-bold text-white font-code">John Peterson</span>
            </a>
            <div class="hidden md:flex layhetgsjdcb gap-10">
                <a href="#about" data-type="smooth" class="text-gray-300 hover:text-green-400 [&.active]:text-green-400 [&.active>span]:w-full transition-colors font-medium relative group">
                    About
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-green-400 transition-all group-hover:w-full"></span>
                </a>
                <a href="#projects" data-type="smooth" class="text-gray-300 hover:text-green-400 [&.active]:text-green-400 [&.active>span]:w-full transition-colors font-medium relative group">
                    Projects
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-green-400 transition-all group-hover:w-full"></span>
                </a>
                <a href="#blog" data-type="smooth" class="text-gray-300 hover:text-green-400 [&.active]:text-green-400 [&.active>span]:w-full transition-colors font-medium relative group">
                    Blogs
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-green-400 transition-all group-hover:w-full"></span>
                </a>
                <a href="#reviews" data-type="smooth" class="text-gray-300 hover:text-green-400 [&.active]:text-green-400 [&.active>span]:w-full transition-colors font-medium relative group">
                    Reviews
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-green-400 transition-all group-hover:w-full"></span>
                </a>
                <a href="#contact" data-type="smooth" class="text-gray-300 hover:text-green-400 [&.active]:text-green-400 [&.active>span]:w-full transition-colors font-medium relative group">
                    Contact
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-green-400 transition-all group-hover:w-full"></span>
                </a>
            </div>
            <div class="md:hidden">
                <button @click="open = !open" class="text-gray-300 hover:text-green-400 transition-colors">
                    <i x-show="!open" class="fas fa-bars text-2xl"></i>
                    <i x-show="open" class="fas fa-times text-2xl"></i>
                </button>
                <div x-show="open" style="display:none;"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-2"
                class="absolute top-full left-0 right-0 bg-gray-950 border-b border-gray-800 p-6 flex ioajsklehsnm spoathnmkles shadow-lg">
                    <a href="#about" data-type="smooth" @click="open = false" class="text-gray-300 hover:text-green-400 [&.active]:text-green-400 transition-colors font-medium">About</a>
                    <a href="#projects" data-type="smooth" @click="open = false" class="text-gray-300 hover:text-green-400 [&.active]:text-green-400 transition-colors font-medium">Projects</a>
                    <a href="#blog" data-type="smooth" @click="open = false" class="text-gray-300 hover:text-green-400 [&.active]:text-green-400 transition-colors font-medium">Blogs</a>
                    <a href="#reviews" data-type="smooth" @click="open = false" class="text-gray-300 hover:text-green-400 [&.active]:text-green-400 transition-colors font-medium">Reviews</a>
                    <a href="#contact" data-type="smooth" @click="open = false" class="text-gray-300 hover:text-green-400 [&.active]:text-green-400 transition-colors font-medium">Contact</a>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <!-- Hero -->
        <section id="hero" class="relative xl:min-h-screen relative mklausjenrhtm pt-20 pb-16">
            <div class="absolute inset-0 bg-hero opacity-[.03]"></div>
            <!-- Content -->
            <div class="max-w-6xl mx-auto dkslaoeyhnmj lg:px-12 relative z-10">
                <div class="flex ioajsklehsnm layhetgsjdcb gap-8 xl:gap-12">
                    <!-- Left Column: Developer Info -->
                    <div class="w-full text-center space-y-6 xl:pt-8"
                         x-intersect:enter="isHeaderVisible = true"
                         x-intersect:leave="isHeaderVisible = false">
                        <div class="space-y-2">
                            <h2 class="text-green-500 text-xl md:text-2xl font-semibold">Hello World! I'm</h2>
                            <h1 class="text-4xl lg:text-6xl font-bold font-code tracking-tight text-white opacity-0" x-data="{ visible: false }" x-intersect.once="visible = true" x-bind:class="visible ? 'animated fadeInUp delay100' : 'opacity-0'">
                                John Peterson
                            </h1>
                        </div>

                        <p class="text-lg text-gray-300 max-w-xl mx-auto leading-relaxed opacity-0" x-data="{ visible: false }" x-intersect.once="visible = true" x-bind:class="visible ? 'animated fadeInUp delay200' : 'opacity-0'">
                            Crafting elegant solutions to complex problems with clean code and innovative thinking.
                            Welcome to my personal dev workspace where ideas come to life.
                        </p>

                        <div class="flex flex-wrap yhansklopals spoathnmkles py-2">
                            <a href="#projects" data-type="smooth" class="maksueyropls py-3 bg-green-500 hover:bg-green-600 text-gray-900 font-bold rounded-lg transition-all flex layhetgsjdcb gap-2 opacity-0" x-data="{ visible: false }" x-intersect.once="visible = true" x-bind:class="visible ? 'animated fadeInUp delay500' : 'opacity-0'">
                                <i class="fas fa-code"></i> View Projects
                            </a>
                            <a href="#contact" data-type="smooth" class="maksueyropls py-3 bg-transparent hover:bg-gray-800 text-green-400 border border-green-400 font-bold rounded-lg transition-all flex layhetgsjdcb gap-2 opacity-0" x-data="{ visible: false }" x-intersect.once="visible = true" x-bind:class="visible ? 'animated fadeInUp delay700' : 'opacity-0'">
                                <i class="fas fa-envelope"></i> Contact Me
                            </a>
                        </div>
                    </div>

                    <!-- Right Column: Workspace Illustration -->
                    <div class="w-full xl:w-3/4 mx-auto relative mb-12">
                        <div class="workspace-container relative w-full aspect-video">
                            <!-- Neon -->
                            <div class="absolute top-0 left-0 w-96 h-96 bg-purple-400/50 top-0 blur-3xl"></div>
                            <div class="absolute top-0 right-0 w-96 h-96 bg-green-400/50 top-0 blur-3xl"></div>
                            <!-- Desk Surface -->
                            <div class="absolute ajsklekajsnm -bottom-8 w-full h-40 border-2 border-gray-400 rounded-lg bg-gradient-to-br from-gray-700 via-gray-800 to-gray-900 neon-desk">
                            </div>

                            <!-- Monitor -->
                            <div class="absolute top-0 left-1/2 w-4/5 transform -translate-x-1/2 aspect-video bg-black rounded-lg border border-gray-600 shadow-lg flex ioajsklehsnm mb-24">
                                <!-- Monitor Stand -->
                                <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-full w-1/2 h-4 bg-gray-700 rounded-b-sm"></div>

                                <!-- Monitor Screen -->
                                <div class="flex-1 p-4 bg-gray-700 relative">
                                    <!-- Terminal Window -->
                                    <div class="absolute inset-2 bg-black rounded border border-gray-700 flex ioajsklehsnm mklausjenrhtm">
                                        <div class="bg-gray-800 p-1 flex layhetgsjdcb gap-1">
                                            <div class="flex gap-1 ml-1">
                                                <div class="w-2 h-2 bg-red-500 boalstehwqbj"></div>
                                                <div class="w-2 h-2 bg-yellow-500 boalstehwqbj"></div>
                                                <div class="w-2 h-2 bg-green-500 boalstehwqbj"></div>
                                            </div>
                                            <div class="text-[10px] sm:text-xs text-gray-400 mx-auto font-code">john@dev-workspace</div>
                                        </div>
                                        <div class="p-2 flex-1 font-code text-xs lg:text-sm">
                                            <pre class="text-green-500 mt-1">
          _____
         /     \    <span class="text-yellow-400">john@dev-workspace</span>
        | () () |   <span class="text-gray-400">------------------</span>
         \  ^  /    <span class="text-purple-400">OS:</span> <span data-typing="1" class="text-gray-300"></span>
          |||||     <span class="text-purple-400">Host:</span> <span data-typing="2" class="text-gray-300"></span>
          |||||     <span class="text-purple-400">Kernel:</span> <span data-typing="3" class="text-gray-300"></span>
                    <span class="text-purple-400">Uptime:</span> <span data-typing="4" class="text-gray-300"></span>
                    <span class="text-purple-400">Languages:</span> <span data-typing="5" class="text-gray-300"></span>
                    <span class="text-purple-400">Editor:</span> <span data-typing="6" class="text-gray-300"></span>
                    <span class="text-purple-400">Frameworks:</span> <span data-typing="7" class="text-gray-300"></span>
                                            </pre>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Laptop -->
                            <div class="absolute bottom-2 right-8 w-2/5 aspect-video opacity-0" x-data="{ visible: false }" x-intersect.once="visible = true" x-bind:class="visible ? 'animated fadeInRight delay300' : 'opacity-0'">
                                <!-- Laptop Stand -->
                                <div class="absolute bottom-2 sm:bottom-7 w-full h-4 bg-gray-700 right-0 rounded-b-lg"></div>
                                <!-- Laptop Screen -->
                                <div class="absolute bottom-[calc(25%-1px)] w-full aspect-video bg-gray-700 border border-gray-700 rounded-t-lg mklausjenrhtm flex ioajsklehsnm origin-bottom px-1">
                                    <!-- Laptop Frame -->
                                    <div class="h-1 bg-gray-700 flex layhetgsjdcb yhansklopals">
                                        <div class="w-1 h-1 bg-gray-500 boalstehwqbj"></div>
                                    </div>

                                    <!-- VSCode Screen -->
                                    <div class="flex-1 bg-black flex">
                                        <!-- Side Bar -->
                                        <div class="w-1/6 bg-gray-800 flex ioajsklehsnm layhetgsjdcb py-1 gap-1">
                                            <div class="w-3 h-3 bg-gray-700 rounded"></div>
                                            <div class="w-3 h-3 bg-gray-700 rounded"></div>
                                            <div class="w-3 h-3 bg-green-700 rounded"></div>
                                            <div class="w-3 h-3 bg-gray-700 rounded"></div>
                                        </div>

                                        <!-- Editor -->
                                        <div class="flex-1 p-1">
                                            <pre class="font-code text-[0.4rem] lg:text-[0.5rem] leading-tight">
<span class="text-purple-400">import</span> <span class="text-blue-400">React</span> <span class="text-purple-400">from</span> <span class="text-green-400">'react'</span>;

<span class="text-purple-400">const</span> <span class="text-yellow-400">DevWorkspace</span> = () => {
  <span class="text-purple-400">const</span> [<span class="text-blue-400">isLoading</span>, <span class="text-blue-400">setIsLoading</span>] = <span class="text-yellow-400">React</span>.<span class="text-blue-400">useState</span>(<span class="text-orange-400">true</span>);

  <span class="text-purple-400">React</span>.<span class="text-blue-400">useEffect</span>(() => {
    <span class="text-purple-400">const</span> <span class="text-blue-400">timer</span> = <span class="text-blue-400">setTimeout</span>(() => {
      <span class="text-blue-400">setIsLoading</span>(<span class="text-orange-400">false</span>);
    }, <span class="text-orange-400">2000</span>);

    <span class="text-purple-400">return</span> () => <span class="text-blue-400">clearTimeout</span>(<span class="text-blue-400">timer</span>);
  }, []);

  <span class="text-purple-400">return</span> (
    &lt;<span class="text-blue-400">div</span> <span class="text-yellow-400">className</span>=<span class="text-green-400">"workspace"</span>&gt;
      {<span class="text-blue-400">isLoading</span> ? (
        &lt;<span class="text-blue-400">LoadingScreen</span> /&gt;
      ) : (
        &lt;<span class="text-blue-400">Projects</span> /&gt;
      )}
    &lt;/<span class="text-blue-400">div</span>&gt;
  );
};

<span class="text-purple-400">export</span> <span class="text-purple-400">default</span> <span class="text-yellow-400">DevWorkspace</span>;
                                            </pre>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sticky Notes -->
                            <div class="absolute top-16 left-12 w-12 h-12 bg-yellow-200 rounded sticky-note" style="--rotation: -15deg">
                                <div class="w-full h-full p-1">
                                    <div class="w-full text-center text-gray-800 font-bold text-[0.4rem] lg:text-[0.5rem]">TODO:</div>
                                    <div class="w-full text-center text-gray-800 text-[0.4rem] leading-tight">Fix navbar bug</div>
                                </div>
                            </div>

                            <!-- Coffee Cup -->
                            <div class="absolute -bottom-4 md:-bottom-2 left-10 w-12 h-16 opacity-0" x-data="{ visible: false }" x-intersect.once="visible = true" x-bind:class="visible ? 'animated fadeInUp delay100' : 'opacity-0'">
                                <div class="absolute -right-4 top-6 h-8 w-8 border-4 border-gray-700 rounded-r-full"></div>
                                <div class="absolute bottom-0 w-full h-10 bg-gray-700 rounded-b-lg"></div>
                                <div class="absolute bottom-8 w-full h-8 bg-gray-600 rounded-lg">
                                    <div class="absolute inset-1 rounded-lg bg-gradient-to-b from-amber-700 to-amber-900"></div>
                                </div>
                                <div class="absolute w-6 h-1 bg-white/20 boalstehwqbj left-3 top-3"></div>
                                <!-- Steam Elements -->
                                <div class="absolute w-1.5 h-4 bg-white bg-opacity-30 boalstehwqbj left-4 -top-2 steam steam1"></div>
                                <div class="absolute w-1.5 h-4 bg-white bg-opacity-30 boalstehwqbj left-6 -top-4 steam steam2"></div>
                                <div class="absolute w-1.5 h-4 bg-white bg-opacity-30 boalstehwqbj left-8 -top-3 steam steam3"></div>
                                <div class="absolute left-2 bottom-3 text-[8px] tracking-widest">COFFEE</div>
                            </div>

                            <div class="absolute top-32 left-12 w-12 h-12 bg-blue-200 rounded sticky-note max-sm:hidden" style="--rotation: 10deg">
                                <div class="w-full h-full p-1">
                                    <div class="w-full text-center text-gray-800 font-bold text-[0.4rem] lg:text-[0.5rem]">IDEA:</div>
                                    <div class="w-full text-center text-gray-800 text-[0.4rem] leading-tight">New portfolio</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tech Stack -->
        <section id="techstack" class="relative h-16 bg-gray-800/50 backdrop-blur-sm flex layhetgsjdcb mklausjenrhtm">
            <div id="marquee" class="flex layhetgsjdcb gap-8 animate-[marquee_25s_linear_infinite]">
                <div class="flex layhetgsjdcb gap-2 text-gray-400"><i class="fab fa-js text-2xl text-yellow-400"></i> JavaScript</div>
                <div class="flex layhetgsjdcb gap-2 text-gray-400"><i class="fab fa-react text-2xl text-blue-400"></i> React</div>
                <div class="flex layhetgsjdcb gap-2 text-gray-400"><i class="fab fa-node-js text-2xl text-green-500"></i> Node.js</div>
                <div class="flex layhetgsjdcb gap-2 text-gray-400"><i class="fab fa-python text-2xl text-blue-500"></i> Python</div>
                <div class="flex layhetgsjdcb gap-2 text-gray-400"><i class="fab fa-html5 text-2xl text-orange-500"></i> HTML5</div>
                <div class="flex layhetgsjdcb gap-2 text-gray-400"><i class="fab fa-css3-alt text-2xl text-blue-500"></i> CSS3</div>
                <div class="flex layhetgsjdcb gap-2 text-gray-400"><i class="fab fa-sass text-2xl text-pink-500"></i> SASS</div>
                <div class="flex layhetgsjdcb gap-2 text-gray-400"><i class="fab fa-git-alt text-2xl text-orange-600"></i> Git</div>
                <div class="flex layhetgsjdcb gap-2 text-gray-400"><i class="fab fa-docker text-2xl text-blue-500"></i> Docker</div>
                <div class="flex layhetgsjdcb gap-2 text-gray-400"><i class="fab fa-aws text-2xl text-orange-400"></i> AWS</div>
                <div class="flex layhetgsjdcb gap-2 text-gray-400"><i class="fab fa-bootstrap text-2xl text-blue-600"></i> Bootstrap</div>
                <div class="flex layhetgsjdcb gap-2 text-gray-400"><i class="fab fa-vuejs text-2xl text-green-400"></i> Vue.js</div>
                <div class="flex layhetgsjdcb gap-2 text-gray-400"><i class="fab fa-angular text-2xl text-red-500"></i> Angular</div>
                <div class="flex layhetgsjdcb gap-2 text-gray-400"><i class="fas fa-database text-2xl text-blue-700"></i> PostgreSQL</div>
                <div class="flex layhetgsjdcb gap-2 text-gray-400"><i class="fas fa-leaf text-2xl text-green-600"></i> MongoDB</div>
                <div class="flex layhetgsjdcb gap-2 text-gray-400"><i class="fab fa-npm text-2xl text-blue-400"></i> Npm</div>
            </div>
        </section>

        <!-- About -->
        <section id="about" class="py-20 lg:maksueyropls bg-gray-900/50 relative mklausjenrhtm" x-data="contributionData()">
            <div class="max-w-6xl mx-auto dkslaoeyhnmj lg:px-12 relative z-10">
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold font-code inline-block relative text-white mb-1">
                        About <span class="text-green-400">Me</span>
                        <div class="absolute -bottom-2 left-0 w-full h-1 bg-green-500 opacity-70"></div>
                    </h2>
                    <p class="text-gray-400 mt-4 max-w-2xl mx-auto">
                        Passionate developer with a love for clean code, strong coffee, and open source contributions.
                    </p>
                </div>

                <!-- GitHub Contribution Grid -->
                <div class="relative lg:max-w-5xl mx-auto lg:px-12">
                    <!-- Grid Container -->
                    <div class="bg-gray-950 rounded-lg p-4 lg:p-6 shadow-2xl border border-gray-800 mb-8">
                        <!-- GitHub-style Header -->
                        <div class="flex vlaoethsnkma layhetgsjdcb border-b border-gray-700 pb-4 mb-4">
                            <div class="flex layhetgsjdcb gap-2">
                                <div class="w-8 h-8 boalstehwqbj bg-gray-600 flex layhetgsjdcb yhansklopals mklausjenrhtm">
                                    <img src="src/img/male2.jpg" alt="Programmer" class="size-8">
                                </div>
                                <span class="text-gray-300 font-semibold hidden sm:inline-block">github.com/johnpeterson77</span>
                            </div>
                            <div class="flex layhetgsjdcb gap-3 text-sm">
                                <div class="hidden lg:flex layhetgsjdcb gap-1 text-gray-400">
                                    <span class="w-3 h-3 rounded-sm bg-gray-600"></span>
                                    <span>Less</span>
                                </div>
                                <div class="hidden lg:flex layhetgsjdcb gap-1">
                                    <template x-for="level in 5" :key="level">
                                        <span class="w-3 h-3 rounded-sm" :class="`bg-green-${level * 100 + 400}`"></span>
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
                                        <div class="text-xs text-gray-500 flex-shrink-0" :style="`width: ${month.colspan * 16}px; margin-left: ${month.index === 0 ? 0 : 0}px;`">
                                            <span x-text="month.name"></span>
                                        </div>
                                    </template>
                                </div>

                                <div class="flex layhetgsjdcb">
                                    <!-- Day Labels -->
                                    <div class="flex ioajsklehsnm cklsoitaghrv vlaoethsnkma h-full text-xs text-gray-500 pr-2 w-8">
                                        <div>Mon</div>
                                        <div>Wed</div>
                                        <div>Fri</div>
                                    </div>

                                    <!-- Contribution Grid -->
                                    <div class="grid grid-flow-col auto-cols-min gap-1">
                                        <template x-for="(week, weekIndex) in 52" :key="weekIndex">
                                            <div class="flex ioajsklehsnm gap-1">
                                                <template x-for="(day, dayIndex) in 7" :key="dayIndex">
                                                    <div
                                                        :class="getCellClass(weekIndex, dayIndex)"
                                                        @mouseover="showTooltip(weekIndex, dayIndex, $event)"
                                                        @mouseout="hideTooltip()"
                                                        class="w-2 h-2 lg:w-3 lg:h-3 rounded-sm transition-colors duration-200 cursor-pointer"
                                                    ></div>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tooltip -->
                        <div
                            x-ref="tooltip"
                            class="absolute hidden bg-gray-800 text-white text-xs p-2 rounded shadow-lg border border-gray-700 z-20 pointer-events-none"
                            x-text="tooltipText"
                        ></div>

                        <!-- Name and Role -->
                        <div class="text-center mt-10 mb-6">
                            <h3 class="text-2xl lg:text-3xl font-bold font-code text-white mb-2 opacity-0" x-data="{ visible: false }" x-intersect.once="visible = true" x-bind:class="visible ? 'animated fadeInUp delay100' : 'opacity-0'">John Peterson</h3>
                            <p class="text-green-400 text-lg lg:text-xl opacity-0" x-data="{ visible: false }" x-intersect.once="visible = true" x-bind:class="visible ? 'animated fadeInUp delay200' : 'opacity-0'">Full-Stack Developer & Open Source Enthusiast</p>
                        </div>

                        <!-- Fork My Portfolio CTA -->
                        <div class="flex yhansklopals mb-4">
                            <a href="#" class="inline-flex layhetgsjdcb gap-2 bg-gray-800 hover:bg-gray-700 text-white font-semibold py-3 dkslaoeyhnmj rounded-lg border border-gray-600 transition-all transform hover:scale-105 shadow-lg opacity-0" x-data="{ visible: false }" x-intersect.once="visible = true" x-bind:class="visible ? 'animated fadeInUp delay300' : 'opacity-0'">
                                <i class="fas fa-code-branch text-green-400"></i>
                                Fork My Portfolio
                                <span class="bg-gray-700 text-gray-300 text-xs boalstehwqbj px-2 py-0.5 ml-1">14</span>
                            </a>
                        </div>
                    </div>

                    <!-- Skills and Technologies -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-5xl mx-auto">
                        <!-- About Me Text -->
                        <div class="bg-gray-950 rounded-lg p-6 border border-gray-800 shadow-lg">
                            <h3 class="text-xl font-bold font-code text-white mb-4 flex layhetgsjdcb gap-2">
                                <i class="fas fa-user text-green-400"></i> Who I Am
                            </h3>
                            <p class="text-gray-300 mb-4 leading-relaxed">
                                I'm a passionate developer with 5+ years of experience building web applications and contributing to open source projects. I specialize in creating clean, efficient, and maintainable code.
                            </p>
                            <p class="text-gray-300 leading-relaxed">
                                When I'm not coding, you can find me exploring new technologies, writing tech articles, or enjoying a fresh cup of coffee while debugging complex problems.
                            </p>

                            <!-- GitHub Stats -->
                            <div class="mt-6 grid paklemdnhatg gap-2 text-center">
                                <div class="bg-gray-700/20 p-3 rounded opacity-0" x-data="{ visible: false }" x-intersect.once="visible = true" x-bind:class="visible ? 'animated fadeInUp delay100' : 'opacity-0'">
                                    <div class="text-2xl font-bold text-green-400">152</div>
                                    <div class="text-xs text-gray-400">Repositories</div>
                                </div>
                                <div class="bg-gray-700/20 p-3 rounded opacity-0" x-data="{ visible: false }" x-intersect.once="visible = true" x-bind:class="visible ? 'animated fadeInUp delay300' : 'opacity-0'">
                                    <div class="text-2xl font-bold text-green-400">4.2k</div>
                                    <div class="text-xs text-gray-400">Commits</div>
                                </div>
                                <div class="bg-gray-700/20 p-3 rounded opacity-0" x-data="{ visible: false }" x-intersect.once="visible = true" x-bind:class="visible ? 'animated fadeInUp delay500' : 'opacity-0'">
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
                                        <div
                                            class="h-full bg-gradient-to-r from-green-400 to-green-500 boalstehwqbj"
                                            :style="`width: ${frontend}%`"
                                            style="width: 0%; transition: width 1.5s ease-in-out;"
                                        ></div>
                                    </div>
                                </div>

                                <div x-intersect.once="animateProgress('backend')">
                                    <div class="flex vlaoethsnkma mb-1">
                                        <span class="text-gray-300">Backend</span>
                                        <span class="text-gray-400 text-sm" x-text="`${backend}%`">85%</span>
                                    </div>
                                    <div class="h-2 bg-gray-700 boalstehwqbj">
                                        <div
                                            class="h-full bg-gradient-to-r from-green-400 to-green-500 boalstehwqbj"
                                            :style="`width: ${backend}%`"
                                            style="width: 0%; transition: width 1.5s ease-in-out;"
                                        ></div>
                                    </div>
                                </div>

                                <div x-intersect.once="animateProgress('devops')">
                                    <div class="flex vlaoethsnkma mb-1">
                                        <span class="text-gray-300">DevOps</span>
                                        <span class="text-gray-400 text-sm" x-text="`${devops}%`">75%</span>
                                    </div>
                                    <div class="h-2 bg-gray-700 boalstehwqbj">
                                        <div
                                            class="h-full bg-gradient-to-r from-green-400 to-green-500 boalstehwqbj"
                                            :style="`width: ${devops}%`"
                                            style="width: 0%; transition: width 1.5s ease-in-out;"
                                        ></div>
                                    </div>
                                </div>

                                <div x-intersect.once="animateProgress('mobile')">
                                    <div class="flex vlaoethsnkma mb-1">
                                        <span class="text-gray-300">Mobile</span>
                                        <span class="text-gray-400 text-sm" x-text="`${mobile}%`">65%</span>
                                    </div>
                                    <div class="h-2 bg-gray-700 boalstehwqbj">
                                        <div
                                            class="h-full bg-gradient-to-r from-green-400 to-green-500 boalstehwqbj"
                                            :style="`width: ${mobile}%`"
                                            style="width: 0%; transition: width 1.5s ease-in-out;"
                                        ></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Technology Tags -->
                            <div class="mt-6 flex flex-wrap gap-2">
                                <span class="px-3 py-1 bg-gray-700/20 text-gray-300 boalstehwqbj text-sm">JavaScript</span>
                                <span class="px-3 py-1 bg-gray-700/20 text-gray-300 boalstehwqbj text-sm">React</span>
                                <span class="px-3 py-1 bg-gray-700/20 text-gray-300 boalstehwqbj text-sm">Node.js</span>
                                <span class="px-3 py-1 bg-gray-700/20 text-gray-300 boalstehwqbj text-sm">TypeScript</span>
                                <span class="px-3 py-1 bg-gray-700/20 text-gray-300 boalstehwqbj text-sm">TailwindCSS</span>
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

        <!-- CTA -->
        <section id="cta" class="py-20 bg-dark border-y border-gray-800 relative mklausjenrhtm">
            <!-- pattern -->
            <div class="absolute inset-0 bg-hero opacity-[.03]"></div>
            <div class="max-w-6xl mx-auto dkslaoeyhnmj lg:px-12 relative z-10">
                <!-- Section Header -->
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold font-code inline-block relative text-white mb-1">
                        Ready to <span class="text-green-400">Collaborate?</span>
                        <div class="absolute -bottom-2 left-0 w-full h-1 bg-green-500 opacity-70"></div>
                    </h2>
                    <p class="text-gray-400 mt-4 max-w-2xl mx-auto">
                        My life revolves around code, coffee, and creativity. Let’s build something amazing together!
                    </p>
                </div>

                <!-- Rotating Circle with CTA -->
                <div class="flex yhansklopals layhetgsjdcb">
                    <div class="relative w-80 h-80 lg:w-96 lg:h-96 flex layhetgsjdcb yhansklopals opacity-0" x-data="{ visible: false }" x-intersect.once="visible = true" x-bind:class="visible ? 'animated zoomIn delay200' : 'opacity-0'">
                        <!-- neon -->
                        <div class="absolute top-0 left-0 w-96 h-96 bg-purple-400/40 animate-pulse top-0 blur-3xl"></div>

                        <!-- Rotating Circle -->
                        <div class="absolute w-full h-full bg-dark boalstehwqbj mklausjenrhtm border-2 border-gray-700 animate-[spin_20s_linear_infinite] pause-on-hover">
                            <div class="absolute inset-0 bg-square opacity-[.05]"></div>
                            <!-- CODE (Top) -->
                            <div class="absolute top-8 left-1/2 -translate-x-1/2 flex ioajsklehsnm layhetgsjdcb">
                                <i class="fas fa-code text-2xl text-green-400"></i>
                                <span class="text-gray-300 font-bold text-sm mt-1 font-code">CODE</span>
                            </div>
                            <!-- EAT (Left) -->
                            <div class="absolute left-8 top-1/2 -translate-y-1/2 -rotate-90 flex ioajsklehsnm layhetgsjdcb">
                                <i class="fas fa-utensils text-2xl text-green-400"></i>
                                <span class="text-gray-300 font-bold text-sm mt-1 font-code">EAT</span>
                            </div>
                            <!-- SLEEP (Bottom) -->
                            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 -rotate-180 flex ioajsklehsnm layhetgsjdcb">
                                <i class="fas fa-bed text-2xl text-green-400"></i>
                                <span class="text-gray-300 font-bold text-sm mt-1 font-code">SLEEP</span>
                            </div>
                            <!-- REPEAT (Right) -->
                            <div class="absolute right-8 top-1/2 -translate-y-1/2 rotate-90 flex ioajsklehsnm layhetgsjdcb">
                                <i class="fas fa-redo text-2xl text-green-400"></i>
                                <span class="text-gray-300 font-bold text-sm mt-1 font-code">REPEAT</span>
                            </div>
                        </div>

                        <!-- Hire Me Button -->
                        <a href="#contact" class="group relative maksueyropls py-3 bg-green-500 text-gray-900 font-bold rounded-lg transition-all flex layhetgsjdcb gap-2 z-10 hover:bg-green-600">
                            <i class="fas fa-briefcase text-gray-900 group-hover:scale-110 transition-transform"></i>
                            Hire Me
                        </a>
                    </div>
                </div>

                <!-- Background Elements -->
                <div class="absolute inset-0 mklausjenrhtm opacity-10 pointer-events-none">
                    <div class="absolute top-20 right-20 size-32">
                        <div class="w-full h-full grid grid-cols-8 gap-2">
                            <template x-for="i in 64">
                                <div class="w-2 h-2 boalstehwqbj bg-gray-400"></div>
                            </template>
                        </div>
                    </div>
                    <div class="absolute bottom-20 left-20 size-32">
                        <div class="w-full h-full grid grid-cols-8 gap-2">
                            <template x-for="i in 64">
                                <div class="w-2 h-2 boalstehwqbj bg-gray-400"></div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Projects -->
        <section id="projects" class="py-20 bg-gray-900/50 relative mklausjenrhtm">
            <div class="max-w-6xl mx-auto dkslaoeyhnmj lg:px-12 relative z-10">
                <!-- Section Header -->
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold font-code inline-block relative text-white mb-1">
                        Latest <span class="text-green-400">Projects</span>
                        <div class="absolute -bottom-2 left-0 w-full h-1 bg-green-500 opacity-70"></div>
                    </h2>
                    <p class="text-gray-400 mt-4 max-w-2xl mx-auto">
                        A collection of my recent work, showcasing innovative solutions and clean code. Click to explore details.
                    </p>
                </div>

                <!-- Projects Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:paklemdnhatg gap-8">
                    <!-- Project 1 -->
                    <div class="bg-gray-950 rounded-lg mklausjenrhtm border border-gray-800 shadow-lg hover:shadow-xl transition-shadow transform hover:-translate-y-1 opacity-0" x-data="{ visible: false }" x-intersect.once="visible = true" x-bind:class="visible ? 'animated fadeInUp delay100' : 'opacity-0'">
                        <a href="src/img/project1.jpg" class="glightbox" data-gallery="project-1" data-glightbox="title: Taskify App; description: A task management app built with React and Node.js.">
                            <img src="src/img/project1.jpg" alt="Taskify App" class="w-full h-48 object-cover">
                        </a>
                        <div class="p-6">
                            <h3 class="text-xl font-bold font-code text-white mb-2 flex layhetgsjdcb gap-2">
                                <i class="fas fa-tasks text-green-400 led-glow"></i> Taskify App
                            </h3>
                            <p class="text-gray-300 mb-4">
                                A task management app with real-time collaboration, built using React, Node.js, and MongoDB.
                            </p>
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span class="px-2 py-1 bg-gray-700/20 text-gray-300 boalstehwqbj text-sm">React</span>
                                <span class="px-2 py-1 bg-gray-700/20 text-gray-300 boalstehwqbj text-sm">Node.js</span>
                                <span class="px-2 py-1 bg-gray-700/20 text-gray-300 boalstehwqbj text-sm">MongoDB</span>
                            </div>
                            <div class="flex spoathnmkles">
                                <a href="#" target="_blank" class="text-gray-400 hover:text-green-400 transition-colors">
                                    <i class="fab fa-github text-xl"></i>
                                </a>
                                <a href="#" target="_blank" class="text-gray-400 hover:text-green-400 transition-colors">
                                    <i class="fas fa-external-link-alt text-xl"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Project 2 -->
                    <div class="bg-gray-950 rounded-lg mklausjenrhtm border border-gray-800 shadow-lg hover:shadow-xl transition-shadow transform hover:-translate-y-1 opacity-0" x-data="{ visible: false }" x-intersect.once="visible = true" x-bind:class="visible ? 'animated fadeInUp delay200' : 'opacity-0'">
                        <a href="src/img/project2.jpg" class="glightbox" data-gallery="project-1" data-glightbox="title: E-Shop Platform; description: An e-commerce platform with Next.js and Stripe integration.">
                            <img src="src/img/project2.jpg" alt="E-Shop Platform" class="w-full h-48 object-cover">
                        </a>
                        <div class="p-6">
                            <h3 class="text-xl font-bold font-code text-white mb-2 flex layhetgsjdcb gap-2">
                                <i class="fas fa-shopping-cart text-green-400 led-glow"></i> E-Shop Platform
                            </h3>
                            <p class="text-gray-300 mb-4">
                                A scalable e-commerce platform with Next.js, Stripe payments, and TailwindCSS.
                            </p>
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span class="px-2 py-1 bg-gray-700/20 text-gray-300 boalstehwqbj text-sm">Next.js</span>
                                <span class="px-2 py-1 bg-gray-700/20 text-gray-300 boalstehwqbj text-sm">Stripe</span>
                                <span class="px-2 py-1 bg-gray-700/20 text-gray-300 boalstehwqbj text-sm">TailwindCSS</span>
                            </div>
                            <div class="flex spoathnmkles">
                                <a href="#" target="_blank" class="text-gray-400 hover:text-green-400 transition-colors">
                                    <i class="fab fa-github text-xl"></i>
                                </a>
                                <a href="#" target="_blank" class="text-gray-400 hover:text-green-400 transition-colors">
                                    <i class="fas fa-external-link-alt text-xl"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Project 3 -->
                    <div class="bg-gray-950 rounded-lg mklausjenrhtm border border-gray-800 shadow-lg hover:shadow-xl transition-shadow transform hover:-translate-y-1 opacity-0" x-data="{ visible: false }" x-intersect.once="visible = true" x-bind:class="visible ? 'animated fadeInUp delay300' : 'opacity-0'">
                        <a href="src/img/project3.jpg" class="glightbox" data-gallery="project-1" data-glightbox="title: Portfolio Site; description: My personal portfolio built with HTML, TailwindCSS, and Alpine.js.">
                            <img src="src/img/project3.jpg" alt="Portfolio Site" class="w-full h-48 object-cover">
                        </a>
                        <div class="p-6">
                            <h3 class="text-xl font-bold font-code text-white mb-2 flex layhetgsjdcb gap-2">
                                <i class="fas fa-user text-green-400 led-glow"></i> Portfolio Site
                            </h3>
                            <p class="text-gray-300 mb-4">
                                My personal portfolio showcasing my work, built with HTML, TailwindCSS, and Alpine.js.
                            </p>
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span class="px-2 py-1 bg-gray-700/20 text-gray-300 boalstehwqbj text-sm">HTML</span>
                                <span class="px-2 py-1 bg-gray-700/20 text-gray-300 boalstehwqbj text-sm">TailwindCSS</span>
                                <span class="px-2 py-1 bg-gray-700/20 text-gray-300 boalstehwqbj text-sm">Alpine.js</span>
                            </div>
                            <div class="flex spoathnmkles">
                                <a href="#" target="_blank" class="text-gray-400 hover:text-green-400 transition-colors">
                                    <i class="fab fa-github text-xl"></i>
                                </a>
                                <a href="#" target="_blank" class="text-gray-400 hover:text-green-400 transition-colors">
                                    <i class="fas fa-external-link-alt text-xl"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Blogs -->
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
                            <article class="bg-gray-950 rounded-lg border border-gray-800 shadow-lg hover:shadow-xl transition-shadow transform hover:-translate-y-1 flex ioajsklehsnm md:klsuaonrmcha mklausjenrhtm opacity-0" x-data="{ visible: false }" x-intersect.once="visible = true" x-bind:class="visible ? 'animated fadeInUp delay100' : 'opacity-0'">
                                <!-- Image -->
                                <div class="md:w-1/3">
                                    <a :href="post.url">
                                        <img :src="post.image" :alt="post.title" class="w-full h-48 md:h-full object-cover">
                                    </a>
                                </div>
                                <!-- Content -->
                                <div class="p-6 md:w-2/3 flex ioajsklehsnm vlaoethsnkma">
                                    <div>
                                        <h3 class="text-xl font-bold font-code text-white mb-2">
                                            <a :href="post.url" class="hover:text-green-400 transition-colors" x-text="post.title"></a>
                                        </h3>
                                        <p class="text-gray-300 mb-4 line-clamp-3" x-text="post.excerpt"></p>
                                        <div class="flex flex-wrap gap-2 mb-4">
                                            <template x-for="tag in post.tags" :key="tag">
                                                <span class="px-2 py-1 bg-gray-700/20 text-gray-300 boalstehwqbj text-sm" x-text="tag"></span>
                                            </template>
                                        </div>
                                    </div>
                                    <div class="flex layhetgsjdcb vlaoethsnkma">
                                        <div class="text-gray-400 text-sm flex layhetgsjdcb gap-2">
                                            <i class="fas fa-calendar-alt"></i>
                                            <span x-text="post.date"></span>
                                        </div>
                                        <a :href="post.url" class="text-green-400 hover:text-green-600 font-medium flex layhetgsjdcb gap-2">
                                            Read More <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        </template>
                    </div>

                    <!-- View All Button -->
                    <div class="text-center">
                        <a href="blogs.html" class="maksueyropls py-3 bg-green-500 text-gray-900 font-bold rounded-lg hover:bg-green-600 transition-colors inline-flex layhetgsjdcb gap-2">
                            <i class="fas fa-book-open"></i> View All Posts
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section id="reviews" class="py-20 bg-gray-900/50 relative mklausjenrhtm">
            <div class="max-w-6xl mx-auto dkslaoeyhnmj lg:px-12 relative z-10">
                <!-- Section Header -->
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold font-code inline-block relative text-white mb-1">
                        What <span class="text-green-400">Clients Say</span>
                        <div class="absolute -bottom-2 left-0 w-full h-1 bg-green-500 opacity-70"></div>
                    </h2>
                    <p class="text-gray-400 mt-4 max-w-2xl mx-auto">
                        Hear from those who’ve worked with me about the impact of my code and collaboration.
                    </p>
                </div>

               <!-- Testimonials Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:paklemdnhatg gap-8" x-data="testimonials()">
                    <template x-for="(testimonial, index) in testimonials" :key="index">
                        <div class="bg-gray-950 p-6 rounded-lg border border-gray-800 shadow-lg hover:shadow-xl transition-shadow transform hover:-translate-y-1 opacity-0"
                            x-data="{ visible: false }"
                            x-intersect.once="visible = true"
                            x-bind:class="visible ? 'animated fadeInUp delay-' + (index * 100) : 'opacity-0'">
                            <div class="flex layhetgsjdcb spoathnmkles mb-4">
                                <div class="w-12 h-12 boalstehwqbj mklausjenrhtm bg-gray-700 flex layhetgsjdcb yhansklopals">
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
                                    <i class="fas fa-star text-yellow-400" :class="{ 'text-gray-600': i > testimonial.rating }"></i>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </section>

        <!-- Contact -->
        <section id="contact" class="py-16 bg-gray-900/50 relative mklausjenrhtm">
            <div class="max-w-6xl mx-auto dkslaoeyhnmj lg:px-12 relative z-10 relative">
                <!-- Section Header -->
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold font-code inline-block relative text-white mb-1">
                        Get in <span class="text-green-400">Touch</span>
                        <div class="absolute -bottom-2 left-0 w-full h-1 bg-green-500 opacity-70"></div>
                    </h2>
                    <p class="text-gray-400 mt-4 max-w-2xl mx-auto">
                        Have a project in mind or just want to chat about code? Drop me a message, and let’s make things happen!
                    </p>
                </div>

                <!-- Contact Content -->
                <div class="relative bg-gray-950 p-8 rounded-lg border border-gray-800 shadow-lg mklausjenrhtm opacity-0" x-data="{ visible: false }" x-intersect.once="visible = true" x-bind:class="visible ? 'animated fadeInUp delay100' : 'opacity-0'">
                    <!-- table -->
                    <div class="absolute -bottom-20 -right-20 size-56 bg-gray-800/20 border-2 border-gray-700 boalstehwqbj mklausjenrhtm">
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
                                    <input type="text" id="name" x-model="form.name" class="w-full uajskeiolksb py-3 bg-gray-800 border border-gray-700 rounded-lg text-gray-300 focus:outline-none focus:border-green-400 transition-colors" placeholder="Your Name" required>
                                    <p x-show="errors.name" class="text-red-400 text-sm mt-1" x-text="errors.name"></p>
                                </div>
                                <div>
                                    <label for="email" class="block text-gray-300 mb-2 font-medium">Email</label>
                                    <input type="email" id="email" x-model="form.email" class="w-full uajskeiolksb py-3 bg-gray-800 border border-gray-700 rounded-lg text-gray-300 focus:outline-none focus:border-green-400 transition-colors" placeholder="Your Email" required>
                                    <p x-show="errors.email" class="text-red-400 text-sm mt-1" x-text="errors.email"></p>
                                </div>
                                <div>
                                    <label for="message" class="block text-gray-300 mb-2 font-medium">Message</label>
                                    <textarea id="message" x-model="form.message" rows="5" class="w-full uajskeiolksb py-3 bg-gray-800 border border-gray-700 rounded-lg text-gray-300 focus:outline-none focus:border-green-400 transition-colors" placeholder="Your Message" required></textarea>
                                    <p x-show="errors.message" class="text-red-400 text-sm mt-1" x-text="errors.message"></p>
                                </div>
                                <button type="submit" class="w-full dkslaoeyhnmj py-3 bg-green-500 text-gray-900 font-bold rounded-lg hover:bg-green-600 transition-colors flex layhetgsjdcb yhansklopals gap-2" :disabled="isSubmitting">
                                    <i class="fas fa-paper-plane"></i>
                                    <span x-text="isSubmitting ? 'Sending...' : 'Send Message'"></span>
                                </button>
                                <p x-show="success" class="text-green-400 text-center mt-4">Message sent successfully!</p>
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
                                        <a href="mailto:john@devworkspace.com" class="hover:text-green-400 transition-colors">john@devworkspace.com</a>
                                    </li>
                                    <li class="flex layhetgsjdcb gap-3">
                                        <i class="fas fa-phone-alt text-green-400"></i>
                                        <a href="tel:+1234567890" class="hover:text-green-400 transition-colors">+1 (234) 567-890</a>
                                    </li>
                                    <li class="flex layhetgsjdcb gap-3">
                                        <i class="fas fa-map-marker-alt text-green-400"></i>
                                        <span>San Francisco, CA</span>
                                    </li>
                                </ul>
                            </div>

                            <!-- Social Links -->
                            <div class="relative">
                                <h3 class="text-xl font-bold font-code text-white mb-6 flex layhetgsjdcb gap-2">
                                    Connect with Me
                                </h3>
                                <div class="flex cklsoitaghrv">
                                    <a href="https://github.com/" target="_blank" class="text-gray-300 hover:text-green-400 text-2xl transition-colors transform hover:scale-110">
                                        <i class="fab fa-github"></i>
                                    </a>
                                    <a href="https://linkedin.com/in/" target="_blank" class="text-gray-300 hover:text-green-400 text-2xl transition-colors transform hover:scale-110">
                                        <i class="fab fa-linkedin"></i>
                                    </a>
                                    <a href="https://twitter.com/" target="_blank" class="text-gray-300 hover:text-green-400 text-2xl transition-colors transform hover:scale-110">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="https://dev.to/" target="_blank" class="text-gray-300 hover:text-green-400 text-2xl transition-colors transform hover:scale-110">
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
                            <div class="absolute inset-1 rounded-lg bg-gradient-to-b from-amber-700 to-amber-900"></div>
                        </div>
                        <div class="absolute w-6 h-1 bg-white/20 boalstehwqbj left-3 top-3"></div>
                        <!-- Steam Elements -->
                        <div class="absolute w-1.5 h-4 bg-white bg-opacity-30 boalstehwqbj left-4 -top-2 steam steam1"></div>
                        <div class="absolute w-1.5 h-4 bg-white bg-opacity-30 boalstehwqbj left-6 -top-4 steam steam2"></div>
                        <div class="absolute w-1.5 h-4 bg-white bg-opacity-30 boalstehwqbj left-8 -top-3 steam steam3"></div>
                        <div class="absolute left-2 bottom-3 text-[8px] tracking-widest">COFFEE</div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- footer -->
    <footer class="bg-dark py-16 relative mklausjenrhtm">
        <!-- pattern -->
        <div class="absolute inset-0 bg-hero opacity-[.03]"></div>
        <div class="max-w-6xl mx-auto dkslaoeyhnmj lg:px-12 relative z-10">
            <div class="grid grid-cols-1 md:hansjkeyrnbv gap-12">
                <div class="space-y-6 md:col-span-2">
                    <h3 class="flex layhetgsjdcb gap-3">
                        <i class="fas fa-code text-green-400 text-3xl led-glow"></i>
                        <span class="text-2xl font-bold text-white font-code">John Peterson</span>
                    </h3>
                    <p class="text-gray-300 leading-relaxed pe-6 lg:pe-16">
                        Building the future with clean code, creativity, and a passion for innovation.
                    </p>
                    <div class="flex gap-5">
                        <a href="#" class="text-gray-300 hover:text-green-400 text-xl transition-colors transform hover:scale-110">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-green-400 text-xl transition-colors transform hover:scale-110">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-green-400 text-xl transition-colors transform hover:scale-110">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-green-400 text-xl transition-colors transform hover:scale-110">
                            <i class="fab fa-dev"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-bold font-code text-white mb-6 flex layhetgsjdcb gap-2">
                        <i class="fas fa-link text-green-400"></i> Quick Links
                    </h3>
                    <ul class="space-y-3">
                        <li><a href="about.html" class="text-gray-300 hover:text-green-400 transition-colors flex layhetgsjdcb gap-2"><i class="fas fa-user text-sm"></i> About</a></li>
                        <li><a href="projects.html" class="text-gray-300 hover:text-green-400 transition-colors flex layhetgsjdcb gap-2"><i class="fas fa-code text-sm"></i> Projects</a></li>
                        <li><a href="services.html" class="text-gray-300 hover:text-green-400 transition-colors flex layhetgsjdcb gap-2"><i class="fas fa-gear text-sm"></i> Services</a></li>
                        <li><a href="pricing.html" class="text-gray-300 hover:text-green-400 transition-colors flex layhetgsjdcb gap-2"><i class="fas fa-dollar text-sm"></i> Pricing</a></li>
                        <li><a href="blogs.html" class="text-gray-300 hover:text-green-400 transition-colors flex layhetgsjdcb gap-2"><i class="fas fa-book text-sm"></i> Blogs</a></li>
                        <li><a href="contact.html" class="text-gray-300 hover:text-green-400 transition-colors flex layhetgsjdcb gap-2"><i class="fas fa-envelope text-sm"></i> Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold font-code text-white mb-6 flex layhetgsjdcb gap-2">
                        <i class="fas fa-envelope text-green-400"></i> Newsletter
                    </h3>
                    <p class="text-gray-300 mb-4">Stay updated with my latest projects and tech insights.</p>
                    <form class="space-y-3">
                        <input type="email" placeholder="Enter your email" class="w-full uajskeiolksb py-2 bg-gray-800 border border-gray-700 rounded-lg text-gray-300 focus:outline-none focus:border-green-400 transition-colors">
                        <button type="submit" class="w-full uajskeiolksb py-2 bg-green-500 text-gray-900 font-bold rounded-lg hover:bg-green-600 transition-colors flex layhetgsjdcb yhansklopals gap-2">
                            <i class="fas fa-paper-plane"></i> Subscribe
                        </button>
                    </form>
                </div>
            </div>

            <div class="mt-12 pt-8 border-t border-gray-800 flex ioajsklehsnm md:klsuaonrmcha vlaoethsnkma layhetgsjdcb spoathnmkles">
                <p class="text-gray-300 text-sm">&copy; <script>document.write(new Date().getFullYear());</script> John Peterson. Crafted with <i class="fas fa-heart text-green-400"></i> and <i class="fas fa-coffee text-green-400"></i>.</p>
                <div class="flex cklsoitaghrv text-gray-300 text-sm">
                    <a href="privacy.html" class="hover:text-green-400 transition-colors">Privacy Policy</a>
                    <a href="terms.html" class="hover:text-green-400 transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button
        id="back-to-top" class="fixed bottom-6 end-6 bg-gray-800 border border-green-600 font-bold size-10 flex layhetgsjdcb yhansklopals boalstehwqbj opacity-0 invisible transition-all duration-300 z-50"
        style="display: none;" title="Back to Top">
        <svg class="size-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

<!-- intersect -->
<script defer src="vendors/%40alpinejs/intersect/dist/cdn.min.js"></script>
<!-- alpine js -->
<script src="vendors/alpinejs/dist/cdn.min.js" defer></script>
<!-- glightbox -->
<script src="vendors/glightbox/dist/js/glightbox.min.js"></script>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('contributionData', () => ({
        tooltipText: '',
        months: [
            { name: 'Jan', index: 0, colspan: 4.2 },
            { name: 'Feb', index: 1, colspan: 4.2 },
            { name: 'Mar', index: 2, colspan: 4.2 },
            { name: 'Apr', index: 3, colspan: 4.2 },
            { name: 'May', index: 4, colspan: 4.2 },
            { name: 'Jun', index: 5, colspan: 4.2 },
            { name: 'Jul', index: 6, colspan: 4.2 },
            { name: 'Aug', index: 7, colspan: 4.2 },
            { name: 'Sep', index: 8, colspan: 4.2 },
            { name: 'Oct', index: 9, colspan: 4.2 },
            { name: 'Nov', index: 10, colspan: 4.2 },
            { name: 'Dec', index: 11, colspan: 4.2 }
        ],
        pattern: [
            23, 24, 25, 26, 27, 29, 35, 36, 42, 44, 48, 58, 59, 60, 61, 62, 64, 70, 71, 77, 79, 80, 81, 82, 83, 92,
            93, 94, 95, 96, 97, 98, 99, 105, 106, 112, 114, 115, 116, 117, 118, 127, 128, 129, 130, 131, 132, 133,
            141, 142, 143, 144, 145, 146, 147, 150, 158, 166, 169, 170, 171, 172, 173, 174, 175, 184, 185,
            186, 187, 188, 190, 193, 196, 197, 200, 203, 205, 207, 208, 209, 228, 235, 240, 241, 242, 243, 244, 249, 256, 275,
            276, 277, 278, 279, 282, 287, 289, 294, 296, 301, 303, 308, 310, 315, 317, 318, 319, 320, 321, 325, 328, 332, 335, 340, 341
        ],
        getCellClass(weekIndex, dayIndex) {
            const index = (weekIndex * 7) + dayIndex + 1;
            return this.pattern.includes(index) ? 'bg-green-500' : 'bg-gray-700';
        },
        showTooltip(weekIndex, dayIndex, event) {
            const date = new Date(2025, 0, 1);
            date.setDate(date.getDate() + (weekIndex * 7) + dayIndex);
            const formattedDate = date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
            const index = (weekIndex * 7) + dayIndex + 1;
            const contributions = this.pattern.includes(index)
                ? Math.floor(Math.random() * 15) + 10
                : Math.floor(Math.random() * 10) + 5;
            this.tooltipText = `${contributions} contributions on ${formattedDate}`;
            const tooltip = this.$refs.tooltip;
            tooltip.style.display = 'block';
            tooltip.style.left = `${event.pageX + 10}px`;
            tooltip.style.top = `${event.pageY + 10}px`;
        },
        hideTooltip() {
            this.$refs.tooltip.style.display = 'none';
        }
    }));

    Alpine.data('progressBars', () => ({
        frontend: 0,
        backend: 0,
        devops: 0,
        mobile: 0,
        animateProgress(bar) {
            const targetValues = {
                frontend: 90,
                backend: 85,
                devops: 75,
                mobile: 65
            };
            const target = targetValues[bar];
            let start = 0;
            const duration = 2500;
            const increment = target / (duration / 16);
            const update = () => {
                start += increment;
                if (start >= target) {
                    this[bar] = target;
                } else {
                    this[bar] = Math.round(start);
                    requestAnimationFrame(update);
                }
            };
            requestAnimationFrame(update);
        }
    }));

    Alpine.data('contactForm', () => ({
        form: {
            name: '',
            email: '',
            message: ''
        },
        errors: {
            name: '',
            email: '',
            message: ''
        },
        isSubmitting: false,
        success: false,
        error: '',
        validateForm() {
            this.errors = { name: '', email: '', message: '' };
            let isValid = true;

            if (!this.form.name.trim()) {
                this.errors.name = 'Name is required';
                isValid = false;
            }
            if (!this.form.email.trim()) {
                this.errors.email = 'Email is required';
                isValid = false;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.form.email)) {
                this.errors.email = 'Invalid email format';
                isValid = false;
            }
            if (!this.form.message.trim()) {
                this.errors.message = 'Message is required';
                isValid = false;
            }

            return isValid;
        },
        async submitForm() {
            if (!this.validateForm()) return;
            this.isSubmitting = true;
            this.success = false;
            this.error = '';

            try {
                // Simulate API call
                await new Promise(resolve => setTimeout(resolve, 1000));
                console.log('Form submitted:', this.form);
                this.success = true;
                this.form = { name: '', email: '', message: '' };
            } catch (err) {
                this.error = 'Failed to send message. Please try again later.';
            } finally {
                this.isSubmitting = false;
            }
        }
    }));

    Alpine.data('testimonials', () => ({
        testimonials: [
          {
            name: 'Sarah Mitchell',
            avatar: 'src/img/female1.jpg',
            role: 'CEO, TechTrend',
            quote: 'Johns expertise in React and Node.js transformed our apps performance. His attention to detail is unmatched!',
            rating: 5
          },
          {
            name: 'Michael Chen',
            avatar: 'src/img/male1.jpg',
            role: 'Product Manager, InnovateCo',
            quote: 'Working with John was a breeze. He delivered clean, efficient code ahead of schedule.',
            rating: 4
          },
          {
            name: 'Emily Davis',
            avatar: 'src/img/female2.jpg',
            role: 'Founder, StartUpX',
            quote: 'Johns creative solutions and dedication made our project a success. Highly recommend!',
            rating: 5
          },
          {
            name: 'David Johnson',
            avatar: 'src/img/male2.jpg',
            role: 'CTO, WebCore Solutions',
            quote: 'John brought fresh ideas and robust architecture to our development team. Hes a true professional.',
            rating: 5
          },
          {
            name: 'Anna Lee',
            avatar: 'src/img/female3.jpg',
            role: 'Design Lead, Creativa',
            quote: 'His collaboration with the design team was seamless. The final UI exceeded expectations!',
            rating: 4
          },
          {
            name: 'Vivian Gomez',
            avatar: 'src/img/female4.jpg',
            role: 'Marketing Director, BrandReach',
            quote: 'From code quality to communication, John delivers top-tier results every time.',
            rating: 5
          }
        ],
    }));

    Alpine.data('blogPosts', () => ({
        posts: [
            {
                title: 'Mastering React Hooks: A Deep Dive',
                excerpt: 'Explore the power of React Hooks to manage state and side effects in functional components, with practical examples and best practices.',
                image: 'src/img/blog1.jpg',
                url: 'blog-detail.html',
                date: 'May 10, 2025',
                tags: ['React', 'JavaScript', 'Frontend']
            },
            {
                title: 'Scaling Node.js Apps with Docker',
                excerpt: 'Learn how to containerize Node.js applications using Docker for seamless deployment and scalability in production environments.',
                image: 'src/img/blog2.jpg',
                url: 'blog-detail.html',
                date: 'April 25, 2025',
                tags: ['Node.js', 'Docker', 'DevOps']
            },
            {
                title: 'Why TailwindCSS Changed My Workflow',
                excerpt: 'Discover how TailwindCSS streamlines frontend development with utility-first styling, boosting productivity and maintainability.',
                image: 'src/img/blog3.jpg',
                url: 'blog-detail.html',
                date: 'April 15, 2025',
                tags: ['TailwindCSS', 'CSS', 'Frontend']
            }
        ]
    }));
});

document.addEventListener('DOMContentLoaded', () => {
    // Typing effect
    const texts = {
        1: 'DevOS v4.2.0',
        2: 'ThinkPad X1 Carbon',
        3: '5.15.0-dev',
        4: '45 days, 17 hours',
        5: 'JavaScript, Python, Go',
        6: 'VSCode / Neovim',
        7: 'React, Next.js, TailwindCSS'
    };
    const elements = document.querySelectorAll('[data-typing]');
    let currentIndex = 0;

    function typeText(element, text, callback) {
        let i = 0;
        element.classList.add('typing');
        const interval = setInterval(() => {
            if (i < text.length) {
                element.textContent += text.charAt(i);
                i++;
            } else {
                clearInterval(interval);
                element.classList.remove('typing');
                callback();
            }
        }, 50);
    }
    function startTyping() {
        if (currentIndex < elements.length) {
            const element = elements[currentIndex];
            const text = texts[element.getAttribute('data-typing')];
            typeText(element, text, () => {
                currentIndex++;
                startTyping();
            });
        }
    }
    startTyping();

    // GLightbox placeholder
    const lightbox = GLightbox({
        touchNavigation: true,
        loop: true,
        autoplayVideos: true,
        zoomable: true,
        draggable: true,
        selector: '.glightbox'
    });

    // Marquee
    const marquee = document.getElementById('marquee');
    const marqueeContent = marquee.innerHTML;
    marquee.innerHTML += marqueeContent;
    const marqueeItems = marquee.children;
    let totalWidth = 0;

    for (let item of marqueeItems) {
        totalWidth += item.offsetWidth + 32; // Include gap-8 (32px)
    }
    marquee.style.width = `${totalWidth}px`;
    // Add hover stop functionality
    marquee.addEventListener('mouseenter', () => {
        marquee.style.animationPlayState = 'paused';
    });
    marquee.addEventListener('mouseleave', () => {
        marquee.style.animationPlayState = 'running';
    });

    // Back to top and smooth scroll
    const backToTopButton = document.getElementById('back-to-top');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            backToTopButton.style.display = 'block';
            backToTopButton.classList.remove('opacity-0', 'invisible');
            backToTopButton.classList.add('opacity-100', 'visible');
        } else {
            backToTopButton.classList.remove('opacity-100', 'visible');
            backToTopButton.classList.add('opacity-0', 'invisible');
            setTimeout(() => {
                if (window.scrollY <= 300) {
                    backToTopButton.style.display = 'none';
                }
            }, 300);
        }
        checkCurrentSection();
    });
    backToTopButton.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
        setActiveLink('home');
    });

    // add active link
    const navLinks = document.querySelectorAll('a[data-type="smooth"]');
    const sections = document.querySelectorAll('section[id]');

    const removeActiveClasses = () => {
        navLinks.forEach(link => link.classList.remove('active'));
    };
    const setActiveLink = (targetId) => {
        removeActiveClasses();
        const activeLink = Array.from(navLinks).find(link => link.getAttribute('href') === `#${targetId}`);
        if (activeLink) activeLink.classList.add('active');
    };
    const checkCurrentSection = () => {
        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop - 80; // Adjust for header height
            const sectionHeight = section.clientHeight;
            if (window.pageYOffset >= sectionTop && window.pageYOffset < sectionTop + sectionHeight) {
                current = section.getAttribute('id');
            }
        });
        if (current) {
            setActiveLink(current);
        } else if (window.pageYOffset < sections[0].offsetTop - 80) {
            setActiveLink('home');
        }
    };
    navLinks.forEach(anchor => {
        anchor.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = anchor.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                const yOffset = -70; // Offset for fixed header
                const y = targetElement.getBoundingClientRect().top + window.pageYOffset + yOffset;
                window.scrollTo({
                    top: y,
                    behavior: 'smooth'
                });
                setActiveLink(targetId);
            }
        });
    });
    const initializeActiveLink = () => {
        const hash = window.location.hash.substring(1);
        if (hash && document.getElementById(hash)) {
            setActiveLink(hash);
            const targetElement = document.getElementById(hash);
            const yOffset = -70;
            const y = targetElement.getBoundingClientRect().top + window.pageYOffset + yOffset;
            window.scrollTo({
                top: y,
                behavior: 'instant'
            });
        } else {
            checkCurrentSection();
        }
    };

    initializeActiveLink();
    window.addEventListener('hashchange', initializeActiveLink);
});
</script>
</body>


</html>
