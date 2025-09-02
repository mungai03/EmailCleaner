<header class="sticky top-0 z-50 bg-gray-950/95 backdrop-blur-sm border-b border-gray-800" x-data="{ open: false, scrolled: false }"
        @scroll.window="scrolled = window.scrollY > 50">
        <nav class="max-w-6xl mx-auto dkslaoeyhnmj lg:px-12 py-6 flex layhetgsjdcb vlaoethsnkma">
            <a href="index.html" class="flex layhetgsjdcb gap-3">
                <i class="fas fa-envelope text-green-400 text-2xl led-glow"></i>
                <span class="text-xl font-bold text-white font-code">Grand EmailCleaner</span>
            </a>
            <div class="hidden md:flex layhetgsjdcb gap-10">
                <a href="#features" data-type="smooth"
                    class="text-gray-300 hover:text-green-400 [&.active]:text-green-400 [&.active>span]:w-full transition-colors font-medium relative group">
                    Features
                    <span
                        class="absolute -bottom-1 left-0 w-0 h-0.5 bg-green-400 transition-all group-hover:w-full"></span>
                </a>
                <a href="#how-it-works" data-type="smooth"
                    class="text-gray-300 hover:text-green-400 [&.active]:text-green-400 [&.active>span]:w-full transition-colors font-medium relative group">
                    How It Works
                    <span
                        class="absolute -bottom-1 left-0 w-0 h-0.5 bg-green-400 transition-all group-hover:w-full"></span>
                </a>
                <a href="#pricing" data-type="smooth"
                    class="text-gray-300 hover:text-green-400 [&.active]:text-green-400 [&.active>span]:w-full transition-colors font-medium relative group">
                    Pricing
                    <span
                        class="absolute -bottom-1 left-0 w-0 h-0.5 bg-green-400 transition-all group-hover:w-full"></span>
                </a>
                <a href="#testimonials" data-type="smooth"
                    class="text-gray-300 hover:text-green-400 [&.active]:text-green-400 [&.active>span]:w-full transition-colors font-medium relative group">
                    Reviews
                    <span
                        class="absolute -bottom-1 left-0 w-0 h-0.5 bg-green-400 transition-all group-hover:w-full"></span>
                </a>
                <a href="#contact" data-type="smooth"
                    class="text-gray-300 hover:text-green-400 [&.active]:text-green-400 [&.active>span]:w-full transition-colors font-medium relative group">
                    Contact
                    <span
                        class="absolute -bottom-1 left-0 w-0 h-0.5 bg-green-400 transition-all group-hover:w-full"></span>
                </a>
                <a href="/dashboard"
                    class="text-gray-300 hover:text-green-400 [&.active]:text-green-400 [&.active>span]:w-full transition-colors font-medium relative group">
                    Dashboard
                    <span
                        class="absolute -bottom-1 left-0 w-0 h-0.5 bg-green-400 transition-all group-hover:w-full"></span>
                </a>
            </div>
            <div class="md:hidden">
                <button @click="open = !open" class="text-gray-300 hover:text-green-400 transition-colors">
                    <i x-show="!open" class="fas fa-bars text-2xl"></i>
                    <i x-show="open" class="fas fa-times text-2xl"></i>
                </button>
                <div x-show="open" style="display:none;" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2"
                    class="absolute top-full left-0 right-0 bg-gray-950 border-b border-gray-800 p-6 flex ioajsklehsnm spoathnmkles shadow-lg">
                    <a href="#features" data-type="smooth" @click="open = false"
                        class="text-gray-300 hover:text-green-400 [&.active]:text-green-400 transition-colors font-medium">Features</a>
                    <a href="#how-it-works" data-type="smooth" @click="open = false"
                        class="text-gray-300 hover:text-green-400 [&.active]:text-green-400 transition-colors font-medium">How It Works</a>
                    <a href="#pricing" data-type="smooth" @click="open = false"
                        class="text-gray-300 hover:text-green-400 [&.active]:text-green-400 transition-colors font-medium">Pricing</a>
                    <a href="#testimonials" data-type="smooth" @click="open = false"
                        class="text-gray-300 hover:text-green-400 [&.active]:text-green-400 transition-colors font-medium">Reviews</a>
                    <a href="#contact" data-type="smooth" @click="open = false"
                        class="text-gray-300 hover:text-green-400 [&.active]:text-green-400 transition-colors font-medium">Contact</a>
                    <a href="/dashboard" @click="open = false"
                        class="text-gray-300 hover:text-green-400 [&.active]:text-green-400 transition-colors font-medium">Dashboard</a>
                </div>
            </div>
        </nav>
    </header>
