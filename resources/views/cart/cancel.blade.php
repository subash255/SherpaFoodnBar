<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Cancelled</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Payment Cancelled</h1>

        <p>We're sorry, but your payment was cancelled. Your order has not been processed.</p>

        <h2>Order Details:</h2>
        <ul>
            <li><strong>Order Number:</strong> {{ $order->order_number }}</li>
            <li><strong>Name:</strong> {{ $order->name }}</li>
            <li><strong>Email:</strong> {{ $order->email }}</li>
            <li><strong>Total:</strong> ${{ number_format($order->total, 2) }}</li>
        </ul>

        <p>You can go back to your cart and complete the payment again or contact support for assistance.</p>

        <a href="{{ route('cart.index') }}" class="btn btn-primary">Back to Cart</a>
    </div>
</body>
</html>
