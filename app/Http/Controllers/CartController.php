<?php

namespace App\Http\Controllers;

use App\Models\Fooditem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{

    // Adding an item to the cart
    public function addToCart(Request $request)
    {
        $fooditem = FoodItem::findOrFail($request->fooditem_id);

        $cart = session()->get('cart', []);

        if (isset($cart[$fooditem->id])) {
            $cart[$fooditem->id]['quantity']++;
        } else {
            $cart[$fooditem->id] = [
                'name' => $fooditem->name,
                'description' => $fooditem->description,
                'price' => $fooditem->price,
                'quantity' => 1,
                'image' => $fooditem->image,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Item added to cart!');
    }


    // View Cart
    public function viewCart()
    {
        $cart = session()->get('cart', []);

        // Calculate subtotal
        $cartSubtotal = 0;
        foreach ($cart as $item) {
            $cartSubtotal += $item['price'] * $item['quantity'];
        }

        // Pass the cart and subtotal to the view
        return view('cart.index', compact('cart', 'cartSubtotal'));
    }

    // Update Cart
    // Update the cart item quantity
    public function update(Request $request)
    {
        $fooditemId = $request->fooditem_id;
        $quantity = $request->quantity;

        // Get cart from session
        $cart = session()->get('cart', []);

        // If the item exists in the cart, update the quantity
        if (isset($cart[$fooditemId])) {
            $cart[$fooditemId]['quantity'] = $quantity;
        }

        // Store the updated cart back in the session
        session()->put('cart', $cart);

        // Return the updated cart
        return response()->json([
            'success' => true,
            'cart' => $cart
        ]);
    }

    // Remove an item from the cart
    public function removeFromCart($fooditemId)
    {
        // Get the current cart
        $cart = session()->get('cart', []);

        // If the item exists, remove it
        if (isset($cart[$fooditemId])) {
            unset($cart[$fooditemId]);
        }

        // Store the updated cart back in the session
        session()->put('cart', $cart);

        // Return the updated cart
        return response()->json([
            'success' => true,
            'cart' => $cart
        ]);
    }





    public function store(Request $request)
    {
        // Validate user input
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'payment_method' => 'required|string|in:online,cash_on_pickup',
            'cart_data' => 'required|string',
        ]);
    
        // Decode cart data from session
        $cart = session()->get('cart', []);
    
        // Calculate total price
        $total = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));
    
        // Generate unique order number
        $orderNumber = strtoupper(uniqid('ORD-'));
    
        // Save order data to the database before payment
        $order = Order::create([
            'order_number' => $orderNumber,
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'total' => $total,
            'payment_method' => $data['payment_method'],
            'items' => json_encode($cart),
        ]);
    
        // If payment is cash on pickup, complete order immediately
        if ($request->payment_method == 'cash_on_pickup') {
            session()->forget('cart');
            return redirect()->route('cart.index')->with('success', 'Order placed successfully!');
        }
    
        // Process online payment using Visma Pay
        $apiKey = env('VISMAPAY_API_KEY');
        $privateKey = env('VISMAPAY_PRIVATE_KEY');
    
        // Generate authentication code
        $message = $apiKey . '|' . $orderNumber;
        $authcode = strtoupper(hash_hmac('sha256', $message, $privateKey));
    
        $paymentData = [
            'version' => 'w3.2',
            'api_key' => $apiKey,
            'order_number' => $orderNumber,
            'amount' => $total * 100, // Convert to cents
            'currency' => 'EUR',
            'email' => $data['email'],
            'payment_method' => [
                'type' => 'e-payment',
                'return_url' => route('cart.success', ['orderNumber' => $orderNumber]),
                'cancel_url' => route('cart.cancel', ['orderNumber' => $orderNumber]),
                'notify_url' => "https://test.shop.com/notify",
                'lang' => 'en',
                'token_valid_until' => time() + 3600, // 1 hour validity
            ],
            'authcode' => $authcode,
            'customer' => [
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
            ],
            'products' => json_encode($cart),
        ];
    
        // API request to Visma Pay
        $ch = curl_init('https://www.vismapay.com/pbwapi/auth_payment');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($paymentData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . env('VISMAPAY_API_KEY'),
            'X-Private-Key: ' . env('VISMAPAY_PRIVATE_KEY'),
            'Content-Type: application/json',
        ]);
    
        // Execute request
        $response = curl_exec($ch);
    
        // Handle cURL errors
        if (curl_errno($ch)) {
            curl_close($ch);
            return redirect()->route('cart.index')->with('error', 'An error occurred while processing payment. Please try again.');
        }
    
        curl_close($ch);
        $responseData = json_decode($response, true);
    
        // Check if payment token was successfully received
        if (isset($responseData['result']) && $responseData['result'] == 0 && isset($responseData['token'])) {
            return redirect()->away('https://www.vismapay.com/pbwapi/token/' . $responseData['token']);
        }
    
        // If payment failed, mark order as failed
        $order->update(['payment_method' => 'failed']);
        return redirect()->route('cart.index')->with('error', 'Failed to process payment. Please try again!');
    }
    





    public function paymentSuccess(Request $request, $orderNumber)
    {
       // Check if the order exists
    $order = Order::where('order_number', $orderNumber)->first();

    if (!$order) {
        return redirect()->route('cart.index')->with('success', 'Order not found.');
    }

    // Update order status to 'paid' if the payment was successful
    if ($request->query('RETURN_CODE') == 0 ) {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Payment successful! Your order has been placed.');
    }else{
        $order->delete();
        return redirect()->route('cart.index')->with('success', 'Payment failed or was not settled.');
    }

    }

    public function paymentCancel($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        $order->delete();
        return view('cart.cancel', compact('order'));
    }
}
