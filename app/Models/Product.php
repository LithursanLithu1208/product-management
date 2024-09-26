<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Define the fillable attributes
    protected $fillable = [
        'name',
        'model_number',
        'category',
        'product_details',
        'how_to_use',
        'shipping_details',
        'price',
        'weight',
        'qty_of_box',
        'main_image',  // Add this
        'small_images', // Add this
    ];

    // Cast small_images to array when retrieved
    protected $casts = [
        'small_images' => 'array',
    ];

    
}
