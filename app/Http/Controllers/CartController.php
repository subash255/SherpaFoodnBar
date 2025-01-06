<?php

namespace App\Http\Controllers;

use App\Models\Fooditem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Add to Cart
    // Adding an item to the cart
public function addToCart(Request $request)
{
    $fooditem = FoodItem::findOrFail($request->fooditem_id);

    $cart = session()->get('cart', []);

    // Add or update the item in the cart
    if (isset($cart[$fooditem->id])) {
        $cart[$fooditem->id]['quantity']++;
    } else {
        $cart[$fooditem->id] = [
            'name' => $fooditem->name,
            'description' => $fooditem->description,
            'price' => $fooditem->price,
            'quantity' => 1,
            'image_url' => $fooditem->image_url,
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
        // Log the incoming data for debugging
        Log::info('Store request data:', $request->all());
    
        // Validate user input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'payment_method' => 'required|string|in:online,cash_on_delivery',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('cart.index')
                             ->withErrors($validator)
                             ->withInput();
        }
    
        // Retrieve the cart from the session
        $cart = session()->get('cart');
        if (!$cart || count($cart) == 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }
    
        // Calculate total price
        $total = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));
    
        // Generate a unique order number
        $orderNumber = strtoupper(uniqid('ORD-'));
    
        // Create a new order in the database
        $order = Order::create([
            'order_number' => $orderNumber,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => 'pending',
            'total' => $total,
            'payment_method' => $request->payment_method,
            'items' => json_encode($cart),  // Store cart as JSON
            'notes' => $request->notes,
        ]);
    
        // Log the order details
        Log::info('Order placed successfully:', $order->toArray());
    
        // Clear the cart from session
        session()->forget('cart');
    
        // Redirect to a confirmation page or order details page
        return redirect()->route('cart.index')->with('success', 'Order placed successfully!');
    }
    
    
}    