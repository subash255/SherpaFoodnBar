@extends('layouts.app')
@section('content')

    <!-- Cards Section -->
    <div class="relative z-[10] grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-[10rem] px-6">
        <!-- Pending Orders Card -->
        <div class="bg-white p-6 text-left hover:shadow-2xl flex flex-row items-center justify-between w-full h-20 rounded-lg transform sm:-translate-y-8 lg:-translate-y-12 shadow-lg z-[5]">
            <div>
                <h2 class="text-gray-700 font-medium">Pending Orders</h2>
                <p class="text-gray-700 font-medium">1</p>
            </div>
            <div class="bg-yellow-500 text-white w-12 h-12 flex items-center justify-center rounded-full">
                <i class="ri-time-line text-2xl"></i>
            </div>
        </div>

        <!-- Processing Orders Card -->
        <div class="bg-white p-6 rounded-lg text-left hover:shadow-2xl transition-shadow duration-300 flex flex-row items-center justify-between w-full h-20 transform sm:-translate-y-8 lg:-translate-y-12 shadow-lg">
            <div>
                <h2 class="text-gray-700 font-medium mb-2">Total Reservations</h2>
                <p class="text-gray-700 font-medium">1</p>
            </div>
            <div class="bg-yellow-600 text-white w-12 h-12 flex items-center justify-center rounded-full">
                <i class="ri-calendar-check-fill text-2xl"></i>
            </div>
        </div>

        <!-- Income Card -->
        <div class="bg-white p-6 rounded-lg text-left hover:shadow-2xl transition-shadow duration-300 flex flex-row items-center justify-between w-full h-20 transform sm:-translate-y-8 lg:-translate-y-12 shadow-lg">
            <div>
                <h2 class="text-gray-700 font-medium mb-2">Income</h2>
                <p class="text-gray-700 font-medium">$400</p>
            </div>
            <div class="bg-purple-600 text-white w-12 h-12 flex items-center justify-center rounded-full">
                <i class="ri-money-dollar-circle-fill text-2xl"></i>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="bg-white p-6 rounded-lg text-left hover:shadow-2xl transition-shadow duration-300 flex flex-row items-center justify-between w-full h-20 transform sm:-translate-y-4 lg:-translate-y-8 shadow-lg">
            <div>
                <h2 class="text-gray-700 font-medium mb-2">Orders</h2>
                <p class="text-gray-700 font-medium">142</p>
            </div>
            <div class="bg-green-500 text-white w-12 h-12 flex items-center justify-center rounded-full">
                <i class="ri-shopping-cart-fill text-2xl"></i>
            </div>
        </div>

        <!-- Revenue Card -->
        <div class="bg-white p-6 rounded-lg text-left hover:shadow-2xl transition-shadow duration-300 flex flex-row items-center justify-between w-full h-20 transform sm:-translate-y-4 lg:-translate-y-8 shadow-lg">
            <div>
                <h2 class="text-gray-700 font-medium mb-2">Revenue</h2>
                <p class="text-gray-700 font-medium">100</p>
            </div>
            <div class="bg-blue-500 text-white w-12 h-12 flex items-center justify-center rounded-full">
                <i class="ri-money-dollar-circle-fill text-2xl"></i>
            </div>
        </div>

        <!-- Visitors Card -->
        <div class="bg-white p-6 rounded-lg text-left hover:shadow-2xl transition-shadow duration-300 flex flex-row items-center justify-between w-full h-20 transform sm:-translate-y-4 lg:-translate-y-8 shadow-lg">
            <div>
                <h2 class="text-gray-700 font-medium mb-2">Visitors</h2>
                <p class="text-gray-700 font-medium">200</p>
            </div>
            <div class="bg-red-500 text-white w-12 h-12 flex items-center justify-center rounded-full">
                <i class="ri-earth-fill text-2xl"></i>
            </div>
        </div>
    </div>
@endsection