@extends('layouts.app')

@section('content')

<div class="container mt-5">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h6>Slider Management</h6>
    <div class="content-wrapper">
        <div class="slider-management-container">
            <div class="header-container">
                <div class="slider-management-header">
                    <a href="{{ route('slider.create') }}" class="add-new-slider-btn" style="width: 234px; height: 40px; background-color: #2C1708;">ADD NEW SLIDER</a>
                </div>
            </div>
            <table class="table slider-management-table">
                <thead>
                    <tr>
                        <th>Slider Image</th>
                        <th>Slider Button</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sliders as $index => $slider)
                        <tr>
                            <td class="image-cell">
                                <span class="slider-number">{{ $index + 1 }}</span>
                                <div class="image-container">
                                    <img src="{{ asset('storage/slider_images/' . $slider->image) }}" alt="Slider Image" class="slider-image">
                                </div>
                            </td>
                            <td>{{ $slider->button_name }}</td>
                            <td>
                                <a href="{{ route('slider.edit', $slider->id) }}" class="btn btn-link p-0 me-5" title="Edit">
                                    <i class="fas fa-pen" style="color: black;"></i>
                                </a>
                                <form action="{{ route('slider.destroy', $slider->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link p-0 me-5" style="color:black; background:none; border:none; cursor:pointer;" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<link rel="stylesheet" href="{{ asset('css/slider_style.css') }}">

@endsection
