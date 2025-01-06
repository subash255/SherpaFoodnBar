<?php

namespace App\Http\Controllers;

use App\Models\Fooditem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Add to Cart
    public function addToCart(Request $request)
    {
        $fooditemId = $request->fooditem_id;  // Make sure this matches the hidden input name in the form
        $quantity = $request->quantity ?? 1; // Default quantity is 1

        // Retrieve the cart from the session (an empty array if it doesn't exist)
        $cart = session()->get('cart', []);

        // Try to find the food item
        $fooditem = Fooditem::find($fooditemId);

        if (!$fooditem) {
            // If the food item does not exist, you can return an error or redirect
            return redirect()->route('cart.index')->with('error', 'Food item not found.');
        }

        // Check if the fooditem is already in the cart
        if (isset($cart[$fooditemId])) {
            // Update the quantity of the existing fooditem
            $cart[$fooditemId]['quantity'] += $quantity;
        } else {
            // Add the fooditem to the cart
            $cart[$fooditemId] = [
                'name' => $fooditem->name,
                'quantity' => $quantity,
                'price' => $fooditem->price,
                'image_url' => $fooditem->image ?? 'https://via.placeholder.com/80',
                'description' => $fooditem->description ?? 'No description available.',
            ];
        }

        // Store the cart back in the session
        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Food item added to cart successfully!');
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'payment_method' => 'required|string|in:online,cash_on_delivery',
        ]);
    
        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->route('cart.index')
                             ->withErrors($validator)
                             ->withInput();
        }
    
        // Retrieve the cart from the session
        $cart = session()->get('cart', []);
    
        // Check if the cart is empty
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
    
        // Calculate the total price
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
    
        // Optionally, apply any discounts (if needed, e.g., for coupons)
        $discount = 0; // For simplicity, no discount here
        $total = $subtotal - $discount;
    
        // Generate a unique order number (for example, using timestamp or a random string)
        $orderNumber = 'ORD-' . strtoupper(uniqid());
    
        // Create the order and store the cart items as JSON
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
    
        // Clear the cart from the session
        session()->forget('cart');
    
        // Redirect with success message
        return redirect()->route('cart.index')->with('success', 'Your order has been placed successfully!');
    }
}    