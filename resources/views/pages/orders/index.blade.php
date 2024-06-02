@extends('layouts.app')

@section('title', 'Orders')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Orders</h1>
                <div class="section-header-button">
                    <a href="{{ route('order.create') }}" class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Orders</a></div>
                    <div class="breadcrumb-item">All Orders</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <h2 class="section-title">Orders</h2>
                <p class="section-lead">
                    You can manage all Orders, such as editing, deleting and more.
                </p>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>All Orders</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nomor</th>
                                                <th>order No</th>
                                                <th>order Date</th>
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
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td>{{ $startNumber++ }}</td>
                                                    <td> <a href="{{ route('order.show', $order->id) }}">
                                                        {{ $order->no_order }}
                                                    </a>
                                                    </td>
                                                    <td>{{ $order->date_order }}</td>
                                                    <td>{{ $order->total_price }}</td>
                                                    <td>{{ $order->customer->name }}</td>
                                                    <td>{{ $order->payment }}</td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            @if (!$order->selected)
                                                                <!-- Tampilkan tombol hanya jika pembelian belum dipilih -->
                                                                <a href='/order/action/accept/{{ $order->id }}'
                                                                    class="btn btn-success">
                                                                    <i class="fas fa-check"></i> Accept
                                                                </a>
                                                                <a href='/order/action/cancel/{{ $order->id }}'
                                                                    class="btn btn-warning">
                                                                    <i class="fas fa-times"></i> Cancel
                                                                </a>
                                                            @endif
                                                            @if (request("selected") !=null && $order->selected == 1)
                                                                <a href='/order/action/edit/{{ $order->id }}'
                                                                    class="btn btn-warning">
                                                                    <i class="fas fa-file-excel"></i> Edit
                                                                </a>
                                                                <a href='/order/action/delivery/{{ $order->id }}'
                                                                    class="btn btn-success">
                                                                    <i class="fas fa-file-excel"></i> Delivery
                                                                </a>
                                                            @endif
                                                            <a href="{{ route('order.export.excel', $order->id) }}" class="btn btn-info">
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
                                    {{ $orders->links() }}
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
