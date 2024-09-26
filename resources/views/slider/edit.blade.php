@extends('layouts.app')

@section('content')

<div class="container mt-5 mb-5">
    <p class="mb-4 text-black " ><a class="text-black" href="{{ route('slider.index') }}" style="text-decoration: none; font-size: 16px "><b>Slider Management</b></a><b> > Edit Slider</b></p>

    <div class="d-flex justify-content-center w-100 mb-5">
        <!-- 3D Effect Form Container -->
        <form action="{{ route('slider.update', $slider->id) }}" method="POST" enctype="multipart/form-data" class="form-3d p-4 mt-3" style="max-width: 600px; width: 100%;">
            @csrf
            @method('PUT')
            <!-- Image Upload Section -->
            <div class="row mb-3">
                <div class="col-12 d-flex justify-content-center">
                    <div class="upload-container main-upload d-flex justify-content-center align-items-center">
                        <img id="mainImagePreview" src="{{ asset('storage/slider_images/' . $slider->image) }}" alt="Image preview" style="display: block;" />
                        <input type="file" name="image" id="image" style="display: none;" onchange="previewMainImage(event)" />
                        <button class="upload-icon btn" type="button" onclick="document.getElementById('image').click();">+</button>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="slider_details" class="form-label">Slider Details</label>
                <input type="text" class="form-control @error('slider_details') is-invalid @enderror" name="slider_details" id="slider_details" value="{{ old('slider_details', $slider->slider_details) }}" required>
                @error('slider_details')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="button_name" class="form-label">Button Name</label>
                <input type="text" class="form-control" name="button_name" id="button_name" value="{{ old('button_name', $slider->button_name) }}" required>
            </div>
            <div class="mb-3">
                <label for="nav_link" class="form-label">Nav Link</label>
                <input type="text" class="form-control" name="nav_link" id="nav_link" value="{{ old('nav_link', $slider->nav_link) }}" required>
            </div>
            <button type="submit" class="btn w-100" style="background-color: #2C1708;">>Update</button>
        </form>
    </div>
</div>


<link rel="stylesheet" href="{{ asset('css/slider_style.css') }}">

@endsection
