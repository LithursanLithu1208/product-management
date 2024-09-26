<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Method to display the form for creating a new product
    public function create()
    {
        return view('products.create');
    }

    // Method to store the new product
    
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'model_number' => 'required|string|max:255',
            'category' => 'required|string',
            'product_details' => 'required|string',
            'how_to_use' => 'required|string',
            'shipping_details' => 'required|string',
            'price.*' => 'required|numeric',
            'weight.*' => 'required|numeric',
            'qty_of_box.*' => 'required|integer',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'small_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Create a new Product instance with the validated data
        $product = new Product($request->except(['main_image', 'small_images', 'price', 'weight', 'qty_of_box']));
    
        // Handle main image upload
        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('products', 'public');
            $product->main_image = $path;
        }
    
        // Handle small images upload
        if ($request->hasFile('small_images')) {
            $smallImages = [];
            foreach ($request->file('small_images') as $image) {
                $path = $image->store('products', 'public');
                $smallImages[] = $path;
            }
            $product->small_images = json_encode($smallImages); // Store small images as JSON
        }
    
        // Handle price, weight, and qty_of_box as arrays
        $prices = $request->input('price', []);
        $weights = $request->input('weight', []);
        $qtyOfBoxes = $request->input('qty_of_box', []);
    
        // Combine prices, weights, and quantities into a single array
        $combinedData = [];
        $count = max(count($prices), count($weights), count($qtyOfBoxes));
        
        for ($i = 0; $i < $count; $i++) {
            $combinedData[] = [
                'price' => $prices[$i] ?? null,
                'weight' => $weights[$i] ?? null,
                'qty_of_box' => $qtyOfBoxes[$i] ?? null,
            ];
        }
    
        // Store combined data as JSON
        $product->prices = json_encode($combinedData);
    
        // Save the product to the database
        $product->save();
    
        // Redirect back to the create form with a success message
        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }
    

    // Method to display a specific product
    public function show($id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);

        // Pass the product data to the view
        return view('products.show', compact('product'));
    }

    public function index()
    {
        // Fetch products with pagination
        $products = Product::paginate(9); // Adjust the number to match your desired items per page
    
       
         return view('products.index', compact('products'));

    }

    
    public function edit($id)
{
    $product = Product::findOrFail($id);

    // Decode JSON data for prices, weights, and quantities
    $prices = json_decode($product->prices, true) ?? [];
    $product->prices = $prices;

    $smallImages = json_decode($product->small_images, true) ?? [];
    

    return view('products.edit', compact('product', 'smallImages'));
}



public function update(Request $request, $id)
{
    // Validate the request data
    $request->validate([
        'name' => 'required|string|max:255',
        'model_number' => 'required|string|max:255',
        'category' => 'required|string',
        'product_details' => 'required|string',
        'how_to_use' => 'required|string',
        'shipping_details' => 'required|string',
        'price.*' => 'nullable|numeric',
        'weight.*' => 'nullable|numeric',
        'qty_of_box.*' => 'nullable|integer',
        'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'small_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Find the product to update
    $product = Product::findOrFail($id);

    // Update product details
    $product->fill($request->except(['main_image', 'small_images', 'price', 'weight', 'qty_of_box']));

    // Handle main image upload
    if ($request->hasFile('main_image')) {
        // Delete old main image
        if ($product->main_image) {
            Storage::disk('public')->delete($product->main_image);
        }
        
        // Store new main image
        $path = $request->file('main_image')->store('products', 'public');
        $product->main_image = $path;
    }

    if ($request->hasFile('small_images')) {
        $smallImages = json_decode($product->small_images, true) ?? []; // Decode existing small images
        
        foreach ($request->file('small_images') as $index => $image) {
            // Delete the old small image if a new one is uploaded for the same index
            if (isset($smallImages[$index]) && $smallImages[$index]) {
                Storage::delete('public/' . $smallImages[$index]);
            }

            // Store the new image
            $path = $image->store('products', 'public');
            $smallImages[$index] = $path; // Save or update image path
        }

        $product->small_images = json_encode($smallImages); // Store updated small images as JSON
    }

    // Handle price, weight, and qty_of_box as arrays
    $prices = $request->input('price', []);
    $weights = $request->input('weight', []);
    $qtyOfBoxes = $request->input('qty_of_box', []);

    // Combine prices, weights, and quantities into a single array
    $combinedData = [];
    $count = max(count($prices), count($weights), count($qtyOfBoxes));
    
    for ($i = 0; $i < $count; $i++) {
        $combinedData[] = [
            'price' => $prices[$i] ?? null,
            'weight' => $weights[$i] ?? null,
            'qty_of_box' => $qtyOfBoxes[$i] ?? null,
        ];
    }

    // Store combined data as JSON
    $product->prices = json_encode($combinedData);

    // Save the updated product
    $product->save();

    // Redirect back to the edit form with a success message
    return redirect()->route('products.index', $product->id)->with('success', 'Product updated successfully!');
}

    


    public function destroy($id)
{
    // Find and delete the product
    $product = Product::findOrFail($id);
    $product->delete();

    // Set session message
    return redirect()->route('products.index')
                     ->with('delete_confirmation', 'Product deleted successfully.');
}

public function deleteImage(Request $request)
{
    $imageType = $request->input('image_type');
    $imageId = $request->input('image_id');
    $productId = $request->input('product_id');

    // Retrieve the product
    $product = Product::find($productId);

    if (!$product) {
        return response()->json(['success' => false, 'message' => 'Product not found']);
    }

    // Handle main image deletion
    if ($imageType === 'main_image' && $product->main_image) {
        $deleted = Storage::delete('public/' . $product->main_image);
        if ($deleted) {
            $product->main_image = null;
            $product->save();
            return response()->json(['success' => true, 'message' => 'Main image deleted']);
        } else {
            return response()->json(['success' => false, 'message' => 'Main image deletion failed']);
        }
    }

    // Handle small image deletion
    if ($imageType === 'small_images' && isset($product->small_images[$imageId])) {
        $smallImages = $product->small_images;
        $deleted = Storage::delete('public/' . $smallImages[$imageId]);
        if ($deleted) {
            unset($smallImages[$imageId]);
            $product->small_images = array_values($smallImages); // Re-index the array
            $product->save();
            return response()->json(['success' => true, 'message' => 'Small image deleted']);
        } else {
            return response()->json(['success' => false, 'message' => 'Small image deletion failed']);
        }
    }

    return response()->json(['success' => false, 'message' => 'Image deletion failed']);
}



    // Method to update an image
    public function updateImage(Request $request, $id)
    {
        $request->validate([
            'image_type' => 'required|string|in:main,small',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $imageType = $request->image_type;
        $imageFile = $request->file('image');

        if ($imageType === 'main') {
            if ($product->main_image) {
                Storage::delete('public/' . $product->main_image);
            }
            $path = $imageFile->store('products', 'public');
            $product->main_image = $path;
        } else {
            $smallImages = json_decode($product->small_images, true) ?? [];
            if ($imageFile) {
                $path = $imageFile->store('products', 'public');
                $smallImages[] = $path;
                $product->small_images = json_encode($smallImages);
            }
        }

        $product->save();

        return response()->json(['success' => true]);
    }


    
}
