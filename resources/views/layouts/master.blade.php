<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SherpaFoodnBar</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@100;300;400;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>

    <!-- Navbar - Contact Info (Top Bar) -->
    <div class="bg-red-500 text-white text-xs sm:text-sm">
        <div class="container mx-auto flex justify-between items-center py-2 px-4">
            <!-- Contact Information -->
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <i class="ri-phone-fill"></i>
                    <span>9800001111</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="ri-mail-open-fill"></i>
                    <span>SherpaFoodnBar@gmail.com</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navbar (Logo & Navigation) -->
    <div class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <!-- Logo -->
            <div class="flex items-center">
                <img src="{{ asset('images/logo.jpg') }}" alt="Sherpa Food & Bar Logo" class="h-16 sm:h-20">
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center space-x-6 text-sm font-medium">
                <a href="/" class="text-gray-800 hover:text-red-600 font-bold">HOME</a>
                <a href="/about" class="text-gray-800 hover:text-red-600 font-bold">ABOUT</a>
                <a href="#" class="text-gray-800 hover:text-red-600 font-bold">ONLINE MENU</a>
                <a href="#" class="text-gray-800 hover:text-red-600 font-bold">CATEGORY</a>
                <a href="#" class="text-gray-800 hover:text-red-600 font-bold">GALLERY</a>
            </div>

            <!-- Mobile Navigation (Hamburger Menu) -->
            <div class="md:hidden">
                <button id="mobile-menu-toggle" class="text-red-600 focus:outline-none">
                    <i class="ri-menu-line w-6 h-6"></i> 
                </button>
            </div>

        </div>
    </div>

    <!-- Mobile Menu (Hidden by default) -->
    <div id="mobile-menu" class="md:hidden hidden bg-white shadow-md">
        <div class="container mx-auto py-4 px-6 space-y-4">
            <a href="/" class="block text-red-600 hover:text-red-700">HOME</a>
            <a href="/about" class="block text-gray-600 hover:text-red-600">ABOUT</a>
            <a href="#" class="block text-gray-600 hover:text-red-600">ONLINE MENU</a>
            <a href="#" class="block text-gray-600 hover:text-red-600">CATEGORY</a>
            <a href="#" class="block text-gray-600 hover:text-red-600">GALLERY</a>
        </div>
    </div>

    <main>
        @yield('content')
    </main>

    <!-- Footer Section -->
    <footer class="bg-[#2e211b] text-white py-8">
        <div class="container mx-auto px-4 mt-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Map Section -->
                <div>
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2436.9235423896794!2d-0.11954318413908667!3d51.50330821752643!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487604cbf7aa02f3%3A0xa752f5ebfdd3cf4!2slastminute.com%20London%20Eye!5e0!3m2!1sen!2suk!4v1603282368274!5m2!1sen!2suk"
                        width="100%" height="200" class="border-0 rounded" allowfullscreen=""
                        loading="lazy"></iframe>
                </div>
                <!-- Address Section -->
                <div>
                    <h3 class="text-yellow-400 font-bold text-lg mb-4">Address</h3>
                    <p>96 East Central Park Road,</p>
                    <p>New York, USA</p>
                </div>
                <!-- Details Section -->
                <div>
                    <h3 class="text-yellow-400 font-bold text-lg mb-4">Details</h3>
                    <p>Menu</p>
                    <p>Reservations</p>
                    <p>Time</p>
                </div>
                <!-- Contact Section -->
                <div>
                    <h3 class="text-yellow-400 font-bold text-lg mb-4">Contact Us</h3>
                    <p>9811100000</p>
                    <p>SherpaFoodnBar@gmail.com</p>
                </div>
            </div>
            <!-- Footer Bottom -->
            <div class="mt-8 border-t border-gray-600 pt-4 text-center">
                <p class="text-sm">
                    &copy; 2024 SherpaFoodnBar. All Rights Reserved.
                </p>
                <div class="flex justify-center space-x-4 mt-4">
                    <a href="#" class="text-gray-500 hover:text-blue-400">
                        <i class="ri-facebook-circle-fill text-2xl"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-blue-400">
                        <i class="ri-linkedin-fill text-2xl"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-blue-400">
                        <i class="ri-twitter-x-fill text-2xl"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>


    <script>
        // Mobile Menu Toggle
        document.getElementById('mobile-menu-toggle').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>

</body>

</html>
