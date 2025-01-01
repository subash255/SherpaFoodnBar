@extends('layouts.master')
@section('content')

  <!-- Hero Section -->
  <section class="relative bg-cover bg-center h-96" style="background-image: url('https://source.unsplash.com/1600x900/?restaurant,food');">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="relative z-10 flex flex-col justify-center items-center h-full text-center text-white px-6">
        <h1 class="text-5xl font-bold mb-4">Experience Fine Dining & Craft Cocktails</h1>
        <p class="text-xl mb-6">Indulge in a blend of exquisite flavors and an unforgettable atmosphere.</p>
        <a href="/menu" class="bg-yellow-500 text-black py-3 px-6 rounded-full text-xl font-semibold hover:bg-yellow-400 transition duration-300">Discover Our Menu</a>
    </div>
</section>

<!-- About Section -->
<section class="py-16 px-6 bg-white">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-4xl font-bold text-gray-800 text-center mb-8">About Us</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Left Column: Mission -->
            <div class="space-y-6">
                <h3 class="text-2xl font-semibold text-gray-800">Our Mission</h3>
                <p class="text-lg text-gray-600 leading-relaxed">At Food & Bar, we believe that dining is an experience—an opportunity to enjoy the best food, the finest drinks, and great company. Our mission is to offer a diverse selection of dishes paired with expertly crafted cocktails, all within a cozy yet sophisticated setting. We aim to make every meal memorable and every drink unforgettable.</p>
                <div class="text-center">
                    <a href="/menu" class="text-yellow-500 font-semibold hover:underline">Explore Our Menu</a>
                </div>
            </div>

            <!-- Right Column: Image -->
            <div class="relative">
                <img src="https://source.unsplash.com/800x600/?food,dining" alt="Food & Drink" class="rounded-lg shadow-lg w-full h-full object-cover">
            </div>
        </div>
    </div>
</section>

<!-- History Section -->
<section class="bg-gray-100 py-16">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h3 class="text-3xl font-semibold text-gray-800 mb-6">Our History</h3>
        <p class="text-lg text-gray-600 leading-relaxed mb-8">Founded in 2010, Food & Bar began as a dream to create a unique space where food lovers and cocktail enthusiasts could come together. What started as a small neighborhood restaurant quickly became a popular destination for both locals and visitors. Today, we continue to uphold our commitment to delivering high-quality dishes, creative cocktails, and exceptional service.</p>
        <div class="flex justify-center">
            <img src="https://source.unsplash.com/800x600/?restaurant,bar" alt="Bar Interior" class="rounded-lg shadow-xl w-full md:w-2/3">
        </div>
    </div>
</section>

<!-- Ambiance Section -->
<section class="py-16 px-6">
    <div class="max-w-7xl mx-auto text-center">
        <h3 class="text-3xl font-semibold text-gray-800 mb-6">Our Ambiance</h3>
        <p class="text-lg text-gray-600 leading-relaxed mb-8">The ambiance at Food & Bar is designed to make you feel right at home. With a balance of rustic charm and modern elegance, our space features comfortable seating, warm lighting, and an inviting atmosphere. Whether you're here for a casual meal with friends or a romantic date night, we provide the perfect setting for every occasion.</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="relative">
                <img src="https://source.unsplash.com/800x600/?restaurant,interior" alt="Restaurant Interior" class="rounded-lg shadow-xl w-full h-full object-cover">
            </div>
            <div class="relative">
                <img src="https://source.unsplash.com/800x600/?cocktail,bar" alt="Cocktail Bar" class="rounded-lg shadow-xl w-full h-full object-cover">
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="bg-black py-12 text-center text-white">
    <h3 class="text-3xl font-semibold mb-6">Join Us Today</h3>
    <p class="text-lg mb-8">Whether you're here for a special occasion or just a night out, Food & Bar is ready to serve you. Come experience our exceptional food, drinks, and ambiance.</p>
    <a href="/contact" class="bg-yellow-500 text-black py-3 px-6 rounded-full text-xl font-semibold hover:bg-yellow-400 transition duration-300">Contact Us</a>
</section>

@endsection