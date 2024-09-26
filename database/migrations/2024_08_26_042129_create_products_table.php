<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('model_number');
            $table->string('category');
            $table->text('product_details');
            $table->text('how_to_use');
            $table->text('shipping_details');
            $table->decimal('price', 8, 2);
            $table->decimal('weight', 8, 2);
            $table->integer('qty_of_box');
            $table->string('main_image')->nullable(); // New column for main image
            $table->json('small_images')->nullable(); // New column for small images
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
