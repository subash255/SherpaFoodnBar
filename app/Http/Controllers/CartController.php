<?php

namespace App\Http\Controllers;

use App\Models\Fooditem;
use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Add to Cart
    public function addToCart(Request $request)
    {
        $fooditemId = $request->fooditem_id;
        $quantity = $request->quantity ?? 1; // Default quantity is 1

        // Retrieve the cart from the session (an empty array if it doesn't exist)
        $cart = session()->get('cart', []);

        // Check if the fooditem is already in the cart
        if (isset($cart[$fooditemId])) {
            // Update the quantity of the existing fooditem
            $cart[$fooditemId]['quantity'] += $quantity;
        } else {
            // Add the fooditem to the cart
            $fooditem = Fooditem::find($fooditemId);
            $cart[$fooditemId] = [
                'name' => $fooditem->name,
                'quantity' => $quantity,
                'price' => $fooditem->price,
            ];
        }

        // Store the cart back in the session
        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Fooditem added to cart successfully!');
    }

// View Cart
public function viewCart()
{
    $cart = session()->get('cart', []);
    
    // Calculate subtotal
    $subtotal = 0;
    foreach ($cart as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }

    // Optionally, apply any discount logic (if needed, e.g., for coupons)
    $discount = 0; // For simplicity, no discount here
    $total = $subtotal - $discount;

    // Return the view with the cart, subtotal, and total
    return view('cart.index', compact('cart', 'subtotal', 'total'));
}
}
