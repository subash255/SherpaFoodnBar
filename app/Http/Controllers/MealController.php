<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;

class MealController extends Controller
{
   
    public function index()
    {
        $meals = Meal::paginate(5);
        return view('admin.meal.index', compact('meals'), [
            'title' => 'Meals'
        ]);
    }

    public function create()
    {
        return view('admin.meal.create');
    }

    public function store(Request $request)
    {
        // Validate category name and image, but handle slug on client-side
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

  
      
  
        // Create the category
        Meal::create($data);
        
        return redirect()->route('admin.meal.index')->with('success', 'meal added successfully');
    }
    


    // Show Edit Form
    public function edit($id)
    {
        $meal = Meal::findOrFail($id);
        return view('admin.meal.edit', compact('meal'), [
            'title' => 'Manage Meal'
        ]);
    }

    // Update Category
    public function update(Request $request,$id)
    {
        $meal = Meal::findOrFail($id);
        $meal->name = $request->name;
        $meal->save();

    
        return redirect()->route('admin.meal.index')->with('success', 'meals updated successfully');
    }
    

    // Delete Category
    public function destroy($id)
    {
        $meal = Meal::findOrFail($id);

       

        $meal->delete();

        return redirect()->route('admin.meal.index')->with('success', 'meal deleted successfully');
    }

    // Update Category Status (Toggle Visibility)
    public function updateToggle(Request $request, $categoryId)
    {
        $category = Meal::find($categoryId);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Category not found.']);
        }

        // Update status field based on the request type
        if ($request->type === 'status') {
            $category->status = $request->state;
        }

        $category->save();

        return response()->json(['success' => true]);
    }
}



