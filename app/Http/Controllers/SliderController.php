<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class SliderController extends Controller
{
    public function create()
    {
        return view('slider.addslider'); // Ensure the view exists at resources/views/slider/addslider.blade.php
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'slider_details' => 'required|string|max:255',
            'button_name' => 'required|string|max:255',
            'nav_link' => 'required|string|max:255',
        ]);
    
        // Handle file upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '-' . $image->getClientOriginalName(); // Append timestamp to avoid name conflicts
            $image->storeAs('public/slider_images', $imageName); // Store with a unique name
    
            // Store data in the database
            Slider::create([
                'image' => $imageName,
                'slider_details' => $request->input('slider_details'),
                'button_name' => $request->input('button_name'),
                'nav_link' => $request->input('nav_link'),
            ]);
        }
    
        return redirect()->route('slider.index')->with('success', 'Slider added successfully'); // Redirect to index
    }
    
    public function show()
    {
        $sliders = Slider::all();
        return view('showslider', compact('sliders')); // Ensure the view exists at resources/views/showslider.blade.php
    }

    public function index()
    {
        // Fetch all sliders from the database
        $sliders = Slider::all();
        
        // Return the view with the sliders data
        return view('slider.index', compact('sliders')); // Ensure the view exists at resources/views/slider/index.blade.php
    }

    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('slider.edit', compact('slider'));
    }

    // Update the specified slider in the database
    public function update(Request $request, $id)
{
    $request->validate([
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'slider_details' => 'required|string|max:255',
        'button_name' => 'required|string|max:255',
        'nav_link' => 'required|string|max:255',
    ]);

    $slider = Slider::findOrFail($id);

    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($slider->image) {
            Storage::disk('public')->delete('slider_images/' . $slider->image);
        }

        $image = $request->file('image');
        $imageName = $image->getClientOriginalName(); // Use the original file name
        $image->storeAs('slider_images', $imageName, 'public');

        $slider->image = $imageName;
    }

    $slider->slider_details = $request->input('slider_details');
    $slider->button_name = $request->input('button_name');
    $slider->nav_link = $request->input('nav_link');

    $slider->save();

    return redirect()->route('slider.index')->with('success', 'Slider updated successfully');
}
public function destroy($id)
{
    // Find the slider by ID
    $slider = Slider::findOrFail($id);

    // Delete the associated image if it exists
    if ($slider->image) {
        // Use Storage facade to delete the image from the public disk
        Storage::disk('public')->delete('slider_images/' . $slider->image);
    }

    // Delete the slider record from the database
    $slider->delete();

    // Redirect back to the slider index page with a success message
    return redirect()->route('slider.index')->with('success', 'Slider deleted successfully');
}

}
