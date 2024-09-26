<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('slider_details');
            $table->string('button_name');
            $table->string('nav_link');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('sliders');
    }
    
};
