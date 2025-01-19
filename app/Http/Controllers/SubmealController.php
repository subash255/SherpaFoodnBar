<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Submeal;
use Illuminate\Http\Request;

class SubmealController extends Controller
{
    public function index($id)
    {
        // Fetch the meal by ID
        $meal = Meal::findOrFail($id);
    
        // Fetch related submeals with pagination
        $submeals = $meal->submeals()->paginate(10); // 10 items per page
    
        // Pass both variables to the view
        return view('admin.submeal.index', compact('meal', 'submeals'), [
            'title' => 'Sub meals'
        ]);
    }
    
    

   

    // Store the new subcategory
    public function store(Request $request)
    {
        // Validate the incoming data
        $data = $request->validate([
            'meal_id' => 'required|exists:meals,id', // Ensure category exists
            'name' => 'required|string|max:255',
        ]);
    
        // Create the subcategory and save it to the database
        Submeal::create([
            'meal_id' => $data['meal_id'],
            'name' => $data['name'],
        ]);
    
        // Redirect to the index page with a success message
        return redirect()->route('admin.submeal.index', ['id' => $request->meal_id])
                         ->with('success', 'Submeal created successfully!');
    }
    public function edit($id)
    {
        // Find the subcategory by ID or show an error if not found
        $submeals = Submeal::findOrFail($id);
    
        // Fetch categories for the category dropdown list
        $meals = Meal::all();
    
        // Pass only the necessary variables to the view
        return view('admin.submeal.edit', compact('submeals', 'meals'), [
            'title' => 'Manage submeals'
        ] );
    }
    
    

    // Get subcategories by category ID for dynamic dropdowns
    public function getSubcategoriesByCategory($mealId)
    {
        $subcategories = Submeal::where('category_id', $mealId)->get();
        return response()->json($subcategories);
    }

    // Update an existing subcategory
    public function update(Request $request, $id)
{
    $submeal = Submeal::findOrFail($id);
    
    // Validate the incoming data
    $data = $request->validate([
        'meal_id' => 'required|exists:meals,id',
        'name' => 'required|string|max:255',
        
    ]);
      
    // Save the updated subcategory
    $submeal->update($data);


   


    // Redirect back with a success message
    return redirect()->route('admin.submeal.index',['id' => $request->meal_id])->with('success', 'submeal updated successfully!');
}


public function destroy($id)
{
    // Find the submeal by ID or fail
    $submeal = Submeal::findOrFail($id);

    // Get the meal_id (meal relationship) associated with this submeal
    $meal_id = $submeal->meal_id; // Assuming the foreign key is 'meal_id'

    // Delete the submeal
    $submeal->delete();

    // Redirect to the submeal index page for the specific meal with a success message
    return redirect()->route('admin.submeal.index', ['id' => $meal_id])
                     ->with('success', 'Submeal deleted successfully!');
}


    public function updateToggle(Request $request, $subcategoryId)
    {
        // Find the subcategory by ID or return an error if not found
        $subcategory = submeal::find($subcategoryId);

        if (!$subcategory) {
            return response()->json(['success' => false, 'message' => 'Subcategory not found.']);
        }

        // Update the status field based on the request state (1 for active, 0 for inactive)
        $subcategory->status = $request->state;
        $subcategory->save();

        // Return success response
        return response()->json(['success' => true, 'status' => $subcategory->status]);
    }
}
