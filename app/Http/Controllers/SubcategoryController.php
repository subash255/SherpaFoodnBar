<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index($id)
    {
        // Fetch the subcategories and categories

        $categories = Category::findorfail($id); // Fetch all categories
        $subcategories = $categories->subcategories()->paginate(10); // 10 items per page
        // Fetch subcategories for the selected category  

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
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:subcategories,slug', // Check uniqueness in subcategories table
            'image' => 'required|image',
        ]);
        $image = time() . '.' . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(public_path('images/brand'), $image);
        $data['image'] = $image;



        // Create the subcategory and save it to the database
        Subcategory::create([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'slug' => $data['slug'], // Save the generated or provided slug
            'image' => $data['image'],

        ]);


        // Redirect to the index page with a success message
        return redirect()->route('admin.subcategory.index', ['id' => $request->category_id])->with('success', 'Subcategory created successfully!');
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
        // Find the subcategory by ID or fail
        $subcategory = Subcategory::findOrFail($id);

        // Validate the incoming data
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id', // Ensure category exists
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:subcategories,slug,' . $id, // Check uniqueness in subcategories table   
            'image' => 'nullable|image', // Validate image is either null or an image file
        ]);

        // Initialize $imageName to keep the old image name if no new image is uploaded
        $imageName = $subcategory->image;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            $oldImagePath = public_path('images/brand/' . $subcategory->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            // Upload new image
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();  // Generate a unique name for the image
            $image->move(public_path('images/brand'), $imageName);  // Move the image to the directory
        }

        // Update the subcategory with the validated data
        $subcategory->category_id = $data['category_id'];
        $subcategory->name = $data['name'];
        $subcategory->slug = $data['slug'];
        $subcategory->image = $imageName; // Update the image name (old or new)

        // Save the updated subcategory
        $subcategory->save();

        // Redirect back with a success message
        return redirect()->route('admin.subcategory.index', ['id' => $request->category_id])->with('success', 'Subcategory updated successfully!');
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
