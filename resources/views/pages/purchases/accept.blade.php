@extends('layouts.app')

@section('title', 'Accept Purchase')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Accept Purchase</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Accept Purchases</a></div>
                    <div class="breadcrumb-item">Accept Purchase</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Accept Purchases</h4>
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
                                            @foreach ($purchases as $purchase)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
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
                                                        <a href='{{ route('purchase.export.excel', $purchase->id) }}' class="btn btn-info">
                                                            <i class="fas fa-file-excel"></i> Export Excel
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
