@extends('layouts.master')

@section('content')

<div class="max-w-5xl mx-auto p-6 space-y-8">

    <!-- Check if there are cart items -->
    @if (session()->has('cart') && count(session()->get('cart')) > 0)
    <form action="{{route('cart.store')}}" method="POST">
        @csrf

        <!-- Cart Items Section -->
        @foreach (session()->get('cart') as $fooditemId => $item)
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6 flex flex-col sm:flex-row items-center justify-between">

            <!-- Item Image and Info -->
            <div class="flex items-center space-x-4">
                <img src="{{ $item['image_url'] ? asset('image/fooditem/' . $item['image_url']) : 'https://via.placeholder.com/80' }}" 
     alt="{{ $item['name'] }}" 
     class="w-20 h-20 rounded-lg object-cover" />

                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $item['name'] }}</h3>
                    <p class="text-gray-500 text-sm">{{ $item['description'] ?? 'No description available.' }}
                    </p>
                </div>
            </div>

            <!-- Item Price and Quantity Controls -->
            <div class="flex items-center space-x-4 mt-4 sm:mt-0">

                <p class="text-lg font-bold text-red-600">${{ number_format($item['price'], 2) }}</p>

                <div class="flex items-center bg-red-100 rounded-md">

                    <!-- Quantity controls for cart items -->
                    <form action="{{ route('cart.update') }}" method="post"
                        class="inline-flex items-center bg-red-100 rounded-md">
                        @csrf
                        @method('patch')
                        <input type="hidden" name="fooditem_id" value="{{ $fooditemId }}">
                        <!-- Hidden fooditem ID -->

                        <!-- Button to decrease the quantity -->
                        <button type="submit" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}"
                            class="px-4 py-2 text-red-500 hover:bg-red-200 rounded-l-md transition duration-300" {{
                            $item['quantity'] <=1 ? 'disabled' : '' }}>
                            <i class="ri-subtract-line"></i>
                        </button>

                        <!-- Display current quantity -->
                        <span class="px-4 py-2 text-gray-800 font-medium">{{ $item['quantity'] }}</span>

                        <!-- Button to increase the quantity -->
                        <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}"
                            class="px-4 py-2 text-red-500 hover:bg-red-200 rounded-r-md transition duration-300">
                            <i class="ri-add-line"></i>
                        </button>
                    </form>


                </div>


                <!-- Remove button -->
                <form action="{{ route('cart.remove', $fooditemId) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <!-- This line spoof the DELETE method -->
                    <button type="submit" class="text-gray-500 hover:text-red-500 transition duration-300"
                        aria-label="Remove item">
                        <i class="ri-delete-bin-line text-xl"></i>
                    </button>
                </form>

            </div>
        </div>

        <!-- Hidden fields for item details -->
        <input type="hidden" name="items[{{ $fooditemId }}][name]" value="{{ $item['name'] }}">
        <input type="hidden" name="items[{{ $fooditemId }}][price]" value="{{ $item['price'] }}">
        <input type="hidden" name="items[{{ $fooditemId }}][quantity]" value="{{ $item['quantity'] }}">
        <input type="hidden" name="items[{{ $fooditemId }}][description]" value="{{ $item['description'] ?? '' }}">
        <input type="hidden" name="items[{{ $fooditemId }}][image_url]" value="{{ $item['image_url'] ?? '' }}">
        @endforeach

        <!-- User Details and Payment Section -->
        <div class="flex flex-col lg:flex-row lg:space-x-6 mt-8">

            <!-- User Details Form -->
            <div class="w-full lg:w-2/3 mb-6 lg:mb-0">
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Your Details</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-gray-700">Name</label>
                            <input type="text" name="name" id="name"
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                                required />
                        </div>
                        <div>
                            <label for="email" class="block text-gray-700">Email</label>
                            <input type="email" name="email" id="email"
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                                required />
                        </div>
                        <div>
                            <label for="phone" class="block text-gray-700">Phone</label>
                            <input type="tel" name="phone" id="phone"
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                                required />
                        </div>

                        <!-- Payment Method -->
                        <div class="mt-6">
                            <h4 class="text-lg font-semibold text-gray-900">Payment Method</h4>
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center">
                                    <input type="radio" name="payment_method" value="online" class="mr-2"
                                        id="onlinePayment" />
                                    <label for="onlinePayment" class="text-gray-700">Online Payment</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" name="payment_method" value="cash_on_delivery" class="mr-2"
                                        id="cashOnDelivery" />
                                    <label for="cashOnDelivery" class="text-gray-700">Cash on Delivery</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cart Total Section -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Cart Total</h3>
                    <div class="flex justify-between mb-4">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-semibold text-gray-900" id="subtotal">${{ number_format($subtotal, 2)
                            }}</span>
                    </div>
                    <div class="flex justify-between mb-4">
                        <span class="text-gray-600">Total</span>
                        <span class="font-semibold text-red-600" id="total">${{ number_format($total, 2) }}</span>
                    </div>
                    <!-- Button to proceed with checkout -->
                    <button type="submit"
                        class="w-full bg-red-500 text-white py-3 rounded-md hover:bg-red-600 transition duration-300">
                        Submit Order
                    </button>
                </div>
            </div>

        </div>
    </form>
    @else
    <div class="text-center">
        <div class="text-gray-700 mb-6">
            <i class="ri-shopping-cart-2-fill text-6xl"></i>
        </div>

        <h1 class="text-2xl font-bold text-gray-800 mb-2">Cart Is Empty</h1>
        <p class="text-gray-600 mb-6">Your cart is empty, please add items to your cart to place an order.</p>

        <div class="justify-center">
            <a href="{{ route('menu.index') }}"
                class="bg-gradient-to-r from-orange-400 to-red-500 text-white font-medium px-6 py-2 rounded-md shadow-md hover:shadow-lg transition-shadow">
                Go to Menu
            </a>
        </div>
    </div>
    @endif

</div>

@endsection