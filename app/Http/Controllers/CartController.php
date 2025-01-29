<?php

namespace App\Http\Controllers;

use App\Models\Fooditem;
use App\Models\Order;
use App\Services\VismaPayService;
use Illuminate\Http\Request;
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
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:15',
        'payment_method' => 'required|string|in:online,cash_on_pickup',
        'cart_data' => 'required|string',
    ]);

    if ($validator->fails()) {
        return redirect()->route('cart.index')
            ->withErrors($validator)
            ->withInput();
    }

    // Decode cart data from session
    $cart = session()->get('cart', []);

    if (empty($cart)) {
        return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
    }

    // Calculate total price
    $total = array_sum(array_map(function ($item) {
        return $item['price'] * $item['quantity'];
    }, $cart));

    // Generate unique order number
    $orderNumber = strtoupper(uniqid('ORD-'));

    // Create the order
    $order = Order::create([
        'order_number' => $orderNumber,
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'status' => 'pending',
        'total' => $total,
        'payment_method' => $request->payment_method,
        'items' => json_encode($cart),
    ]);

    // If the payment method is online, redirect to payment page
    if ($request->payment_method == 'online') {
        // Construct payment URL (adjust as needed based on VismaPay's instructions)
        $paymentUrl = "https://vismapay.com/payment?order_number={$order->order_number}&amount={$order->total}&currency=USD&email={$order->email}&return_url=" . route('cart.sucess', ['orderNumber' => $order->order_number]) . "&cancel_url=" . route('cart.cancel', ['orderNumber' => $order->order_number]);
        
        // Redirect to VismaPay's payment page
        return redirect()->to($paymentUrl);
    }

    // Clear the cart from session after successful payment redirection or if cash on pickup
    session()->forget('cart');

    // Redirect with success message
    return redirect()->route('cart.index')->with('success', 'Order placed successfully!');
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