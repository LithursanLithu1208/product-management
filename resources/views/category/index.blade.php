@extends('layouts.app')

@section('content')

<div class="container mt-5">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h6>Category Management</h6>
    <div class="content-wrapper">
        <div class="category-management-container">
            <div class="header-container">
                <div class="category-management-header">
                    <a href="{{ route('categories.create') }}" class="add-new-category-btn" style="width: 234px; height: 40px; background-color: #2C1708;">ADD NEW CATEGORY</a>
                </div>
            </div>
            <table class="table category-management-table">
                <thead>
                    <tr>
                        <th>Category Image</th>
                        <th>Category Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $index => $category)
                        <tr>
                            <td class="image-cell">
                                <span class="category-number">{{ $index + 1 }}</span>
                                <div class="image-container">
                                    <img src="{{ asset('storage/categories/' . $category->image) }}" alt="Category Image">
                                </div>
                            </td>
                            <td>{{ $category->name }}</td>
                            <td class="action-cell">
                                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-link p-0 me-5" title="Edit">
                                    <i class="fas fa-pen" style="color: black;"></i>
                                </a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link p-0" style="color:black; background:none; border:none; cursor:pointer;" title="Delete">
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

<link rel="stylesheet" href="{{ asset('css/category_style.css') }}">
@endsection
