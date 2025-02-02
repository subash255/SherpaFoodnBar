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

    </style>

    <!-- Flash Messages (if any) -->
    @if (session('success'))
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
                    <a href="#menu"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded-full text-lg transition-all transform hover:scale-102 hover:translate-y-0.5 duration-300 ease-in-out">
                        Lunch Menu
                    </a>
                    <a href="#delivery"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded-full text-lg transition-all transform hover:scale-102 hover:translate-y-0.5 duration-300 ease-in-out">
                        Home Delivery / Takeaway
                    </a>
                    <a href="#reservation"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded-full text-lg transition-all transform hover:scale-102 hover:translate-y-0.5 duration-300 ease-in-out">
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
            @foreach ($categories as $category)
                <div class="swiper-slide flex flex-col items-center justify-center p-4 mb-6 bg-white rounded-lg shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 ease-in-out">
                    <a href="{{ route('menu.index') }}">
                        <img src="{{ asset('images/brand/' . $category->image) }}" alt="Starters"
                            class="w-full sm:w-52 h-52 object-cover rounded-lg mb-4">
                        <div class="product-name text-xl font-bold text-gray-900 text-center">{{ $category->name }}</div>
                    </a>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination Dots -->
        <div class="swiper-pagination"></div> 
    </div>


<!-- Table Reservation Section -->
<section id="reservation" class="relative py-20 text-center text-white bg-cover bg-center mt-10"
    style="background-image: url('{{ asset('images/table.jpg') }}');">
    <div class="absolute inset-0 bg-black opacity-50"></div>

    <div class="relative z-10">
        <h1 class="text-4xl font-extrabold mb-6">Reserve a Table</h1>
        <p class="text-lg mb-8">Book a table now and enjoy a fantastic dining experience.</p>
        <form id="reservationForm" action="{{ route('booking.store') }}" method="POST" class="max-w-lg mx-auto">
            @csrf

            <!-- Display error message -->
            @if (session('error'))
                <div class="bg-red-500 text-white p-4 mb-4 rounded-md">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Display success message -->
            @if (session('success'))
                <div class="bg-green-500 text-white p-4 mb-4 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4">
                <input type="text" name="name" placeholder="Enter your name"
                    class="w-full p-3 border border-gray-300 rounded-md text-gray-700" required>
            </div>
            <div class="mb-4">
                <input type="email" name="email" placeholder="Enter your email"
                    class="w-full p-3 border border-gray-300 rounded-md text-gray-700" required>
            </div>
            <div class="mb-4">
                <input type="tel" name="phone" placeholder="Enter your contact number"
                    class="w-full p-3 border border-gray-300 rounded-md text-gray-700" required>
            </div>
            <div class="mb-4">
                <input type="number" name="number_of_people" placeholder="Number of people"
                    class="w-full p-3 border border-gray-300 rounded-md text-gray-700" required>
            </div>
            <div class="mb-4">
                <input type="datetime-local" name="booking_date"
                    class="w-full p-3 border border-gray-300 rounded-md text-gray-700" required>
            </div>
        <div id="errorMessage" class="hidden text-red-500 text-lg my-2"></div>

            <button type="button" id="openPopupButton"
                class="bg-white hover:bg-gray-200 text-indigo-600 py-2 px-6 rounded-md text-lg">Book Now</button>
        </form>
    </div>
</section>

<!-- Popup Modal -->
<div id="popupModal"
    class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center opacity-0 pointer-events-none transform transition-all z-50 duration-300 ease-in-out">
    <div class="bg-white p-8 rounded-lg max-w-lg mx-auto text-center shadow-xl transform transition-all duration-300 ease-in-out relative">
        <h2 class="text-3xl font-extrabold mb-4 text-gray-800">Confirm Your Reservation</h2>
        <p class="text-lg mb-6 text-gray-600">Are you sure you want to reserve the table?</p>

        <div id="popupContent" class="text-sm text-gray-700 mb-6  text-justify">
            <!-- This will be dynamically filled with form data -->
        </div>

        <p class="text-red-600 text-sm mt-4">
            Table will be held for 15 minutes after the reservation time.
            We appreciate you being on time.
        </p>

        <div class="flex justify-between mt-6">
            <button id="cancelButton"
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-md text-lg font-medium transition-all duration-200 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 w-full sm:w-auto">
                Cancel
            </button>
            <button id="confirmButton"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-md text-lg font-medium transition-all duration-200 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 w-full sm:w-auto">
                Confirm
            </button>
        </div>
    </div>
</div>





    <!-- Food Ordering Section -->
    <section id="order" class="py-20 bg-gray-50 text-center">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-6">Customer Favorites</h1>
        <p class="text-lg text-gray-600 mb-12">Discover the Flavors Everyone's Raving About Today!</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12 max-w-7xl mx-auto px-4">

            <!-- Menu Item 1: Jhol Momo -->
            @foreach ($fooditems as $fooditem)
                @if ($fooditem->status == 1)
                    <div
                        class="bg-white p-6 rounded-xl shadow-xl hover:shadow-2xl transition-transform transform hover:scale-105">
                        <!-- Dynamically displaying the food item's image -->
                        <img src="{{ asset('images/fooditem/' . $fooditem->image) }}" alt="{{ $fooditem->name }}"
                            class="w-full h-56 object-cover rounded-lg mb-6 transition-all duration-500 ease-in-out hover:opacity-90">

                        <!-- Dynamically displaying the food item's name -->
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $fooditem->name }}</h3>

                        <!-- Dynamically displaying the food item's price -->
                        <p class="text-lg text-gray-600 mb-4">€{{ number_format($fooditem->price, 2) }}</p>

                        <!-- Order button -->
                        <form action="{{ route('cart.add', $fooditem->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="fooditem_id" value="{{ $fooditem->id }}">
                            <input type="hidden" name="fooditem_name" value="{{ $fooditem->name }}">
                            <input type="hidden" name="fooditem_price" value="{{ $fooditem->price }}">
                            <input type="hidden" name="fooditem_image" value="{{ $fooditem->image }}">

                            <button type="submit"
                                class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-6 py-2 rounded">Order
                                Now</button>

                        </form>
                    </div>
                @endif
            @endforeach


        </div>
    </section>

    <script>
document.addEventListener('DOMContentLoaded', function () {
    // Get elements
    const openPopupButton = document.getElementById('openPopupButton');
    const popupModal = document.getElementById('popupModal');
    const cancelButton = document.getElementById('cancelButton');
    const confirmButton = document.getElementById('confirmButton');
    const popupContent = document.getElementById('popupContent');
    const form = document.getElementById('reservationForm');
    const errorMessage = document.getElementById('errorMessage');  // Added error message element

    // Show the popup with content when "Book Now" is clicked
    openPopupButton.addEventListener('click', function (event) {
        // Prevent the form from submitting
        event.preventDefault();

        // Get form data
        const name = form.elements['name'].value;
        const email = form.elements['email'].value;
        const phone = form.elements['phone'].value;
        const people = form.elements['number_of_people'].value;
        const bookingDateTime = form.elements['booking_date'].value;

        // Check if any of the required fields are empty
        if (!name || !email || !phone || !people || !bookingDateTime) {
            // Display an error message
            errorMessage.classList.remove('hidden');
            errorMessage.textContent = "Please fill out all fields before proceeding.";
            return;  // Stop further execution
        }

        // Hide error message if all fields are filled
        errorMessage.classList.add('hidden');

        // Split the booking date and time
        const [bookingDate, bookingTime] = bookingDateTime.split('T');
        const formattedBookingDate = `${bookingDate.replaceAll('-', '/')} ${bookingTime}`;

        // Update popup content
        popupContent.innerHTML = `
            <div class="mb-4"><strong>Name:</strong> ${name}</div>
            <div class="mb-4"><strong>Email:</strong> ${email}</div>
            <div class="mb-4"><strong>Phone:</strong> ${phone}</div>
            <div class="mb-4"><strong>Number of People:</strong> ${people}</div>
            <div class="mb-4"><strong>Booking Date:</strong> ${formattedBookingDate}</div>
        `;

        // Show the modal
        popupModal.classList.remove('opacity-0', 'pointer-events-none');
        popupModal.classList.add('opacity-100', 'pointer-events-auto');
    });

    // Cancel button - closes the modal
    cancelButton.addEventListener('click', function () {
        popupModal.classList.remove('opacity-100', 'pointer-events-auto');
        popupModal.classList.add('opacity-0', 'pointer-events-none');
    });

    // Confirm button - submits the form
    confirmButton.addEventListener('click', function () {
        form.submit();  // Submit the form to the backend
    });
});

  </script>
  
  
    
@endsection
