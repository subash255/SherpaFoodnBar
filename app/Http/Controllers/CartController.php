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

    // Update Cart
    public function update(Request $request)
    {
        $cart = session()->get('cart');
    
        if ($request->has('fooditem_id') && $request->has('quantity')) {
            $fooditemId = $request->fooditem_id;
            $quantity = $request->quantity;
    
            if (isset($cart[$fooditemId])) {
                $cart[$fooditemId]['quantity'] = $quantity;
                session()->put('cart', $cart);
            }
        }
    
        // Return updated cart total and subtotal
        $total = $this->getCartTotal();
        $subtotal = $this->getCartSubtotal();
        
        return response()->json(compact('total', 'subtotal'));
    }
    
    public function remove($fooditemId)
    {
        $cart = session()->get('cart');
    
        if (isset($cart[$fooditemId])) {
            unset($cart[$fooditemId]);
            session()->put('cart', $cart);
        }
    
        // Return updated cart total and subtotal
        $total = $this->getCartTotal();
        $subtotal = $this->getCartSubtotal();
        
        return response()->json(compact('total', 'subtotal'));
    }
    
    // Calculate the cart subtotal (total price without taxes or discounts)
    private function getCartSubtotal()
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;
    
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity']; // Multiply price by quantity for each item
        }
    
        return $subtotal;
    }
    
    // Calculate the total (including tax, discounts, etc.)
    private function getCartTotal()
    {
        $subtotal = $this->getCartSubtotal();
    
        // Tax calculation (you can modify this logic as needed)
        $taxRate = 0.1; // Example: 10% tax
        $tax = $subtotal * $taxRate;
    
        // Example: total = subtotal + tax
        $total = $subtotal + $tax;
    
        return $total;
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