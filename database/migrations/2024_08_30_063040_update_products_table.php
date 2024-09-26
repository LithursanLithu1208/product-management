<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop existing columns if they exist
            $table->dropColumn(['price', 'weight', 'qty_of_box']);

            // Add new columns for array data
            $table->json('prices')->nullable();
            $table->json('weights')->nullable();
            $table->json('qty_of_boxes')->nullable();
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Revert changes if rolling back
            $table->decimal('price', 8, 2)->after('shipping_details');
            $table->decimal('weight', 8, 2)->after('price');
            $table->integer('qty_of_box')->after('weight');

            // Drop new columns if rolling back
            $table->dropColumn(['prices', 'weights', 'qty_of_boxes']);
        });
    }
}
