@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <p class="mb-4 text-black " ><a class="text-black" href="{{ route('products.index') }}" style="text-decoration: none; font-size: 16px "><b>Product Management</b></a><b> > Add Product</b></p>
    
    
    <!-- Centered Form Container -->
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="form-container p-4 bg-white rounded shadow-lg mb-5">
                
                <!-- Display Success or Error Messages -->
                {{-- @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif --}}

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Product Information Fields -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="model_number" class="form-label">Model Number</label>
                        <input type="text" class="form-control" id="model_number" name="model_number" required>
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Categories</label>
                        <select class="form-select" id="category" name="category" required>
                            <option selected disabled>Select a category</option>
                            <option value="Category 1">Category 1</option>
                            <option value="Category 2">Category 2</option>
                            <!-- More categories -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="product_details" class="form-label">Product Details</label>
                        <textarea class="form-control" id="product_details" name="product_details" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="how_to_use" class="form-label">How to Use</label>
                        <textarea class="form-control" id="how_to_use" name="how_to_use" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="shipping_details" class="form-label">Shipping Details</label>
                        <textarea class="form-control" id="shipping_details" name="shipping_details" rows="3" required></textarea>
                    </div>

                    <table class="table mb-3" id="productTable">
    <thead>
        <tr>
            <th>Price</th>
            <th>Weight</th>
            <th>QTY of a box</th>
        </tr>
    </thead>
    <tbody>
        <!-- Initial row (can be empty or contain default values) -->
        <tr id="row-1">
            <td>
                <input type="" class="form-control no-border" name="price[]" step="0.01" required>
            </td>
            <td>
                <input type="" class="form-control no-border" name="weight[]" step="0.01" required>
            </td>
            <td>
                <input type="" class="form-control no-border" name="qty_of_box[]" required>
            </td>
        </tr>
    </tbody>
</table>

<div class="d-flex justify-content-center mb-3">
    <button type="button" id="add-row" class="btn btn-secondary w-100" style="background-color: #2C1708;">
        <i class="fas fa-plus"></i> Add Row
    </button>
</div>

                    <!-- Image Upload Section -->
<!-- Image Upload Section -->
<div class="container mt-4">
    <p class="text-center">Upload Image</p>
    <div class="row justify-content-center pd-5 px-5">
        <!-- Main Image Upload -->
        <div class="col-md-8 d-flex justify-content-center mb-2">
            <div class="upload-container main-upload d-flex justify-content-center align-items-center">
                <img id="mainImagePreview" alt="Image preview" style="display: none;" />
                <input type="file" name="main_image" id="mainImage" style="display: none;" />
                <button class="upload-icon btn" type="button" onclick="document.getElementById('mainImage').click();">+</button>
            </div>
        </div>
        <!-- Small Image Uploads -->
        <div class="col-md-4">
            <div class="row justify-content-center">
                <div class="col-12 mb-2 d-flex justify-content-center">
                    <div class="upload-container2 small-upload d-flex justify-content-center align-items-center">
                        <img id="smallImagePreview1" alt="Image preview" style="display: none;" />
                        <input type="file" name="small_images[]" id="smallImage1" style="display: none;" />
                        <button class="upload-icon btn" type="button" onclick="document.getElementById('smallImage1').click();">+</button>
                    </div>
                </div>
                <!-- Repeat for other small uploads -->
                <div class="col-12 mb-2 d-flex justify-content-center">
                    <div class="upload-container2 small-upload d-flex justify-content-center align-items-center">
                        <img id="smallImagePreview2" alt="Image preview" style="display: none;" />
                        <input type="file" name="small_images[]" id="smallImage2" style="display: none;" />
                        <button class="upload-icon btn" type="button" onclick="document.getElementById('smallImage2').click();">+</button>
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <div class="upload-container2 small-upload d-flex justify-content-center align-items-center">
                        <img id="smallImagePreview3" alt="Image preview" style="display: none;" />
                        <input type="file" name="small_images[]" id="smallImage3" style="display: none;" />
                        <button class="upload-icon btn" type="button" onclick="document.getElementById('smallImage3').click();">+</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


                    <div class="d-flex justify-content-center ">
                        <button type="submit" class="btn  mt-4 text-white" style="background-color: #2C1708;">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

