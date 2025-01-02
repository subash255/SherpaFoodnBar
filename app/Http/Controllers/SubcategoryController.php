<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index()
    {
        // Fetch the subcategories and categories
        $subcategories = Subcategory::paginate(5);
        $categories = Category::all(); // Fetch all categories
    
        // Pass both variables to the view
        return view('admin.subcategory.index', compact('subcategories', 'categories'), [
            'title' => 'Sub Category'
        ]);
    }
    

    // Show the form for creating a subcategory
    public function create()
    {
        // Eager load categories with their subcategories
        $categories = Category::all();
        return view('admin.subcategory.create', compact('categories'));
    }

    // Store the new subcategory
    public function store(Request $request)
    {
        // Validate the incoming data
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id', // Ensure category exists
            'subcategory_name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:subcategories,slug', // Check uniqueness in subcategories table
            'paragraph' => 'nullable|string',
        ]);

        // Create the subcategory and save it to the database
        Subcategory::create([
            'category_id' => $data['category_id'],
            'subcategory_name' => $data['subcategory_name'],
            'slug' => $data['slug'], // Save the generated or provided slug
            'paragraph' => $data['paragraph'],
        ]);

        // Redirect to the index page with a success message
        return redirect()->route('admin.subcategory.index')->with('success', 'Subcategory created successfully!');
    }

    public function edit($id)
    {
        // Find the subcategory by ID or show an error if not found
        $subcategory = Subcategory::findOrFail($id);
    
        // Fetch categories for the category dropdown list
        $categories = Category::all();
    
        // Pass only the necessary variables to the view
        return view('admin.subcategory.edit', compact('subcategory', 'categories'), [
            'title' => 'Manage SubCategory'
        ]);
    }
    
    

    // Get subcategories by category ID for dynamic dropdowns
    public function getSubcategoriesByCategory($categoryId)
    {
        $subcategories = Subcategory::where('category_id', $categoryId)->get();
        return response()->json($subcategories);
    }

    // Update an existing subcategory
    public function update(Request $request, $id)
    {
        // Validate the incoming data
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id', // Ensure category exists
            'subcategory_name' => 'required|string|max:255',
            'paragraph' => 'nullable|string',
        ]);

        // Find the subcategory by ID or fail
        $subcategory = Subcategory::findOrFail($id);

        // Update the subcategory with the validated data
        $subcategory->category_id = $data['category_id'];
        $subcategory->subcategory_name = $data['subcategory_name'];
        $subcategory->paragraph = $data['paragraph'];

        // Save the updated subcategory
        $subcategory->save();

        // Redirect back with a success message
        return redirect()->route('admin.subcategory.index')->with('success', 'Subcategory updated successfully!');
    }

    // Delete a subcategory
    public function destroy($id)
    {
        // Find the subcategory by ID or fail
        $subcategory = Subcategory::findOrFail($id);

        // Delete the subcategory
        $subcategory->delete();

        // Redirect to the subcategory index with a success message
        return redirect()->route('admin.subcategory.index')->with('success', 'Subcategory deleted successfully!');
    }

    public function updateToggle(Request $request, $subcategoryId)
    {
        // Find the subcategory by ID or return an error if not found
        $subcategory = Subcategory::find($subcategoryId);

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

