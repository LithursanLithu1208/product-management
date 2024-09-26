@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5" style="overflow-x: hidden;">
    <!-- Display success message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('delete_confirmation'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('delete_confirmation') }}
        </div>
    @endif

    <div class="container mt-3">
        {{-- 1st text --}}
        <h6 class="m-4" style="font-size: 16px">Product Management</h6>
        {{-- button option --}}
        <div class="d-flex justify-content-end mb-5">
            <div class="d-flex flex-column align-items-end">
                <a href="{{ route('products.create') }}" class="btn btn-dark mb-2" style="width: 234px; height: 40px; background-color: #2C1708;" >
                    <i class="fas bi-plus-circle mx-2"></i> Add New Product
                </a>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-dark btn-custom-primary" style="width: 234px; height: 40px;">
                    Category Management
                </a>
            </div>
        </div>

        {{-- for card --}}

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-5">
            @foreach($products as $product)
                <div class="col">
                    <div class="card card-3d-effect d-flex flex-row position-relative h-100">
                        <div class="col-4 d-flex align-items-center justify-content-center">
                            <div class="image-box">
                                {{-- to show image --}}
                                @if($product->main_image)
                                    <img src="{{ asset('storage/' . $product->main_image) }}" class="img-fluid rounded-start" alt="{{ $product->name }}" style="width: 100%; max-width: 100%;">
                                @else
                                    <img src="https://via.placeholder.com/150" class="img-fluid rounded-start" alt="No Image Available" style="width: 100%; max-width: 100%;">
                                @endif
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="card-body">
                                <p class="card-text"><strong>{{ $product->name }}</strong></p>
                                <p class="card-text">Category: {{ $product->category }}</p>
                                
                                
                                @php
                                    $prices = json_decode($product->prices, true);
                                @endphp
                                @if(is_array($prices) && count($prices) > 0)
                                    @php
                                        $firstPrice = $prices[0];
                                    @endphp
                                    <p class="card-text">Price: RS. {{ number_format($firstPrice['price'], 2) }}</p>
                                @else
                                    <p class="card-text">Price: Not Available</p>
                                @endif
                            </div>
                        </div>
                        <div class="position-absolute top-0 end-0 p-2">
                            {{-- for edit --}}
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-link p-0 me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                <i style="color:black;" class="fas fa-pencil-alt"></i>
                            </a>
                            
                            {{-- for delet --}}
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteConfirmModalLabel">Alert</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <p class="mb-0">Do you want to Delete?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-dark" id="confirmDelete">Confirm</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-link p-0 me-3" onclick="return confirm('Are you sure you want to delete this product?');" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                    <i class="fas fa-trash" style="color:black;"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- <div class="d-flex justify-content-center mt-4 custom-pagination">
            {{ $products->links('vendor.pagination.custom-bootstrap') }}
        </div> --}}
    </div>
</div>
@endsection
