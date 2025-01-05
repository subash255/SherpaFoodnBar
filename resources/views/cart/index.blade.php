@extends('layouts.master')

@section('content')

<div class="max-w-5xl mx-auto p-6 space-y-8">

    <!-- Cart Items -->
    @if (session()->has('cart') && count(session()->get('cart')) > 0)
        @foreach(session()->get('cart') as $fooditemId => $item)
            <div class="bg-white shadow-lg rounded-lg p-6 mb-6 flex flex-col sm:flex-row items-center justify-between">
                <div class="flex items-center">
                    <img src="{{ $item['image_url'] ?? 'https://via.placeholder.com/80' }}" alt="{{ $item['name'] }}" class="w-20 h-20 rounded-lg object-cover" />
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $item['name'] }}</h3>
                        <p class="text-gray-500 text-sm">{{ $item['description'] ?? 'No description available.' }}</p>
                    </div>
                </div>

                <div class="flex items-center space-x-4 mt-4 sm:mt-0">
                    <p class="text-lg font-bold text-red-600">${{ number_format($item['price']) }}</p>
                    <div class="flex items-center bg-red-100 rounded-md">
                        <!-- Increase and Decrease buttons to change quantity -->
                        <form action="#" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}" class="px-4 py-2 text-red-500 hover:bg-red-200 rounded-l-md transition duration-300" {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                <i class="ri-subtract-line"></i>
                            </button>
                            <span class="px-4 py-2 text-gray-800 font-medium">{{ $item['quantity'] }}</span>
                            <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" class="px-4 py-2 text-red-500 hover:bg-red-200 rounded-r-md transition duration-300">
                                <i class="ri-add-line"></i>
                            </button>
                        </form>
                    </div>
                    <form action="{{ route('cart.remove', $fooditemId) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-gray-500 hover:text-red-500 transition duration-300" aria-label="Remove item">
                            <i class="ri-delete-bin-line text-xl"></i>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach

        <!-- Coupon Code and Cart Total Section in Same Row -->
        <div class="flex flex-col lg:flex-row lg:space-x-6">

            <!-- Coupon Section -->
            <div class="w-full lg:w-2/3 mb-6 lg:mb-0">
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Apply Coupon</h3>
                    <div class="flex items-center space-x-0">
                        <input type="text" placeholder="Enter Coupon Code"
                            class="w-full px-4 py-3 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-red-500 text-gray-700" />
                        <button class="bg-red-500 text-white px-6 py-3 rounded-r-md hover:bg-red-600 focus:outline-none transition duration-300">
                            Apply
                        </button>
                    </div>
                </div>
            </div>

            <!-- Cart Total Section -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Cart Total</h3>
                    <div class="flex justify-between mb-4">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-semibold text-gray-900" id="subtotal">${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between mb-4">
                        <span class="text-gray-600">Total</span>
                        <span class="font-semibold text-red-600" id="total">${{ number_format($total, 2) }}</span>
                    </div>
                    <a href="#" class="w-full bg-red-500 text-white py-3 rounded-md hover:bg-red-600 transition duration-300">
                        Proceed To Checkout
                    </a>
                </div>
            </div>

        </div>
    @else
    <div class="text-center">
        
        <div class="text-gray-700 mb-6">
            <i class="ri-shopping-cart-2-fill text-6xl"></i> 
        </div>
    
        <!-- Heading -->
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Cart Is Empty</h1>
        <p class="text-gray-600 mb-6">Your cart is empty, please add items to your cart to place an order.</p>
    
        <!-- Buttons -->
        <div class="justify-center">
          <a href="{{route('menu.index')}}" class="bg-gradient-to-r from-orange-400 to-red-500 text-white font-medium px-6 py-2 rounded-md shadow-md hover:shadow-lg transition-shadow">
           Go to Menu
          </a>
        </div>
      </div>
    @endif

</div>


@endsection

