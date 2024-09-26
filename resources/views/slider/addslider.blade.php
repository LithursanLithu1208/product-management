@extends('layouts.app')

@section('content')

<div class="container mt-5 mb-5">
    <p class="mb-4 text-black " ><a class="text-black" href="{{ route('slider.index') }}" style="text-decoration: none; font-size: 16px "><b>Slider Management</b></a><b> > Add Slider</b></p>

    <div class="d-flex justify-content-center w-100 mb-5">
        <!-- 3D Effect Form Container -->
        <form action="{{ route('storeSlider') }}" method="POST" enctype="multipart/form-data" class="form-3d p-4 mt-3" style="max-width: 600px; width: 100%;">
            @csrf
            <!-- Image Upload Section -->
            <div class="mb-4">
                <p class="mb-2">Upload Image</p>
                <div class="upload-area" id="uploadArea">
                    <span class="text-muted fs-1">+</span>
                    <button type="button" class="close-btn "><i class="fa-regular fa-trash-can"></i></button>
                </div>
                <input type="file" id="imageUpload" name="image" class="d-none" accept="image/*">
            </div>


            <div class="mb-3">
                <label for="slider_details" class="form-label">Slider Details</label>
                <input type="text" class="form-control @error('slider_details') is-invalid @enderror" name="slider_details" id="slider_details" required>
                @error('slider_details')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3">
                <label for="button_name" class="form-label">Button Name</label>
                <input type="text" class="form-control" name="button_name" id="button_name" required>
            </div>
            
            <div class="mb-3">
                <label for="nav_link" class="form-label">Nav Link</label>
                <input type="text" class="form-control" name="nav_link" id="nav_link" required>
            </div>
            <button type="submit" class="btn text-white w-100" style="background-color: #2C1708;">Save</button>
        </form>
    </div>
</div>





<link rel="stylesheet" href="{{ asset('css/slider_style.css') }}">
@endsection
