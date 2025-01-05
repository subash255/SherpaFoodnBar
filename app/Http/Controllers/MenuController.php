<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Fooditem;
use App\Models\Order;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $fooditems = Fooditem::all();
        $categories = Category::with('fooditems')->get();
        return view('menu.index', compact('categories', 'fooditems'));
    }

    public function store(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'notes' => 'nullable|string',
        ]);

        $fooditem = Fooditem::findOrFail($id);
        $data['fooditem_id'] = $fooditem->id;
        $data['order_number'] = 'ORD' . strtoupper(uniqid());
        $data['status'] = 'pending';

        Order::create($data);

        return redirect()->route('menu.index')->with('success', 'Order placed successfully');

    }

}
