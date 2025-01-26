<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    // Display a listing of the banners
    public function index()
    {
        $banners = Banner::all();
        $assignedPriorities = Banner::pluck('priority')->toArray();
        $availablePriorities = range(1, 10);
        $availablePriorities = array_diff($availablePriorities, $assignedPriorities);
        return view('admin.banner.index', compact('banners', 'availablePriorities'), [
            'title' => 'Manage Banners'
        ]);
    }

    // Show the form for creating a new banner
    public function create()
    {
        $assignedPriorities = Banner::pluck('priority')->toArray();
        $availablePriorities = range(1, 10); // Example range of priorities
        $availablePriorities = array_diff($availablePriorities, $assignedPriorities);
        return view('admin.banner.create', compact('availablePriorities'));
    }

    // Store a newly created banner in the database
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'priority' => 'nullable|integer',
        ]);

        // Handle file upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('banner'), $image);


            Banner::create([
                'image' => $image,
                'priority' => $request->input('priority', 0),
            ]);

            return redirect()->route('admin.banner.index')->with('success', 'Banner created successfully.');
        }
    }

    // Display the specified banner
    public function show($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banner.show', compact('banner'));
    }

    // Show the form for editing the specified banner
    public function edit($id)
    {
        $assignedPriorities = Banner::pluck('priority')->toArray();
        $availablePriorities = range(1, 10);
        $availablePriorities = array_diff($availablePriorities, $assignedPriorities);
        $banner = Banner::findOrFail($id);
        return view('admin.banner.edit', compact('banner', 'availablePriorities'), [
            'title' => 'Manage Banners'
        ]);
    }

    // Update the specified banner in the database
    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'priority' => 'nullable|integer',
        ]);

        // If a new image is uploaded
        if ($request->hasFile('image')) {
            // Delete old image if exists
            $oldImagePath = public_path('banner/' . $banner->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            // Upload new image
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('banner'), $imageName);
            $banner->image = $imageName;
        }
        // Update other fields
        $banner->priority = $request->input('priority', $banner->priority);
        $banner->save();

        return redirect()->route('admin.banner.index')->with('success', 'Banner updated successfully.');
    }

    // Remove the specified banner from the database
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        // Delete the image file
        if (file_exists(public_path('storage/' . $banner->image))) {
            unlink(public_path('storage/' . $banner->image));
        }

        $banner->delete();

        return redirect()->route('admin.banner.index')->with('success', 'Banner deleted successfully.');
    }
}
