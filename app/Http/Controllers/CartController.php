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
    
        if($request->payment_method == 'cash_on_pickup'){
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
            session()->forget('cart');
            return redirect()->route('cart.index')->with('success', 'Order placed successfully!');
        }elseif($request->payment_method == 'online'){
            
            $paymentData = [
                'order_number' => $orderNumber,
                'amount' => $total * 100, // Convert to fractional units (1 USD = 100 cents)
                'currency' => 'USD',  // Adjust the currency if necessary
                'email' => $data['email'],
                'name' => $data['name'],
                'phone' => $data['phone'],
                'return_url' => route('cart.success',  $orderNumber),
                'cancel_url' => route('cart.cancel',  $orderNumber),
            ];

            $apiKey = env('VISMAY_API_KEY');
            $privateKey = env('VISMAY_PRIVATE_KEY');
            try {
                // Sending POST request to external payment API
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'X-Private-Key' => $privateKey,
                ])->post('https://www.vismapay.com/pbwapi/auth_payment', $paymentData);
                
                // Check if the response was successful
                $responseData = $response->json();
                
                // Check if the result is success (1) and process the order
                if (isset($responseData['result']) && $responseData['result'] == 1) {
                    // Create the order in your system
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
        
                    // Clear the cart session
                    session()->forget('cart');
        
                    // Redirect to the cart index with a success message
                    return redirect()->route('cart.index')->with('success', 'Order placed successfully!');
                } else {
                    return redirect()->route('cart.index')->with('error', 'Failed to place order. Please try again!');
                }
            } catch (\Exception $e) {
                return redirect()->route('cart.index')->with('error', 'An error occurred while placing your order. Please try again later.');
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

    return view('payment.sucess', compact('order'));
}


    public function paymentCancel($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        return view('payment.cancel', compact('order'));
    }
    
}