@extends('layouts.master')
@section('content')
<!-- Flash Messages (if any) -->
@if(session('success'))
    <div id="flash-message" class="bg-green-500 text-white px-6 py-2 rounded-lg fixed top-4 right-4 shadow-lg z-50">
        {{ session('success') }}
    </div>
@endif

<script>
  if (document.getElementById('flash-message')) {
      setTimeout(() => { 
          const msg = document.getElementById('flash-message'); 
          msg.style.opacity = 0; 
          msg.style.transition = "opacity 0.5s ease-out"; 
          setTimeout(() => msg.remove(), 500); 
      }, 3000);
  }
</script>

<!-- Hero Section -->
<section class="relative bg-cover bg-center h-screen" style="background-image: url('{{ asset('images/bg.jpg') }}');">
  <div class="absolute inset-0 bg-black opacity-75"></div> 
  <div class="relative z-10 flex items-center justify-center h-full text-center text-white">
    <div class="px-4 md:px-8"> 
     
      <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold leading-tight mb-4 sm:mb-6">
        Welcome to Sherpa Food N' Bar
      </h1>
      <p class="text-lg sm:text-xl md:text-2xl mb-8 sm:mb-10">
        Enjoy exquisite meals and drinks in a cozy atmosphere
      </p>

      <!-- Call to Action Buttons -->
      <div class="flex flex-col sm:flex-row sm:justify-center gap-5 sm:space-x-2 space-y-4 sm:space-y-0">
        <a href="#menu" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded-full text-lg transition-all transform hover:scale-102 hover:translate-y-0.5 duration-300 ease-in-out">
            Lunch Menu
        </a>
        <a href="#delivery" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded-full text-lg transition-all transform hover:scale-102 hover:translate-y-0.5 duration-300 ease-in-out">
            Home Delivery / Takeaway
        </a>
        <a href="#reservation" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded-full text-lg transition-all transform hover:scale-102 hover:translate-y-0.5 duration-300 ease-in-out">
            Reserve a Table
        </a>
    </div>
    
    </div>
  </div>
</section>


<!-- Swiper Slider -->
<h1 class="text-4xl font-extrabold text-center mt-10 mb-6 text-gray-900">Our Menus</h1>
<p class="text-lg text-gray-600 text-center mb-12">A Taste of Perfection in Every Bite.</p>
<div class="swiper swiper-container mx-auto mt-10 max-w-7xl px-4">
  <div class="swiper-wrapper">
<!-- Product 1 -->
@foreach($categories as $category)
<div class="swiper-slide flex flex-col items-center justify-center p-4 mb-6 bg-white rounded-lg shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 ease-in-out">
  <a href="{{ route('menu.index') }}">
      <img src="{{ asset('images/brand/' . $category->image) }}" alt="Starters" class="w-52 h-52 object-cover rounded-lg mb-4">
      <div class="product-name text-xl font-bold text-gray-900 text-center">{{ $category->name }}</div>
  </a>
</div>
@endforeach
    
    
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

  <div class="absolute inset-0 bg-black opacity-50"></div> 

  <div class="relative z-10">
    <h1 class="text-4xl font-extrabold mb-6">Reserve a Table</h1>
    <p class="text-lg mb-8">Book a table now and enjoy a fantastic dining experience.</p>
    <form action="{{ route('booking.store') }}" method="POST" class="max-w-lg mx-auto">
    @csrf
    <!-- Display error message -->
    @if(session('error'))
        <div class="bg-red-500 text-white p-4 mb-4 rounded-md">
            {{ session('error') }}
        </div>
    @endif

    <!-- Display success message -->
    @if(session('success'))
        <div class="bg-green-500 text-white p-4 mb-4 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4">
        <input type="text" name="name" placeholder="Your Name" class="w-full p-3 border border-gray-300 rounded-md text-gray-700" required>
    </div>
    <div class="mb-4">
        <input type="email" name="email" placeholder="Your email" class="w-full p-3 border border-gray-300 rounded-md text-gray-700" required>
    </div>
    <div class="mb-4">
        <input type="tel" name="phone" placeholder="Your number" class="w-full p-3 border border-gray-300 rounded-md text-gray-700" required>
    </div>
    <div class="mb-4">
        <input type="number" name="number_of_people" placeholder="Number of People" class="w-full p-3 border border-gray-300 rounded-md text-gray-700" required>
    </div>
    <div class="mb-4">
        <input type="datetime-local" name="booking_date" class="w-full p-3 border border-gray-300 rounded-md text-gray-700" required>
    </div>
    <button type="submit" class="bg-white hover:bg-gray-200 text-indigo-600 py-2 px-6 rounded-md text-lg">Book Now</button>
</form>

  </div>
</section>



<!-- Food Ordering Section -->
<section id="order" class="py-20 bg-gray-50 text-center">
  <h1 class="text-4xl font-extrabold text-gray-900 mb-6">Customer Favorites</h1>
  <p class="text-lg text-gray-600 mb-12">Discover the Flavors Everyone's Raving About Today!</p>
  
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12 max-w-7xl mx-auto px-4">
    
    <!-- Menu Item 1: Jhol Momo -->
    @foreach($fooditems as $fooditem)
    @if($fooditem->status == 1)
    <div class="bg-white p-6 rounded-xl shadow-xl hover:shadow-2xl transition-transform transform hover:scale-105">
      <!-- Dynamically displaying the food item's image -->
      <img src="{{ asset('images/fooditem/'.$fooditem->image) }}" alt="{{ $fooditem->name }}" class="w-full h-56 object-cover rounded-lg mb-6 transition-all duration-500 ease-in-out hover:opacity-90">
      
      <!-- Dynamically displaying the food item's name -->
      <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $fooditem->name }}</h3>
      
      <!-- Dynamically displaying the food item's price -->
      <p class="text-lg text-gray-600 mb-4">${{ number_format($fooditem->price, 2) }}</p>
      
      <!-- Order button -->
      <button class="bg-indigo-600 text-white py-3 px-8 rounded-lg text-lg font-semibold transition-all duration-300 transform hover:bg-indigo-700 hover:scale-105">
        Order Now
      </button>
    </div>
    @endif
@endforeach


  </div>
</section>




@endsection
