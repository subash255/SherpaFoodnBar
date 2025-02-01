<?php

namespace App\Http\Controllers;

use App\Models\Fooditem;
use App\Models\Order;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
    
        // Calculate total price by summing up price * quantity for each cart item
        $total = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));
    
        // Generate a unique order number
        $orderNumber = strtoupper(uniqid('ORD-'));
    
        // If payment is cash_on_pickup
        if ($request->payment_method == 'cash_on_pickup') {
            // Save order data to database
            Order::create([
                'order_number' => $orderNumber,
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'status' => 'pending',
                'total' => $total,
                'payment_method' => $data['payment_method'],
                'items' => json_encode($cart),
            ]);
    
            // Clear the cart
            session()->forget('cart');
            return redirect()->route('cart.index')->with('success', 'Order placed successfully!');
        } elseif ($request->payment_method == 'online') {
            // Prepare payment data for online payment using Visma Pay
            $apiKey = env('VISMAPAY_API_KEY');
            $privateKey = env('VISMAPAY_PRIVATE_KEY');
    
            // Prepare the message for HMAC calculation
            $message = $apiKey . '|' . $orderNumber;
            $authcode = strtoupper(hash_hmac('sha256', $message, $privateKey));
    
            $paymentData = [
                'version' => 'w3.2', // API version
                'api_key' => $apiKey,
                'order_number' => $orderNumber,
                'amount' => $total * 100, // Amount in fractional units (EUR * 100)
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
                'products' => json_encode($cart), // Add cart items
            ];
    
            // Make API request to Visma Pay to create the payment token
            $ch = curl_init('https://www.vismapay.com/pbwapi/auth_payment');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($paymentData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . env('VISMAPAY_API_KEY'),
                'X-Private-Key: ' . env('VISMAPAY_PRIVATE_KEY'),
                'Content-Type: application/json',
            ]);
    
            // Execute the request
            $response = curl_exec($ch);
    
            // Handle cURL errors
            if (curl_errno($ch)) {
                curl_close($ch);
                return redirect()->route('cart.index')->with('error', 'An error occurred while placing your order. Please try again later.');
            }
    
            // Close the cURL session
            curl_close($ch);
    
            // Decode the API response
            $responseData = json_decode($response, true);
    
            // Check if payment token was successfully received
            if (isset($responseData['result']) && $responseData['result'] == 0) {
                if (isset($responseData['token']) && !empty($responseData['token'])) {
                    // Generate the payment URL using the token
                    $paymentUrl = 'https://www.vismapay.com/pbwapi/token/' . $responseData['token'];
    
                    // Redirect the user to the payment page
                    return redirect()->away($paymentUrl);
                } else {
                    return redirect()->route('cart.index')->with('error', 'Payment token not received. Please try again later.');
                }
            } else {
                // Handle failure to process payment request
                return redirect()->route('cart.index')->with('error', 'Failed to process payment. Please try again!');
            }
        }
    }
    
    



    public function paymentSuccess($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
    
        // Update the order status to 'payment'
        $order->status = 'payment';
        $order->save();
    
        // Log cart content before clearing
        Log::info('Cart before clearing', ['cart' => session()->get('cart')]);
    
        // Clear the cart from session after successful payment
        session()->forget('cart');
    
        // Log to ensure the cart is cleared
        Log::info('Cart after clearing', ['cart' => session()->get('cart')]);
    
        return view('payment.success', compact('order'));
    }
    
    public function paymentCancel($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        return view('payment.cancel', compact('order'));
    }
    
}
