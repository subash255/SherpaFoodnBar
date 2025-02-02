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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <!-- Navbar - Contact Info (Top Bar) -->
    <div class="bg-red-500 text-white text-xs sm:text-sm">
        <div class="container mx-auto flex justify-between items-center py-2 px-4">
            <!-- Contact Information -->
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2 border-r-2 h-5 pr-4 border-gray-300">
                    <i class="ri-phone-fill text-gray-700 text-xl"></i>
                    <span>9800001111</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="ri-mail-open-fill text-gray-100 text-xl"></i>
                    <a href="mailto:SherpaFoodnBar@gmail.com">SherpaFoodnBar@gmail.com</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navbar (Logo & Navigation) -->
    <div class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center px-6">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="/"> <img src="{{ asset('images/logo.jpg') }}" alt="Sherpa Food & Bar Logo" class="h-16 sm:h-20"></a>
            </div>
    
            <!-- Navigation Links -->
            <div  class="hidden md:flex items-center space-x-6 text-sm font-medium">
                <a href="{{route('welcome')}}" class=" hover:text-red-600 font-bold  {{ request()->routeIs('welcome') ? 'text-red-600' : 'text-gray-800' }}">HOME</a>
                <a href="{{ route('about') }}" class=" hover:text-red-600 font-bold {{ request()->routeIs('about') ? 'text-red-600' : 'text-gray-800' }}">ABOUT US</a>
                <a href="{{route('menu.index')}}" class="text-gray-800 hover:text-red-600 font-bold {{ request()->routeIs('menu.index') ? 'text-red-600' : 'text-gray-800' }}">MENU</a>
                <a href="{{ route('welcome') }}#reservation" class="text-gray-800 hover:text-red-600 font-bold">RESERVATION</a>
            {{-- <a href="#" class="text-gray-800 hover:text-red-600 font-bold">GALLERY</a> --}}
            <a href="{{route('contact')}}" class="text-gray-800 hover:text-red-600 font-bold  {{ request()->routeIs('contact') ? 'text-red-600' : 'text-gray-800' }}">CONTACT US</a>
                <!-- Cart Icon with Remix Icon -->
    <a href="{{route('cart.index')}}" class="text-gray-800 hover:text-red-600 font-bold ">
        
        <i class="ri-shopping-cart-line text-2xl"></i> 
        
    </a>
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
    <div id="mobile-menu" class="fixed top-16 right-0 bg-white shadow-md w-full sm:w-3/4 max-w-md h-full transform translate-x-full transition-transform duration-300 ease-in-out md:hidden z-50">
        <div class="flex justify-end p-4">
            <button id="close-menu" class="text-red-600 focus:outline-none">
                <i class="ri-close-line w-6 h-6"></i>
            </button>
        </div>
        <div class="flex flex-col items-start space-y-6 pt-8 h-full px-6">
            <!-- Menu Items aligned to the top -->

            <a href="{{route('welcome')}}" class=" text-2xl hover:text-red-700 font-semibold {{ request()->routeIs('welcome') ? 'text-red-600' : 'text-gray-800' }}">HOME</a>
            <a href="{{route('about')}}" class=" text-2xl hover:text-red-600 font-semibold {{ request()->routeIs('about') ? 'text-red-600' : 'text-gray-800' }}">ABOUT US</a>
            <a href="{{route('menu.index')}}" class="text-gray-800 text-2xl hover:text-red-600 font-semibold {{ request()->routeIs('menu.index') ? 'text-red-600' : 'text-gray-800' }}">MENU</a>
            <a href="{{ route('welcome') }}#reservation" class="text-gray-800 text-2xl hover:text-red-600 font-semibold">RESERVATION</a>
            <a href="#" class="text-gray-800 text-2xl hover:text-red-600 font-semibold">GALLERY</a>
            <a href="{{route('contact')}}" class="text-gray-800 text-2xl hover:text-red-600 font-semibold {{ request()->routeIs('contact') ? 'text-red-600' : 'text-gray-800' }}">CONTACT US</a>
                <!-- Cart Icon with Remix Icon -->
    <a href="{{route('cart.index')}}" class="text-gray-800 text-2xl hover:text-red-600 font-semibold flex items-center space-x-2">
        <!-- Cart Icon (Remix Icon) -->
        <i class="ri-shopping-cart-line text-2xl"></i> 
        <span>CART</span>
    </a>

        </div>
    </div>
    <main>
        @yield('content')
    </main>

<!-- Footer Section -->
<footer class="bg-[#2e211b] text-white py-8">
    <div class="container mx-auto px-4 mt-5">
        <div class="flex flex-wrap justify-evenly gap-8">
            <!-- Map Section -->
            <div class="flex-1 min-w-[250px] p-4">
                <iframe 
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2436.9235423896794!2d-0.11954318413908667!3d51.50330821752643!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487604cbf7aa02f3%3A0xa752f5ebfdd3cf4!2slastminute.com%20London%20Eye!5e0!3m2!1sen!2suk!4v1603282368274!5m2!1sen!2suk" 
                  class="w-full h-48 sm:h-40 md:h-48 lg:h-48 xl:h-48 border-0 rounded" 
                  allowfullscreen="" 
                  loading="lazy">
                </iframe>
              </div>
              
            <!-- Address Section -->
            <div class="flex-1 min-w-[250px] p-4">
                <h3 class="text-yellow-400 font-extrabold text-lg mb-4">Contact Us</h3>
                <ul class="space-y-4">
                    
                    <li class="flex items-start space-x-3"> 
                        <i class="ri-phone-line text-yellow-400 text-xl"></i>
                        <a href="tel:9800001111" class="text-white font-semibold hover:text-red-500">9800001111</a>
                    </li>
                    
                    <!-- Email with Icon -->
                    <li class="flex items-start space-x-3"> 
                        <i class="ri-mail-line text-yellow-400 text-xl"></i>
                        <a href="mailto:SherpaFoodnBar@gmail.com" class="text-white font-semibold hover:text-red-500">SherpaFoodnBar@gmail.com</a>
                    </li>
                    
                    <!-- Address with Icon -->
                    <li class="flex items-start space-x-3"> 
                        <i class="ri-map-pin-line text-yellow-400 text-xl"></i>
                        <p class="text-white font-semibold">96 East Central Park Road,<br class="sm:hidden"/> New York, USA</p> <!-- Break line for mobile view -->
                    </li>
                </ul>
            </div>
            
            
            
            <!-- Quick Links Section -->
            <div class="flex-1 min-w-[250px] p-4">
                <h3 class="text-yellow-400 font-extrabold text-lg mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{route('welcome')}}" class="text-white hover:text-red-500 font-semibold">Home</a>
                    </li>
                    <li>
                        <a href="{{route('about')}}" class="text-white hover:text-red-500 font-semibold">About Us</a>
                    </li>
                    {{-- <li>
                        <a href="#" class="text-white hover:text-red-500 font-semibold">Menu</a>
                    </li> --}}
                    <li>
                        <a href="#" class="text-white hover:text-red-500 font-semibold">Gallery</a>
                    </li>
                    <li>
                        <a href="{{route('login')}}" class="text-white hover:text-red-500 font-semibold">Admin Login</a>
                    </li>
                </ul>
            </div>
            
            <!-- Social Links Section -->
            <div class="flex-1 min-w-[250px] p-4">
                <h3 class="text-yellow-400 font-extrabold text-lg mb-4">Follow Us</h3>
                <div class="flex space-x-4">
                    <a href="#" class="bg-white w-12 h-12 flex items-center justify-center rounded-full text-orange-800">
                        <i class="ri-facebook-fill text-2xl"></i>
                    </a>
                    <a href="#" class="bg-white w-12 h-12 flex items-center justify-center rounded-full text-orange-800">
                        <i class="ri-instagram-fill text-2xl"></i>
                    </a>
                    <a href="#" class="bg-white w-12 h-12 flex items-center justify-center rounded-full text-orange-800">
                        <i class="ri-twitter-x-fill text-2xl"></i>
                    </a>
                </div>
            </div>
            
        </div>
        <!-- Footer Bottom (Copyright) -->
        <div class="mt-8 border-t border-gray-600 pt-4 text-center">
            <p class="text-sm">
                &copy; 2024 SherpaFoodnBar. All Rights Reserved.
            </p>
        </div>
    </div>
</footer>


<script>
    // Mobile Menu Toggle
    document.getElementById('mobile-menu-toggle').addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        // Toggle the mobile menu with animation
        menu.classList.toggle('translate-x-full');
        menu.classList.toggle('translate-x-0');
    });

    // Close Menu Button
    document.getElementById('close-menu').addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        // Close the mobile menu
        menu.classList.add('translate-x-full');
        menu.classList.remove('translate-x-0');
    });

    // Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault(); // Prevent the default action

        // Get the target section to scroll to
        const targetId = this.getAttribute('href').substring(1);
        const targetElement = document.getElementById(targetId);

        if (targetElement) {
            targetElement.scrollIntoView({
                behavior: 'smooth', // Smooth scrolling
                block: 'start'      // Scroll to the top of the element
            });
        }
    });
});

// Close the mobile menu after clicking an anchor link
document.querySelectorAll('#mobile-menu a').forEach(anchor => {
    anchor.addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.add('translate-x-full');
        menu.classList.remove('translate-x-0');
    });
});

</script>


<!-- Swiper Script -->
<script>
    // Initialize Swiper
    var swiper = new Swiper('.swiper-container', {
        loop: true,                // Loop the slides
      slidesPerView: 3,          // Default for larger screens
      spaceBetween: 20,          // Space between slides
      autoplay: {
        delay: 3000,             // 3 seconds
        disableOnInteraction: false,  // Keep autoplay after user interaction
      },
      pagination: {
        el: '.swiper-pagination', // The container for the dots
        clickable: true,          // Make the dots clickable
      },
      breakpoints: {
        320: {                   // For very small screens (mobile)
          slidesPerView: 1,      // Show 1 slide on very small screens
          spaceBetween: 10,      // Smaller space between slides
        },
        480: {                   // For small screens (larger mobile, tablet portrait)
          slidesPerView: 1,      // Show 1 slide
          spaceBetween: 15,
        },
        640: {
          slidesPerView: 2,      // Show 2 slides for small tablets
          spaceBetween: 15,
        },
        768: {
          slidesPerView: 2,      // Show 2 slides for larger mobile/tablets
          spaceBetween: 20,
        },
        1024: {
          slidesPerView: 3,      // Show 3 slides for laptops and larger devices
          spaceBetween: 20,
        },
      }
    });
</script>


</body>

</html>
