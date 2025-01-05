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
   
       // Debugging: Check if cart is being updated
       dd(session()->get('cart'));
   
       return redirect()->route('cart.index')->with('success', 'Food item added to cart successfully!');
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
