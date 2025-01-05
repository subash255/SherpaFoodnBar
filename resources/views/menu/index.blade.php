@extends('layouts.master')
@section('content')
    <style>
        /* Hide the modal */
        .modal-hidden {
            display: none !important;
        }

        /* Show the modal with flex */
        .modal-visible {
            display: flex !important;
        }

        /* Focus styles for buttons */
        .category-button:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(249, 115, 22, 0.5);
            /* Orange shadow on focus */
        }

        /* Hover and transition effect for buttons */
        .category-button:hover {
            transform: translateX(2px);
        }
    </style>

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
            <aside class="w-full lg:w-1/4 bg-white shadow-lg rounded-lg p-4">
                <!-- Title -->
                <h2 class="text-xl font-semibold text-orange-600 mb-6">Menu Categories</h2>

                <!-- Search Section -->
                <div class="mb-4 flex">
                    <!-- Search Input -->
                    <input type="text" placeholder="Search by dish name"
                        class="w-full border rounded-l-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 placeholder:text-sm placeholder:text-gray-500" />

                    <!-- Search Button -->
                    <button class="bg-orange-500 text-white py-2 px-4 rounded-r-lg hover:bg-orange-600 focus:outline-none">
                        Search
                    </button>
                </div>


                <!-- Category List -->
                <ul class="space-y-4">
                    <!-- All Categories Button -->
                    <li>
                        <button
                            class="category-button w-full text-left px-4 py-3 rounded-lg font-semibold text-gray-800 bg-gray-200 hover:bg-orange-100 focus:ring-2 focus:ring-orange-500 transition duration-300 ease-in-out"
                            onclick="filterCategory(0)">
                            <span class="mr-2 text-orange-500">📋</span> All Categories
                        </button>
                    </li>

                    <!-- Category Buttons -->
                    @foreach ($categories as $category)
                        <li>
                            <button
                                class="category-button w-full text-left px-4 py-3 rounded-lg font-semibold text-gray-800 bg-gray-200 hover:bg-orange-100 focus:ring-2 focus:ring-orange-500 transition duration-300 ease-in-out"
                                onclick="filterCategory({{ $category->id }})">
                                <span class="mr-2 text-orange-500"></span> {{ $category->name }}
                            </button>
                        </li>
                    @endforeach
                </ul>

                <!-- Filter by Veg or Non-Veg -->
                <div class="mt-6 space-y-3">
                    <p class="font-semibold text-gray-700">Filter by Type</p>
                    <label class="flex items-center space-x-3">
                        <input type="radio" name="filter" class="text-orange-500">
                        <span class="text-gray-600">Veg</span>
                    </label>
                    <label class="flex items-center space-x-3">
                        <input type="radio" name="filter" class="text-orange-500">
                        <span class="text-gray-600">Non-Veg</span>
                    </label>
                </div>
            </aside>

            <!-- Menu Items -->
            <div id="food-items" class="space-y-4 mt-6 w-full">
                @foreach ($categories as $category)
                    <div class="category-section category-{{ $category->id }} w-full">
                        <!-- Category Title -->
                        <h2 class="text-2xl text-center mt-4 font-bold text-green-600 mb-4">{{ $category->name }}</h2>
                        <div class="space-y-4 w-full">
                            @foreach ($category->fooditems as $fooditem)
                                <!-- Menu Item -->
                                <div class="food-item flex flex-col sm:flex-row items-center bg-white rounded-lg shadow p-4 w-full"
                                    data-fooditem-id="{{ $fooditem->id }}">
                                    <!-- Image Section -->
                                    <div class="flex-shrink-0">
                                        <img src="{{ asset('images/fooditem/' . $fooditem->image) }}"
                                            alt="{{ $fooditem->name }}" class="w-24 h-24 object-cover rounded-lg">
                                    </div>
                                    <!-- Text and Price Section -->
                                    <div class="ml-6 flex-grow">
                                        <h3 class="text-lg font-bold">{{ $fooditem->name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $fooditem->description }}</p>
                                        <p class="text-lg font-bold text-gray-800 mt-2">
                                            €{{ number_format($fooditem->price, 2) }}</p>
                                    </div>
                                    <!-- Button Section -->
                                    <div class="flex items-center justify-center mt-4 sm:mt-0 sm:ml-4">
                                        <button
                                            class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-6 py-2 rounded order-now-button">Order
                                            Now</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
        <!-- Modal Structure -->
        <div id="order-modal"
            class="fixed inset-0 bg-black bg-opacity-70 modal-hidden flex items-center justify-center z-50 backdrop-blur-[1px]">
            <div class="bg-white rounded-lg p-6 w-full sm:w-11/12 md:w-10/12 lg:w-3/4 xl:w-2/3 max-w-5xl relative">
                <h3 class="text-xl font-bold mb-4">Order Now</h3>

                <!-- Order Form -->
                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-wrap gap-8 mb-6">
                        <!-- Left Side: User Information -->
                        <div class="flex-1 min-w-[250px]">
                            <h4 class="text-lg font-semibold mb-2">Your Information</h4>
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700">Your Name</label>
                                <input type="text" id="name" name="name"
                                    class="mt-1 p-2 border border-gray-300 rounded w-full" required>
                            </div>

                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium text-gray-700">Your Email</label>
                                <input type="email" id="email" name="email"
                                    class="mt-1 p-2 border border-gray-300 rounded w-full" required>
                            </div>

                            <div class="mb-4">
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone
                                    Number</label>
                                <input type="tel" id="phone" name="phone"
                                    class="mt-1 p-2 border border-gray-300 rounded w-full" required>
                            </div>
                        </div>

                        <!-- Right Side: Order Information -->
                        <div class="flex-1 min-w-[250px]">
                            <h4 class="text-lg font-semibold mb-2">Order Information</h4>
                            <div class="mb-4">
                                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                                <input type="number" id="quantity" name="quantity" min="1"
                                    class="mt-1 p-2 border border-gray-300 rounded w-full" required>
                            </div>

                            <div class="mb-4">
                                <label for="note" class="block text-sm font-medium text-gray-700">Special
                                    Instructions</label>
                                <textarea id="note" name="note" class="mt-1 p-2 border border-gray-300 rounded w-full"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Fields for Food Item -->
                    <input type="hidden" id="fooditem-id" name="fooditem_id">
                    <input type="hidden" id="fooditem-name" name="fooditem_name">
                    <input type="hidden" id="fooditem-price" name="fooditem_price">

                    <!-- Action Buttons -->
                    <div class="flex justify-between gap-4 mt-8">
                        <!-- Close Button -->
                        <button type="button" id="close-modal"
                            class="w-full md:w-auto font-semibold bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 transition duration-300 focus:outline-none">
                            Cancel
                        </button>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full md:w-auto bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-semibold py-2 px-6 rounded-lg hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 transform hover:scale-105">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>




        <script>
            // Function to filter the food items by category
            function filterCategory(categoryId) {
                const allCategorySections = document.querySelectorAll('.category-section');

                allCategorySections.forEach(section => {

                    if (categoryId === 0) {
                        section.style.display = 'block';
                    } else {

                        if (section.classList.contains('category-' + categoryId)) {
                            section.style.display = 'block';
                        } else {
                            section.style.display = 'none';
                        }
                    }
                });


                const allButtons = document.querySelectorAll('.category-button');


                allButtons.forEach(button => {
                    button.classList.remove('bg-orange-600');
                });


                const clickedButton = document.querySelector(`button[onclick="filterCategory(${categoryId})"]`);
                clickedButton.classList.add('bg-orange-600');
            }


            window.onload = function() {
                filterCategory(0);
            }


            const modal = document.getElementById('order-modal');
            const closeModalButton = document.getElementById('close-modal');

            // Add event listeners to "Order Now" buttons
            const orderButtons = document.querySelectorAll('.order-now-button');

            orderButtons.forEach(button => {
                button.addEventListener('click', (event) => {
                    const foodItem = event.target.closest('.food-item');
                    const foodName = foodItem.querySelector('h3').innerText;
                    const foodPrice = foodItem.querySelector('.text-lg').innerText.replace('€', '').trim();
                    const foodId = foodItem.dataset.fooditemId;

                    // Populate form fields with the selected food item
                    document.getElementById('fooditem-name').value = foodName;
                    document.getElementById('fooditem-price').value = foodPrice;
                    document.getElementById('fooditem-id').value = foodId;

                    // Show the modal by adding 'modal-visible' class and removing 'modal-hidden'
                    modal.classList.remove('modal-hidden');
                    modal.classList.add('modal-visible');

                    document.body.classList.add('overflow-hidden'); // Disable scrolling when modal is open

                });
            });

            // Close modal when clicking 'Cancel' or clicking outside
            closeModalButton.addEventListener('click', () => {
                modal.classList.remove('modal-visible');
                modal.classList.add('modal-hidden');
                document.body.classList.remove('overflow-hidden'); // Disable scrolling when modal is open

            });

            window.addEventListener('click', (event) => {
                if (event.target === modal) {
                    modal.classList.remove('modal-visible');
                    modal.classList.add('modal-hidden');

                    // Enable scrolling when modal is closed
                    document.body.style.overflow = ''; // Restore body scroll
                }
            });
        </script>
    @endsection
