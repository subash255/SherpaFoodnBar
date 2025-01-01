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




  <!-- Menu Section -->
  <section id="menu" class="py-20 bg-white text-center">
    <h2 class="text-3xl font-semibold mb-6">Our Menu</h2>
    <p class="text-lg mb-8">Explore our delicious food and drink offerings</p>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto px-4">
      <!-- Food Item 1 -->
      <div class="bg-white p-6 rounded-lg shadow-lg">
        <img src="https://example.com/food1.jpg" alt="Food 1" class="w-full h-64 object-cover rounded-lg mb-4">
        <h3 class="text-xl font-semibold mb-2">Signature Burger</h3>
        <p class="text-gray-600 mb-4">$15.00</p>
        <p class="text-gray-600">A juicy, delicious burger with fresh ingredients.</p>
      </div>
      <!-- Food Item 2 -->
      <div class="bg-white p-6 rounded-lg shadow-lg">
        <img src="https://example.com/food2.jpg" alt="Food 2" class="w-full h-64 object-cover rounded-lg mb-4">
        <h3 class="text-xl font-semibold mb-2">Caesar Salad</h3>
        <p class="text-gray-600 mb-4">$12.00</p>
        <p class="text-gray-600">Crisp romaine lettuce with parmesan and a creamy dressing.</p>
      </div>
      <!-- Food Item 3 -->
      <div class="bg-white p-6 rounded-lg shadow-lg">
        <img src="https://example.com/food3.jpg" alt="Food 3" class="w-full h-64 object-cover rounded-lg mb-4">
        <h3 class="text-xl font-semibold mb-2">Cocktail Specials</h3>
        <p class="text-gray-600 mb-4">$10.00</p>
        <p class="text-gray-600">Enjoy our signature cocktails, crafted by expert mixologists.</p>
      </div>
    </div>
  </section>

  <!-- Table Reservation Section -->
  <section id="reservation" class="py-20 bg-indigo-600 text-center text-white">
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
  </section>

  <!-- Food Ordering Section -->
  <section id="order" class="py-20 bg-white text-center">
    <h2 class="text-3xl font-semibold mb-6">Order Food & Drinks</h2>
    <p class="text-lg mb-8">Order your favorite dishes and drinks online and have them delivered to your table.</p>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto px-4">
      <div class="bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-xl font-semibold mb-2">Signature Burger</h3>
        <p class="text-gray-600 mb-4">$15.00</p>
        <button class="bg-indigo-600 text-white py-2 px-4 rounded-md">Order Now</button>
      </div>
      <div class="bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-xl font-semibold mb-2">Cocktail Specials</h3>
        <p class="text-gray-600 mb-4">$10.00</p>
        <button class="bg-indigo-600 text-white py-2 px-4 rounded-md">Order Now</button>
      </div>
      <div class="bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-xl font-semibold mb-2">Caesar Salad</h3>
        <p class="text-gray-600 mb-4">$12.00</p>
        <button class="bg-indigo-600 text-white py-2 px-4 rounded-md">Order Now</button>
      </div>
    </div>
  </section>

  <!-- About Section -->
  <section id="about" class="py-20 bg-gray-100 text-center">
    <h2 class="text-3xl font-semibold mb-6">About Us</h2>
    <p class="text-lg max-w-2xl mx-auto text-gray-700 mb-8">Our bar and restaurant offer the perfect blend of great food, drinks, and an inviting atmosphere. Whether you're celebrating a special occasion or just relaxing, we provide an unforgettable experience.</p>
  </section>

@endsection
