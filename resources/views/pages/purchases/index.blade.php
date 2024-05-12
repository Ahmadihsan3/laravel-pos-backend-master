@extends('layouts.app')

@section('title', 'Purchases')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Purchases</h1>
                <div class="section-header-button">
                    <a href="{{ route('purchase.create') }}" class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Purchases</a></div>
                    <div class="breadcrumb-item">All Purchases</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <h2 class="section-title">Purchases</h2>
                <p class="section-lead">
                    You can manage all Purchases, such as editing, deleting and more.
                </p>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>All Purchases</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nomor</th>
                                                <th>Purchase No</th>
                                                <th>Purchase Date</th>
                                                <th>Nama Product</th>
                                                <th>Price</th>
                                                <th>Unit</th>
                                                <th>Quantity</th>
                                                <th>Total Quantity</th>
                                                <th>Total Price</th>
                                                <th>Nama Supplier</th>
                                                <th>Payment</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $startNumber = 1; // Define start number here
                                            @endphp
                                            @foreach ($purchases as $purchase)
                                                <tr>
                                                    <td>{{ $startNumber++ }}</td>
                                                    <td>{{ $purchase->no_purchase }}</td>
                                                    <td>{{ $purchase->date_purchase }}</td>
                                                    <td>{{ $purchase->product->name }}</td>
                                                    <td>{{ $purchase->price }}</td>
                                                    <td>{{ $purchase->unit->name }}</td>
                                                    <td>{{ $purchase->quantity }}</td>
                                                    <td>{{ $purchase->total_quantity }}</td>
                                                    <td>{{ $purchase->total_price }}</td>
                                                    <td>{{ $purchase->supplier->name }}</td>
                                                    <td>{{ $purchase->payment }}</td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            @if (!$purchase->selected)
                                                                <!-- Tampilkan tombol hanya jika pembelian belum dipilih -->
                                                                <a href='/purchase/action/accept/{{ $purchase->id }}'
                                                                    class="btn btn-success">
                                                                    <i class="fas fa-check"></i> Accept
                                                                </a>
                                                                <a href='/purchase/action/cancel/{{ $purchase->id }}'
                                                                    class="btn btn-warning">
                                                                    <i class="fas fa-times"></i> Cancel
                                                                </a>
                                                            @endif
                                                            <a href='{{ route('purchase.export.excel', $purchase->id) }}'
                                                                class="btn btn-info">
                                                                <i class="fas fa-file-excel"></i> Export Excel
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $purchases->links() }}
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
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
