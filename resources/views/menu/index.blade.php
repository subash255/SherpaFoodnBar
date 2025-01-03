@extends('layouts.master')
@section('content')

<body class="bg-gray-100">
    <!-- Header with Tabs -->
    {{-- <div class="bg-white shadow-sm sticky top-0 z-10">
    <div class="flex overflow-x-auto space-x-2 p-4 bg-white">
        <button class="px-2 py-2 text-white bg-red-500 rounded-full">ALKURUOAT</button>
        <button class="px-2 py-2 border border-red-500 text-red-500 rounded-full">TANDOORIRUOAT</button>
        <button class="px-2 py-2 border border-red-500 text-red-500 rounded-full">KANARUOAT</button>
        <button class="px-2 py-2 border border-red-500 text-red-500 rounded-full">LAMMASRUOAT</button>
        <button class="px-2 py-2 border border-red-500 text-red-500 rounded-full">MERENANTIMET</button>
        <button class="px-2 py-2 border border-red-500 text-red-500 rounded-full">KASVISRUOAT</button>
        <button class="px-2 py-2 border border-red-500 text-red-500 rounded-full">VEGANRUOAT</button>
        <button class="px-2 py-2 border border-red-500 text-red-500 rounded-full">BIRYANI/NOODLES</button>
        <button class="px-2 py-2 border border-red-500 text-red-500 rounded-full">LASTEN RUOAT</button>
    </div>
</div> --}}

<!-- Filter Sidebar and Content -->
<div class="container mx-auto p-4 flex flex-col lg:flex-row space-y-4 lg:space-y-0 lg:space-x-4">
    <!-- Filter Sidebar -->
    <aside class="w-full lg:w-1/4 bg-white shadow-md rounded-lg p-4">
        <h2 class="text-lg font-bold text-orange-600 mb-4">Menus Categories</h2>
        <div class="mb-4 flex">
            <!-- Search Input -->
            <input type="text" placeholder="Search by dish name"
                class="w-full border rounded-l-lg px-3 py-2 focus:ring-2 focus:ring-orange-500" />

            <!-- Search Button -->
            <button class="bg-orange-500 text-white py-2 px-4 rounded-r-lg hover:bg-orange-600 focus:outline-none">
                Search
            </button>
        </div>

        <ul class="space-y-2 text-sm">
            <li><button class="w-full text-left px-4 py-2 rounded bg-orange-500 text-white">STARTERS</button></li>
            <li><button class="w-full text-left px-4 py-2 border rounded">TANDOOR DISH</button></li>
            <li><button class="w-full text-left px-4 py-2 border rounded">CHICKEN DISH</button></li>
            <li><button class="w-full text-left px-4 py-2 border rounded">LAMB DISHES</button></li>
            <li><button class="w-full text-left px-4 py-2 border rounded">SEA FOODS</button></li>
            <li><button class="w-full text-left px-4 py-2 border rounded">VEGETABLE DISHES</button></li>
            <li><button class="w-full text-left px-4 py-2 border rounded">VEGAN DISHES</button></li>
            <li><button class="w-full text-left px-4 py-2 border rounded">BIRYANI/NOODLES</button></li>
            <li><button class="w-full text-left px-4 py-2 border rounded">CHILDREN DISHES</button></li>
        </ul>
        <div class="mt-4 space-y-2">
            <label class="flex items-center space-x-2">
                <input type="radio" name="filter" class="text-orange-500">
                <span>Veg</span>
            </label>
            <label class="flex items-center space-x-2">
                <input type="radio" name="filter" class="text-orange-500">
                <span>Non-Veg</span>
            </label>
        </div>
    </aside>

    <!-- Menu Items -->
    <div class="w-full lg:w-3/4">
        <h2 class="text-2xl text-center mt-4 font-bold text-green-600 mb-4">STARTERS</h2>
        <div class="space-y-4">
            <!-- Menu Item -->
            <div class="flex flex-col sm:flex-row items-center bg-white rounded-lg shadow p-4">
                <!-- Image Section -->
                <div class="flex-shrink-0">
                    <img src="{{asset('images/samosa.jpg')}}" alt="Samosa" class="w-24 h-24 object-cover rounded-lg">
                </div>
                <!-- Text and Price Section -->
                <div class="ml-6 flex-grow">
                    <h3 class="text-lg font-bold">SAMOSA</h3>
                    <p class="text-sm text-gray-500">Vegetable Samosa 2 pieces served with chutney and salad.</p>
                    <p class="text-lg font-bold text-gray-800 mt-2">€6.90</p>
                </div>
                <!-- Button Section -->
                <div class="flex items-center justify-center mt-4 sm:mt-0 sm:ml-4">
                    <button class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-6 py-2 rounded">Add to Cart</button>
                </div>
            </div>
            
            <!-- Another Menu Item -->
            <div class="flex flex-col sm:flex-row items-center bg-white rounded-lg shadow p-4">
                <!-- Image Section -->
                <div class="flex-shrink-0">
                    <img src="{{asset('images/momo.png')}}" alt="Tareko Momo" class="w-24 h-24 object-cover rounded-lg">
                </div>
                <!-- Text and Price Section -->
                <div class="ml-6 flex-grow">
                    <h3 class="text-lg font-bold">TAREKO MOMO</h3>
                    <p class="text-sm text-gray-500">Deep fried minced mutton meat dumplings served with chutney and salad.</p>
                    <p class="text-lg font-bold text-gray-800 mt-2">€6.90</p>
                </div>
                <!-- Button Section -->
                <div class="flex items-center justify-center mt-4 sm:mt-0 sm:ml-4">
                    <button class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-6 py-2 rounded">Add to Cart</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
