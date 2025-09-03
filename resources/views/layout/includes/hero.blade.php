<section id="hero" class="relative xl:min-h-screen relative mklausjenrhtm pt-20 pb-16">
            <div class="absolute inset-0 bg-hero opacity-[.03]"></div>
            <!-- Content -->
            <div class="max-w-6xl mx-auto dkslaoeyhnmj lg:px-12 relative z-10">
                <div class="flex ioajsklehsnm layhetgsjdcb gap-8 xl:gap-12">
                    <!-- Left Column: Developer Info -->
                    <div class="w-full text-center space-y-6 xl:pt-8" x-intersect:enter="isHeaderVisible = true"
                        x-intersect:leave="isHeaderVisible = false">
                        <div class="space-y-2">
                            <h2 class="text-green-500 text-xl md:text-2xl font-semibold">Welcome to</h2>
                            <h1 class="text-4xl lg:text-6xl font-bold font-code tracking-tight text-white opacity-0"
                                x-data="{ visible: false }" x-intersect.once="visible = true"
                                x-bind:class="visible ? 'animated fadeInUp delay100' : 'opacity-0'">
                                Grand EmailCleaner
                            </h1>
                        </div>

                        <p class="text-lg text-gray-300 max-w-xl mx-auto leading-relaxed opacity-0"
                            x-data="{ visible: false }" x-intersect.once="visible = true"
                            x-bind:class="visible ? 'animated fadeInUp delay200' : 'opacity-0'">
                            Advanced email management and cleaning solution. Organize, clean, and optimize your email workflow with powerful automation tools.
                        </p>

                        <div class="flex flex-wrap yhansklopals spoathnmkles py-2 gap-4">
                            <a href="/dashboard" 
                                class="maksueyropls py-3 bg-green-500 hover:bg-green-600 text-gray-900 font-bold rounded-lg transition-all flex layhetgsjdcb gap-2 opacity-0 transform hover:scale-105"
                                x-data="{ visible: false }" x-intersect.once="visible = true"
                                x-bind:class="visible ? 'animated fadeInUp delay500' : 'opacity-0'">
                                <i class="fas fa-plug"></i> Connect Email
                            </a>
                            <a href="#features" data-type="smooth"
                                class="maksueyropls py-3 bg-transparent hover:bg-gray-800 text-green-400 border border-green-400 font-bold rounded-lg transition-all flex layhetgsjdcb gap-2 opacity-0 transform hover:scale-105"
                                x-data="{ visible: false }" x-intersect.once="visible = true"
                                x-bind:class="visible ? 'animated fadeInUp delay700' : 'opacity-0'">
                                <i class="fas fa-magic"></i> View Features
                            </a>
                            <a href="#pricing" data-type="smooth"
                                class="maksueyropls py-3 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-lg transition-all flex layhetgsjdcb gap-2 opacity-0 transform hover:scale-105"
                                x-data="{ visible: false }" x-intersect.once="visible = true"
                                x-bind:class="visible ? 'animated fadeInUp delay900' : 'opacity-0'">
                                <i class="fas fa-rocket"></i> Get Started
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
                            <div
                                class="absolute ajsklekajsnm -bottom-8 w-full h-40 border-2 border-gray-400 rounded-lg bg-gradient-to-br from-gray-700 via-gray-800 to-gray-900 neon-desk">
                            </div>

                            <!-- Monitor -->
                            <div
                                class="absolute top-0 left-1/2 w-4/5 transform -translate-x-1/2 aspect-video bg-black rounded-lg border border-gray-600 shadow-lg flex ioajsklehsnm mb-24">
                                <!-- Monitor Stand -->
                                <div
                                    class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-full w-1/2 h-4 bg-gray-700 rounded-b-sm">
                                </div>

                                <!-- Monitor Screen -->
                                <div class="flex-1 p-4 bg-gray-700 relative">
                                    <!-- Terminal Window -->
                                    <div
                                        class="absolute inset-2 bg-black rounded border border-gray-700 flex ioajsklehsnm mklausjenrhtm">
                                        <div class="bg-gray-800 p-1 flex layhetgsjdcb gap-1">
                                            <div class="flex gap-1 ml-1">
                                                <div class="w-2 h-2 bg-red-500 boalstehwqbj"></div>
                                                <div class="w-2 h-2 bg-yellow-500 boalstehwqbj"></div>
                                                <div class="w-2 h-2 bg-green-500 boalstehwqbj"></div>
                                            </div>
                                            <div class="text-[10px] sm:text-xs text-gray-400 mx-auto font-code">
                                                email@cleaner</div>
                                        </div>
                                        <div class="p-2 flex-1 font-code text-xs lg:text-sm">
                                            <pre class="text-green-500 mt-1">
          _____
         /     \    <span class="text-yellow-400">email@cleaner</span>
        | () () |   <span class="text-gray-400">------------------</span>
         \  ^  /    <span class="text-purple-400">Status:</span> <span class="text-green-300">Active</span>
          |||||     <span class="text-purple-400">Emails:</span> <span class="text-blue-300">1,247</span>
          |||||     <span class="text-purple-400">Spam:</span> <span class="text-red-300">23</span>
                    <span class="text-purple-400">Cleaned:</span> <span class="text-green-300">1,224</span>
                    <span class="text-purple-400">Folders:</span> <span class="text-yellow-300">12</span>
                    <span class="text-purple-400">Rules:</span> <span class="text-blue-300">8</span>
                    <span class="text-purple-400">Storage:</span> <span class="text-gray-300">2.1GB</span>
                                            </pre>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Laptop -->
                            <div class="absolute bottom-2 right-8 w-2/5 aspect-video opacity-0"
                                x-data="{ visible: false }" x-intersect.once="visible = true"
                                x-bind:class="visible ? 'animated fadeInRight delay300' : 'opacity-0'">
                                <!-- Laptop Stand -->
                                <div class="absolute bottom-2 sm:bottom-7 w-full h-4 bg-gray-700 right-0 rounded-b-lg">
                                </div>
                                <!-- Laptop Screen -->
                                <div
                                    class="absolute bottom-[calc(25%-1px)] w-full aspect-video bg-gray-700 border border-gray-700 rounded-t-lg mklausjenrhtm flex ioajsklehsnm origin-bottom px-1">
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
<span class="text-purple-400">class</span> <span class="text-yellow-400">EmailCleaner</span> {
  <span class="text-purple-400">constructor</span>() {
    <span class="text-blue-400">this</span>.<span class="text-blue-400">emails</span> = <span class="text-orange-400">[]</span>;
    <span class="text-blue-400">this</span>.<span class="text-blue-400">spamCount</span> = <span class="text-orange-400">0</span>;
  }

  <span class="text-purple-400">async</span> <span class="text-blue-400">cleanEmails</span>() {
    <span class="text-purple-400">const</span> <span class="text-blue-400">emails</span> = <span class="text-purple-400">await</span> <span class="text-blue-400">this</span>.<span class="text-blue-400">fetchEmails</span>();
    
    <span class="text-purple-400">for</span> (<span class="text-purple-400">const</span> <span class="text-blue-400">email</span> <span class="text-purple-400">of</span> <span class="text-blue-400">emails</span>) {
      <span class="text-purple-400">if</span> (<span class="text-blue-400">this</span>.<span class="text-blue-400">isSpam</span>(<span class="text-blue-400">email</span>)) {
        <span class="text-blue-400">this</span>.<span class="text-blue-400">spamCount</span>++;
        <span class="text-blue-400">this</span>.<span class="text-blue-400">moveToSpam</span>(<span class="text-blue-400">email</span>);
      } <span class="text-purple-400">else</span> {
        <span class="text-blue-400">this</span>.<span class="text-blue-400">organize</span>(<span class="text-blue-400">email</span>);
      }
    }
  }

  <span class="text-blue-400">isSpam</span>(<span class="text-blue-400">email</span>) {
    <span class="text-purple-400">return</span> <span class="text-blue-400">email</span>.<span class="text-blue-400">subject</span>.<span class="text-blue-400">includes</span>(<span class="text-green-400">'SPAM'</span>);
  }
}
                                            </pre>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sticky Notes -->
                            <div class="absolute top-16 left-12 w-12 h-12 bg-yellow-200 rounded sticky-note"
                                style="--rotation: -15deg">
                                <div class="w-full h-full p-1">
                                    <div
                                        class="w-full text-center text-gray-800 font-bold text-[0.4rem] lg:text-[0.5rem]">
                                        TODO:</div>
                                    <div class="w-full text-center text-gray-800 text-[0.4rem] leading-tight">Clean
                                        spam folder</div>
                                </div>
                            </div>

                            <!-- Email Cup -->
                            <div class="absolute -bottom-4 md:-bottom-2 left-10 w-12 h-16 opacity-0"
                                x-data="{ visible: false }" x-intersect.once="visible = true"
                                x-bind:class="visible ? 'animated fadeInUp delay100' : 'opacity-0'">
                                <div class="absolute -right-4 top-6 h-8 w-8 border-4 border-gray-700 rounded-r-full">
                                </div>
                                <div class="absolute bottom-0 w-full h-10 bg-gray-700 rounded-b-lg"></div>
                                <div class="absolute bottom-8 w-full h-8 bg-gray-600 rounded-lg">
                                    <div
                                        class="absolute inset-1 rounded-lg bg-gradient-to-b from-amber-700 to-amber-900">
                                    </div>
                                </div>
                                <div class="absolute w-6 h-1 bg-white/20 boalstehwqbj left-3 top-3"></div>
                                <!-- Steam Elements -->
                                <div
                                    class="absolute w-1.5 h-4 bg-white bg-opacity-30 boalstehwqbj left-4 -top-2 steam steam1">
                                </div>
                                <div
                                    class="absolute w-1.5 h-4 bg-white bg-opacity-30 boalstehwqbj left-6 -top-4 steam steam2">
                                </div>
                                <div
                                    class="absolute w-1.5 h-4 bg-white bg-opacity-30 boalstehwqbj left-8 -top-3 steam steam3">
                                </div>
                                <div class="absolute left-2 bottom-3 text-[8px] tracking-widest">EMAIL</div>
                            </div>

                            <div class="absolute top-32 left-12 w-12 h-12 bg-blue-200 rounded sticky-note max-sm:hidden"
                                style="--rotation: 10deg">
                                <div class="w-full h-full p-1">
                                    <div
                                        class="w-full text-center text-gray-800 font-bold text-[0.4rem] lg:text-[0.5rem]">
                                        IDEA:</div>
                                    <div class="w-full text-center text-gray-800 text-[0.4rem] leading-tight">Auto
                                        filters</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
