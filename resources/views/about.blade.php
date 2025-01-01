@extends('layouts.master')
@section('content')

  <!-- Hero Section -->
  <section class="relative bg-cover bg-center h-96" style="background-image: url('{{ asset('images/bg.jpg') }}');">
    <div class="absolute inset-0 bg-black opacity-70"></div>
    <div class="relative z-10 flex flex-col justify-center items-center h-full text-center text-white px-6">
        <h1 class="text-5xl font-bold mb-4">Experience Fine Dining & Craft Cocktails</h1>
        <p class="text-xl mb-10">Indulge in a blend of exquisite flavors and an unforgettable atmosphere.</p>
        <a href="{{route('menu.index')}}" class="bg-yellow-500 text-black py-3 px-6 rounded-full text-xl font-semibold hover:bg-yellow-400 transition duration-300">Discover Our Menu</a>
    </div>
</section>

<!-- About Section -->
<section class="py-16 px-6 bg-white">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-4xl font-bold text-gray-800 text-center mb-8">About Us</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Left Column: Mission -->
            <div class="space-y-6 mt-4">
                <p class="text-lg text-gray-600 leading-relaxed">
                    Founded in 2024, Sherpa Food & Bar began as a vision to create a space where food lovers and cocktail enthusiasts could unite. Whether for a casual meal or special occasion, we invite you to savor flavors from around the world.
                </p>
                  
                  <p class="text-lg text-gray-600 leading-relaxed mt-4">
                    Our mission is to provide a space where every visit feels like a celebration. The ambiance at Sherpa Food & Bar strikes the perfect balance between cozy comfort and sophisticated elegance, offering the ideal setting for everything from intimate dinners to lively nights out with friends. Our team is passionate about delivering exceptional service, ensuring that every moment spent with us is one you'll remember.
                  </p>
            </div>

            <!-- Right Column: Image -->
            <div class="relative">
                <img src="{{ asset('images/about1.jpg') }}" alt="Food & Drink" class="rounded-lg shadow-lg w-full h-full object-cover">
            </div>
        </div>
    </div>
</section>


<!-- Ambiance Section -->
<section class="py-16 px-6">
    <div class="max-w-7xl mx-auto text-center">
        <h3 class="text-4xl font-bold text-gray-800 text-center mb-8">Our Ambiance</h3>
        <p class="text-lg text-gray-600 leading-relaxed mb-8">The ambiance at Sherpa Food & Bar is designed to make you feel right at home. With a balance of rustic charm and modern elegance, our space features comfortable seating, warm lighting, and an inviting atmosphere. Whether you're here for a casual meal with friends or a romantic date night, we provide the perfect setting for every occasion.</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="relative">
                <img src="{{ asset('images/inte.jpg') }}" alt="Restaurant Interior" class="rounded-lg shadow-xl w-full h-full object-cover">
            </div>
            <div class="relative">
                <img src="{{ asset('images/coc.jpg') }}" alt="Cocktail Bar" class="rounded-lg shadow-xl w-full h-full object-cover">
            </div>
        </div>
    </div>
</section>


@endsection