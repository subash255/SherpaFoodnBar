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
        
        // Get the selected status from the request (if any)
        $status = $request->get('status');
        
        // Initialize the query builder
        $query = Order::query();

        // If a status filter is provided, add a where condition
        if ($status) {
            $query->where('status', $status);
        }

        // Paginate the orders with the applied filters
        $orders = $query->paginate($perPage);
        
        // Decode the 'items' JSON column for each order
        foreach ($orders as $order) {
            $order->items = json_decode($order->items, true);  // Decode the 'items' JSON column
        }
        
        // Return the view with the paginated orders and the selected status filter
        return view('admin.order.index', [
            'title' => 'Orders',
            'orders' => $orders,
            'selectedStatus' => $status // Pass the selected status to the view
        ]);
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        $order->delete();
        return redirect()->route('admin.order.index')->with('success', 'Order deleted successfully');
    }
}
