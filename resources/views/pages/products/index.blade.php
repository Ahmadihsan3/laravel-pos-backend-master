@extends('layouts.app')

@section('title', 'Products')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Products</h1>
                <div class="section-header-button">
                    <a href="{{ route('product.create') }}" class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Products</a></div>
                    <div class="breadcrumb-item">All Products</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <h2 class="section-title">Products</h2>
                <p class="section-lead">
                    You can manage all Products, such as editing, deleting and more.
                </p>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>All Products</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr style="text-align: center;">
                                            <th>Nomor</th>
                                            <th>Name</th>
                                            <th>Barcode</th>
                                            <th>Price Purchase</th>
                                            <th>Price Order</th>
                                            <th>Stock</th>
                                            <th>Category</th>
                                            <th>Unit</th>
                                            <th>Photo</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                        @php
                                            $startNumber = ($products->currentPage() - 1) * $products->perPage() + 1;
                                        @endphp
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{ $startNumber++ }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{!! DNS1D::getBarcodeHTML("$product->product_code", 'UPCA',2,50) !!}
                                                    <center>p - {{ $product->product_code }}</center>
                                                </td>
                                                <td>{{ $product->purchase->total ?? 'N/A' }}</td>
                                                <td>{{ $product->order->total_products ?? 'N/A' }}</td>
                                                <td>{{ $product->stock }}</td>
                                                <td>{{ $product->category->name }}</td>
                                                <td>{{ $product->unit->name}}</td>
                                                <td>
                                                    @if ($product->image)
                                                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
                                                    @else
                                                        <span class="badge badge-danger">No Image</span>
                                                    @endif
                                                </td>
                                                <td>{{ $product->created_at }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a href='{{ route('product.edit', $product->id) }}' class="btn btn-sm btn-info btn-icon">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <form action="{{ route('product.destroy', $product->id) }}" method="POST" class="ml-2">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                                <i class="fas fa-times"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $products->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
    <!-- JS Library for Barcode -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Inisialisasi barcode batang untuk setiap elemen dengan kelas 'barcode'
            JsBarcode(".barcode").init();
        });
    </script>
@endpush
