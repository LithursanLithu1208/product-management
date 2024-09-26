<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category; // Ensure you have a Category model
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    // Show the form for creating a new category
    public function create()
    {
        return view('category.addcategory');
    }

    // Store a newly created category in storage
    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle the image upload
        if ($request->hasFile('category_image')) {
            $imageName = time() . '.' . $request->category_image->extension();
            $request->category_image->storeAs('public/categories', $imageName);
        }

        // Save the category to the database
        Category::create([
            'name' => $request->input('category_name'),
            'image' => $imageName,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    // Display a listing of the categories
    public function index()
    {
        $categories = Category::all(); // Retrieve all categories
        return view('category.index', compact('categories'));
    }

    // Show the form for editing the specified category
    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    // Update the specified category in storage
    public function update(Request $request, Category $category)
    {
        // Validate the input
        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update the category name
        $category->name = $request->input('category_name');

        // Handle the image upload
        if ($request->hasFile('category_image')) {
            // Delete the old image if it exists
            if ($category->image) {
                Storage::delete('public/categories/' . $category->image);
            }

            // Store the new image
            $imageName = time() . '.' . $request->category_image->extension();
            $request->category_image->storeAs('public/categories', $imageName);
            $category->image = $imageName;
        }

        // Save the changes to the category
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    // Remove the specified category from storage
    public function destroy(Category $category)
    {
        // Delete the category image if it exists
        if ($category->image) {
            Storage::delete('public/categories/' . $category->image);
        }

        // Delete the category record
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
