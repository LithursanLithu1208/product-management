<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    // Specify the table name if it's different from the model name
    // protected $table = 'sliders';

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'image',
        'slider_details',
        'button_name',
        'nav_link',
    ];

   
}
