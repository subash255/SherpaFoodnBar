<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // Add this import

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(5);
        return view('admin.category.index', compact('categories'), [
            'title' => 'Category'
        ]);
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        // Validate category name and image, but handle slug on client-side
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',  // Allow slug to be nullable
            'image' => 'required|image',
        ]);

        // Handle the image upload
        $image = time() . '.' . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(public_path('images/brand'), $image);
        $data['image'] = $image;
  
        // Create the category
        Category::create($data);
        
        return redirect()->route('admin.category.index')->with('success', 'Category created successfully');
    }
    


    // Show Edit Form
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'), [
            'title' => 'Manage Category'
        ]);
    }

    // Update Category
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
    
        // Update the validation to expect 'name' instead of 'category_name'
        $request->validate([
            'name' => 'required|string|max:255', // 'name' instead of 'category_name'
            'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
            'image' => 'nullable|image',
        ]);
    
        // Update the category data
        $category->name = $request->name; // Use 'name' here, as per the migration
        $category->slug = $request->slug;
    
        // Handle the image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Delete the old image if exists
            $oldImagePath = public_path('images/brand/' . $category->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
    
            // Upload the new image
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/brand'), $imageName);
            $category->image = $imageName;
        }
    
        // Save the updated category
        $category->save();
    
        return redirect()->route('admin.category.index')->with('success', 'Category updated successfully');
    }
    

    // Delete Category
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Delete the image
        $imagePath = public_path('images/brand/' . $category->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $category->delete();

        return redirect()->route('admin.category.index')->with('success', 'Category deleted successfully');
    }

    // Update Category Status (Toggle Visibility)
    public function updateToggle(Request $request, $categoryId)
    {
        $category = Category::find($categoryId);

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

