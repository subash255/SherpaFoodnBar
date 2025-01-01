@extends('layouts.master')
@section('content')
<!-- Hero Section -->
<section class="relative bg-cover bg-center h-screen" style="background-image: url('{{ asset('images/bg.jpg') }}');">
  <div class="absolute inset-0 bg-black opacity-75"></div> <!-- Darker overlay -->
  <div class="relative z-10 flex items-center justify-center h-full text-center text-white">
    <div class="px-4 md:px-8"> <!-- Adds padding on larger screens, reduces on mobile -->
      <!-- Responsive Heading and Subheading -->
      <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold leading-tight mb-4 sm:mb-6">
        Welcome to Sherpa Food N' Bar
      </h1>
      <p class="text-lg sm:text-xl md:text-2xl mb-8 sm:mb-10">
        Enjoy exquisite meals and drinks in a cozy atmosphere
      </p>

      <!-- Button container with flexbox and responsiveness -->
      <div class="flex flex-col sm:flex-row justify-evenly sm:space-x-4 space-y-6 sm:space-y-0"> <!-- Increased space-y on mobile -->
        <a href="#menu" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded-full text-lg transition-all transform hover:scale-102 hover:translate-y-0.5 duration-300 ease-in-out">
          Lunch Menu
        </a>
        <a href="#delivery" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded-full text-lg transition-all transform hover:scale-102 hover:translate-y-0.5 duration-300 ease-in-out">
          Home Delivery/Takeaway
        </a>
        <a href="#reservation" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded-full text-lg transition-all transform hover:scale-102 hover:translate-y-0.5 duration-300 ease-in-out">
          Reserve a Table
        </a>
      </div>
    </div>
  </div>
</section>




<!-- Swiper Slider -->
<h1 class="text-4xl font-extrabold text-center my-10 text-gray-900">Our Menus</h1>

<div class="swiper swiper-container mx-auto mt-10 max-w-7xl px-4">
  <div class="swiper-wrapper">
    
    <!-- Product 1 -->
   <div class="swiper-slide flex flex-col items-center justify-center p-4 mb-6 bg-white rounded-lg shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 ease-in-out">
    <a href="{{route('menu.index')}}"> <img src="{{ asset('images/rolls.jpg') }}" alt="Starters" class="w-52 h-52 object-cover rounded-lg mb-4">
      <div class="product-name text-xl font-semibold text-gray-900">Starters</div> </a>
    </div>

    <!-- Product 2 -->
    <div class="swiper-slide flex flex-col items-center justify-center p-4 mb-6 bg-white rounded-lg shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 ease-in-out">
      <img src="{{ asset('images/chow.jpg') }}" alt="Ready To be Served" class="w-52 h-52 object-cover rounded-lg mb-4">
      <div class="product-name text-xl font-semibold text-gray-900">Ready To be Served</div>
    </div>

    <!-- Product 3 -->
    <div class="swiper-slide flex flex-col items-center justify-center p-4 mb-6 bg-white rounded-lg shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 ease-in-out">
      <img src="{{ asset('images/mango.jpg') }}" alt="Deserts" class="w-52 h-52 object-cover rounded-lg mb-4">
      <div class="product-name text-xl font-semibold text-gray-900">Deserts</div>
    </div>

    <!-- Product 4 -->
    <div class="swiper-slide flex flex-col items-center justify-center p-4 mb-6 bg-white rounded-lg shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 ease-in-out">
      <img src="{{ asset('images/momo.png') }}" alt="Momo" class="w-52 h-52 object-cover rounded-lg mb-4">
      <div class="product-name text-xl font-semibold text-gray-900">Momo</div>
    </div>

    <!-- Product 5 -->
    <div class="swiper-slide flex flex-col items-center justify-center p-4 mb-6 bg-white rounded-lg shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 ease-in-out">
      <img src="{{ asset('images/thukpa.jpg') }}" alt="Thukpa and Soup" class="w-52 h-52 object-cover rounded-lg mb-4">
      <div class="product-name text-xl font-semibold text-gray-900">Thukpa and Soup</div>
    </div>

    <!-- Product 6 -->
    <div class="swiper-slide flex flex-col items-center justify-center p-4 mb-6 bg-white rounded-lg shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 ease-in-out">
      <img src="{{ asset('images/beer.jpg') }}" alt="Drinks" class="w-52 h-52 object-cover rounded-lg mb-4">
      <div class="product-name text-xl font-semibold text-gray-900">Drinks</div>
    </div>
    
  </div>

  <!-- Navigation Buttons -->
  <div class="swiper-button-next bg-indigo-600 text-white p-3 rounded-full shadow-md hover:bg-indigo-700 transform transition duration-300 ease-in-out">
    <i class="fas fa-chevron-right text-xl"></i>
  </div>
  <div class="swiper-button-prev bg-indigo-600 text-white p-3 rounded-full shadow-md hover:bg-indigo-700 transform transition duration-300 ease-in-out">
    <i class="fas fa-chevron-left text-xl"></i>
  </div>
</div> 


 <!-- Table Reservation Section -->
<section id="reservation" class="relative py-20 text-center text-white bg-cover bg-center mt-10" style="background-image: url('{{ asset('images/table.jpg') }}');">
  <!-- Black Overlay -->
  <div class="absolute inset-0 bg-black opacity-50"></div> <!-- Darker overlay -->

  <div class="relative z-10">
    <h2 class="text-3xl font-semibold mb-6">Reserve a Table</h2>
    <p class="text-lg mb-8">Book a table now and enjoy a fantastic dining experience.</p>
    <form action="#" class="max-w-lg mx-auto">
      <div class="mb-4">
        <input type="text" placeholder="Your Name" class="w-full p-3 border border-gray-300 rounded-md text-gray-700">
      </div>
      <div class="mb-4">
        <input type="number" placeholder="Number of People" class="w-full p-3 border border-gray-300 rounded-md text-gray-700">
      </div>
      <div class="mb-4">
        <input type="datetime-local" class="w-full p-3 border border-gray-300 rounded-md text-gray-700">
      </div>
      <button type="submit" class="bg-white hover:bg-gray-200 text-indigo-600 py-2 px-6 rounded-md text-lg">Book Now</button>
    </form>
  </div>
</section>



<!-- Food Ordering Section -->
<section id="order" class="py-20 bg-gray-50 text-center">
  <h2 class="text-4xl font-bold text-gray-900 mb-6">Customer Favorites</h2>
  <p class="text-lg text-gray-600 mb-12">Discover the Flavors Everyone's Raving About Today!</p>
  
  <!-- Grid Layout for Menu Items -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12 max-w-7xl mx-auto px-4">
    
    <!-- Menu Item 1: Jhol Momo -->
    <div class="bg-white p-6 rounded-xl shadow-xl hover:shadow-2xl transition-transform transform hover:scale-105">
      <img src="{{ asset('images/momo.png') }}" alt="Jhol Momo" class="w-full h-56 object-cover rounded-lg mb-6 transition-all duration-500 ease-in-out hover:opacity-90">
      <h3 class="text-2xl font-semibold text-gray-800 mb-2">Jhol Momo</h3>
      <p class="text-lg text-gray-600 mb-4">$15.00</p>
      <button class="bg-indigo-600 text-white py-3 px-8 rounded-lg text-lg font-semibold transition-all duration-300 transform hover:bg-indigo-700 hover:scale-105">
        Order Now
      </button>
    </div>

    <!-- Menu Item 2: Cocktail Specials -->
    <div class="bg-white p-6 rounded-xl shadow-xl hover:shadow-2xl transition-transform transform hover:scale-105">
      <img src="{{ asset('images/beer.jpg') }}" alt="Cocktail Specials" class="w-full h-56 object-cover rounded-lg mb-6 transition-all duration-500 ease-in-out hover:opacity-90">
      <h3 class="text-2xl font-semibold text-gray-800 mb-2">Cocktail Specials</h3>
      <p class="text-lg text-gray-600 mb-4">$10.00</p>
      <button class="bg-indigo-600 text-white py-3 px-8 rounded-lg text-lg font-semibold transition-all duration-300 transform hover:bg-indigo-700 hover:scale-105">
        Order Now
      </button>
    </div>

    <!-- Menu Item 3: Chowmeen -->
    <div class="bg-white p-6 rounded-xl shadow-xl hover:shadow-2xl transition-transform transform hover:scale-105">
      <img src="{{ asset('images/chow.jpg') }}" alt="Chowmeen" class="w-full h-56 object-cover rounded-lg mb-6 transition-all duration-500 ease-in-out hover:opacity-90">
      <h3 class="text-2xl font-semibold text-gray-800 mb-2">Chowmeen</h3>
      <p class="text-lg text-gray-600 mb-4">$12.00</p>
      <button class="bg-indigo-600 text-white py-3 px-8 rounded-lg text-lg font-semibold transition-all duration-300 transform hover:bg-indigo-700 hover:scale-105">
        Order Now
      </button>
    </div>
  </div>
</section>




@endsection
