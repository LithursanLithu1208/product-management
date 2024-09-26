<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDetailController;

// Set the index page as the home page
Route::get('/', [ProductController::class, 'index'])->name('home');

// Routes for products management
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

// Ensure index route is defined
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Route to delete an image
Route::delete('/products/{id}/delete-image', [ProductController::class, 'deleteImage'])->name('products.deleteImage');

// Route to update an image
Route::post('/products/{id}/update-image', [ProductController::class, 'updateImage'])->name('products.updateImage');

// Route to update an image
use App\Http\Controllers\SliderController;
Route::get('/slider', [SliderController::class, 'index'])->name('slider.index');
Route::get('/slider/create', [SliderController::class, 'create'])->name('slider.create');
Route::post('/slider', [SliderController::class, 'store'])->name('storeSlider');
Route::get('/slider/{id}/edit', [SliderController::class, 'edit'])->name('slider.edit');
Route::put('/slider/{id}', [SliderController::class, 'update'])->name('slider.update');
Route::delete('/slider/{id}', [SliderController::class, 'destroy'])->name('slider.destroy');


Route::post('/delete-image', [ProductController::class, 'deleteImage'])->name('delete-image');

use App\Http\Controllers\CategoryController;

// Route to display the form to create a new category
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');

// Route to store a new category
Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');

// Route to edit a category
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');

// Route to update a category
Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');

// Route to delete a category
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

// Optional: You can use resourceful routing to handle standard actions if you want to simplify.
Route::resource('categories', CategoryController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);

Route::resource('categories', CategoryController::class);