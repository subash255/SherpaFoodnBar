<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::paginate(5);
        return view('admin.order.index', [
            'title' => 'Orders'], compact('orders'));
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        $order->delete();
        return redirect()->route('admin.order.index')->with('success', 'Order deleted successfully');
    }
   
    
}
