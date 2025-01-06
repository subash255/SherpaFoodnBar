<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Get the number of entries per page from the request or default to 5
        $perPage = $request->get('entries', 5);
        
        // Paginate the orders without any search query
        $orders = Order::paginate($perPage);
        
        // Decode the 'items' JSON column for each order
        foreach ($orders as $order) {
            $order->items = json_decode($order->items, true);  // Decode the 'items' JSON column
        }
        
        // Return the view with the paginated orders
        return view('admin.order.index', [
            'title' => 'Orders',
            'orders' => $orders
        ]);
    }
    

    public function destroy($id)
    {
        $order = Order::find($id);
        $order->delete();
        return redirect()->route('admin.order.index')->with('success', 'Order deleted successfully');
    }
   
    
}
