@extends('layouts.master')

@section('content')
<div class="max-w-5xl mx-auto p-6 space-y-8">

    <!-- Check if there are cart items -->
    @if (session()->has('cart') && count(session()->get('cart')) > 0)
    <form action="{{route('cart.store')}}" method="POST">
        @csrf
        <!-- Cart Items Section -->
        @foreach (session()->get('cart') as $fooditemId => $item)
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6 flex flex-col sm:flex-row items-center justify-between" id="cart-item-{{ $fooditemId }}">

            <!-- Item Image and Info -->
            <div class="flex items-center space-x-4">
                <img src="{{ $item['image_url'] ? asset('images/fooditem/' . $item['image_url']) : 'https://via.placeholder.com/80' }}" 
                    alt="{{ $item['name'] }}" 
                    class="w-20 h-20 rounded-lg object-cover" />

                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $item['name'] }}</h3>
                    <p class="text-gray-500 text-sm">{{ $item['description'] ?? 'No description available.' }}</p>
                </div>
            </div>

            <!-- Item Price and Quantity Controls -->
            <div class="flex items-center space-x-4 mt-4 sm:mt-0">

                <p class="text-lg font-bold text-red-600">${{ number_format($item['price'], 2) }}</p>

                <div class="flex items-center bg-red-100 rounded-md">

                    <!-- Quantity controls for cart items -->
                    <div class="quantity-controls">
                        <button type="button" class="decrease-btn" data-fooditem-id="{{ $fooditemId }}" data-action="decrease">-</button>
                        <span class="quantity text-gray-800 font-medium">{{ $item['quantity'] }}</span>
                        <button type="button" class="increase-btn" data-fooditem-id="{{ $fooditemId }}" data-action="increase">+</button>
                    </div>

                </div>

                <!-- Remove button -->
                <button type="button" class="remove-btn text-gray-500 hover:text-red-500 transition duration-300" data-fooditem-id="{{ $fooditemId }}">
                    <i class="ri-delete-bin-line text-xl"></i>
                </button>

            </div>
        </div>

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
        <!-- You can keep this section unchanged for this demonstration -->
        <div class="mt-6 flex justify-between items-center">
            <p class="text-xl font-semibold">Subtotal: $<span id="subtotal">{{ number_format($cartSubtotal, 2) }}</span></p>
            <button type="submit" class="bg-green-500 text-white py-2 px-6 rounded-md hover:bg-green-600 transition">Proceed to Checkout</button>
        </div>

    </form>
    @else
    <div class="text-center">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Cart Is Empty</h1>
        <p class="text-gray-600 mb-6">Your cart is empty, please add items to your cart to place an order.</p>
    </div>
    @endif

</div>

<script>
    $(document).ready(function() {

        // Update quantity (increase/decrease)
        $('.decrease-btn, .increase-btn').on('click', function() {
            let fooditemId = $(this).data('fooditem-id');
            let action = $(this).data('action');
            let currentQuantity = parseInt($('#cart-item-' + fooditemId + ' .quantity').text());

            // Calculate the new quantity
            let newQuantity = (action === 'increase') ? currentQuantity + 1 : (currentQuantity > 1 ? currentQuantity - 1 : 1);

            // Send AJAX request to update the cart
            $.ajax({
                url: '{{ route('cart.update') }}',
                method: 'PATCH',
                data: {
                    _token: '{{ csrf_token() }}',
                    fooditem_id: fooditemId,
                    quantity: newQuantity
                },
                success: function(response) {
                    // Update the UI with the new quantity
                    $('#cart-item-' + fooditemId + ' .quantity').text(newQuantity);
                    updateCartTotal(response.cart);
                },
                error: function() {
                    alert('Something went wrong while updating the cart.');
                }
            });
        });

        // Remove item from cart
        $('.remove-btn').on('click', function() {
            let fooditemId = $(this).data('fooditem-id');

            // Send AJAX request to remove item from cart
            $.ajax({
                url: '/cart/remove/' + fooditemId,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    // Remove the item from the UI
                    $('#cart-item-' + fooditemId).remove();
                    updateCartTotal(response.cart);
                },
                error: function() {
                    alert('Something went wrong while removing the item.');
                }
            });
        });

        // Update the cart total
        function updateCartTotal(cart) {
            let subtotal = 0;
            $.each(cart, function(id, item) {
                subtotal += item.price * item.quantity;
            });
            $('#subtotal').text('$' + subtotal.toFixed(2));
            let total = subtotal; // Apply any discounts here if necessary
            $('#total').text('$' + total.toFixed(2));
        }
    });
</script>

@endsection
