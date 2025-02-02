@extends('layouts.app')

@section('content')
<div class="p-4 bg-white shadow-lg -mt-11 mx-4 z-20 rounded-lg">
    <!-- Order Header -->
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-semibold text-gray-800">Order #{{ $order->order_number }}</h2>
        <a href="{{ route('admin.order.index') }}" class="bg-gray-700 text-white px-8 py-3 rounded-lg hover:bg-gray-800 transition-colors">
            Back to Orders
        </a>
    </div>

    <!-- Order Information Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        <!-- Customer Information Card -->
        <div class="bg-gray-50 p-6 rounded-lg shadow-md border border-gray-200">
            <h3 class="text-xl font-semibold text-gray-700 mb-5">Customer Information</h3>
            <div>
                <p class="text-gray-600"><strong>Name:</strong> {{ $order->name }}</p>
                <p class="text-gray-600"><strong>Email:</strong> {{ $order->email }}</p>
                <p class="text-gray-600"><strong>Phone:</strong> {{ $order->phone }}</p>
            </div>
        </div>

    </div>

    <!-- Order Items Section -->
    <div class="bg-white p-6 rounded-lg shadow-md mt-8">
        <h3 class="text-xl font-semibold text-gray-700 mb-5">Order Items</h3>
        @php
        $items = is_array($order->items) ? $order->items : json_decode(json_encode($order->items), true);
    @endphp
    
    @if($items && count($items) > 0)
        <div class="space-y-6">
            @foreach($items as $item) <!-- Now $items is an array -->
                <div class="flex justify-between items-center p-4 border-b border-gray-200">
                    <div class="flex items-center space-x-6">
                        <!-- Display Product Image -->
                        <img src="{{ asset('images/fooditem/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-36 h-36 object-cover rounded-md">

                        <div>
                            <h4 class="font-semibold text-gray-800">{{ $item['name'] }}</h4>
                        </div>
                    </div>
                    <div>
                        <p class="text-gray-600"><strong>Quantity:</strong> {{ $item['quantity'] }}</p>
                        <p class="text-gray-600"><strong>Price:</strong> €{{ number_format($item['price'], 2) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center text-gray-600">No items available for this order.</p>
    @endif
    
    </div>

    <!-- Order Status Section -->
    <div class="bg-white p-6 rounded-lg shadow-md mt-8">
        <h3 class="text-xl font-semibold text-gray-700 mb-5">Order Status</h3>
        <div>
            <p class="text-gray-600"><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            <p class="text-gray-600"><strong>Total Price:</strong> €{{ number_format($order->total, 2) }}</p>
            <p class="text-gray-600"><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
        </div>
    </div>
</div>
@endsection
