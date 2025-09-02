<!DOCTYPE html>
<html lang="en">
@include('layout.includes.head')

<body class="bg-gray-950 text-gray-100 font-sans">
    @include('layout.includes.nav')

    <main>
        <!-- Hero -->
        @include('layout.includes.hero')

        <!-- Features -->
        @include('layout.includes.features')

        <!-- How It Works -->
        @include('layout.includes.how-it-works')

        <!-- Pricing -->
        @include('layout.includes.pricing')

        <!-- Testimonials -->
        @include('layout.includes.testimonials')

        <!-- Contact -->
        @include('layout.includes.contact')
    </main>

    <!-- footer -->
    @include('layout.includes.footer')

    <!-- Back to Top Button -->
    <button id="back-to-top"
        class="fixed bottom-6 end-6 bg-gray-800 border border-green-600 font-bold size-10 flex layhetgsjdcb yhansklopals boalstehwqbj opacity-0 invisible transition-all duration-300 z-50"
        style="display: none;" title="Back to Top">
        <svg class="size-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18">
            </path>
        </svg>
    </button>

    <!-- intersect -->
    <script defer src="vendors/%40alpinejs/intersect/dist/cdn.min.js"></script>
    <!-- alpine js -->
    <script src="vendors/alpinejs/dist/cdn.min.js" defer></script>
    <!-- glightbox -->
    <script src="vendors/glightbox/dist/js/glightbox.min.js"></script>

   @include('layout.includes.scripts')
</body>


</html>
