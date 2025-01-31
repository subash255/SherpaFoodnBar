<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Payment Successful</h1>

        <p>Thank you for your purchase! Your order has been successfully processed.</p>

        <h2>Order Details:</h2>
        <ul>
            <li><strong>Order Number:</strong> {{ $order->order_number }}</li>
            <li><strong>Name:</strong> {{ $order->name }}</li>
            <li><strong>Email:</strong> {{ $order->email }}</li>
            <li><strong>Total:</strong> ${{ number_format($order->total, 2) }}</li>
            <li><strong>Status:</strong> Paid</li>
        </ul>

        <p>Your order will be processed and shipped shortly.</p>

        <a href="{{ route('cart.index') }}" class="btn btn-primary">Back to Shop</a>
    </div>
</body>
</html>
