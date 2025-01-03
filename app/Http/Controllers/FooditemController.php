<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Fooditem;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class FooditemController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $foodItems = Fooditem::paginate(10);
        return view('admin.fooditems.index', [
            'title' => 'Food Item'
        ] , compact('foodItems' , 'categories' , 'subcategories'));
    }

    public function create()
    {
        return view('admin.fooditems.create');
    }   

    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'price' => 'required|numeric|min:0',
            'status' => 'boolean',
            'image' => 'nullable|image',
            'description' => 'required|string',
             
        ]);
             //image store for first time 
        if ($request->hasFile('image')) {   
            $image = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('images/fooditem'), $image);
        }



        // Create a new food item
        $foodItem = new FoodItem();
        $foodItem->name = $request->name;
        $foodItem->category_id = $request->category_id;
        $foodItem->subcategory_id = $request->subcategory_id;
        $foodItem->price = $request->price;
        $foodItem->status = $request->has('status') ? $request->status : 0; // Default status is inactive (0)
        $foodItem->image = $image;
        $foodItem->description = $request->description;

        // Save the food item to the database
        $foodItem->save();

        // Redirect back with success message
        return redirect()->route('admin.fooditems.index')->with('success', 'Food item created successfully!');
    }

    public function edit($id)
    {  
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $fooditem = Fooditem::findOrFail($id);
        return view('admin.fooditem.edit', compact('fooditem','categories','subcategories'), [
            'title' => 'Manage Food Item'
        ]);
    }

    public function update(Request $request, $id)
    {
        $fooditem = Fooditem::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:fooditems,slug,' . $id,
            'price' => 'required|numeric',
            'image' => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            $image = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('images/fooditem'), $image);
            $data['image'] = $image;
        }

        $fooditem->update($data);

        return redirect()->route('admin.fooditems.index')->with('success', 'Food Item updated successfully');
    }

    public function destroy($id)
    {
        $fooditem = Fooditem::findOrFail($id);
        $fooditem->delete();

        return redirect()->route('admin.fooditems.index')->with('success', 'Food Item deleted successfully');
    }

    

}