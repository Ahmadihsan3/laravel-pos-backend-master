@extends('layouts.app')

@section('title', 'General Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dashboard Inventory PT. Info Memory Lestari</h1>
        </div>

        <div class="section-body row justify-content-around mt-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h2 class="card-title text-center">Total Orders</h2>
                        <p class="card-text text-center">Total Orders: <span class="font-weight-bold">{{ $totalOrders }}</span></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h2 class="card-title text-center">Total Purchases</h2>
                        <p class="card-text text-center">Total Purchases: <span class="font-weight-bold">{{ $totalPurchases }}</span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Horizontal Divider -->
        <hr class="my-4">

        <!-- Pembelian Terlaris Section -->
        <div class="row justify-content-around">
            <div class="col-md-12">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h2 class="card-title text-center">Pembelian Terlaris</h2>
                        <div class="text-center mb-4">
                            <form action="{{ route('dashboard.index') }}" method="GET">
                                <div class="form-row align-items-center justify-content-center">
                                    <div class="col-auto">
                                        <label for="start_date" class="col-form-label">Start Date:</label>
                                        <input type="date" class="form-control mb-2" id="start_date" name="start_date" value="{{ $startDate }}">
                                    </div>
                                    <div class="col-auto">
                                        <label for="end_date" class="col-form-label">End Date:</label>
                                        <input type="date" class="form-control mb-2" id="end_date" name="end_date" value="{{ $endDate }}">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary mt-4">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if(count($purchases) > 0)
                            <canvas id="salesChart" style="height: 150px;"></canvas>
                        @else
                            <p class="card-text">No purchases in the selected date range.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Horizontal Divider -->
        <hr class="my-4">

        <!-- Stock Produk Section -->
        <div class="row justify-content-around">
            <div class="col-md-12">
                <div class="card bg-warning text-dark">
                    <div class="card-body">
                        <h2 class="card-title text-center">Stock Produk</h2>
                        <canvas id="myChart" style="height: 150px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Horizontal Divider -->
        <hr class="my-4">

        <!-- Penjualan Terlaris Section -->
        <div class="row justify-content-around">
            <div class="col-md-12">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h2 class="card-title text-center">Penjualan Terlaris</h2>
                        <div class="text-center mb-4">
                            <form action="{{ route('dashboard.index') }}" method="GET">
                                <div class="form-row align-items-center justify-content-center">
                                    <div class="col-auto">
                                        <label for="start_date" class="col-form-label">Start Date:</label>
                                        <input type="date" class="form-control mb-2" id="start_date" name="start_date" value="{{ $startDate }}">
                                    </div>
                                    <div class="col-auto">
                                        <label for="end_date" class="col-form-label">End Date:</label>
                                        <input type="date" class="form-control mb-2" id="end_date" name="end_date" value="{{ $endDate }}">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary mt-4">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if(count($orders) > 0)
                            <canvas id="orderChart" style="height: 150px;"></canvas>
                        @else
                            <p class="card-text">No orders in the selected date range.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Chart for Stock Produk
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [
                        @foreach ($products as $product)
                            "{{ $product->name }}",
                        @endforeach
                    ],
                    datasets: [{
                        label: 'Stock',
                        data: [
                            @foreach ($products as $product)
                                {{ $product->stock }},
                            @endforeach
                        ],
                        backgroundColor: 'rgba(255, 255, 255, 1)', // White
                        borderColor: 'rgba(0, 0, 0, 1)', // Black
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.yLabel + ' units';
                            }
                        }
                    }
                }
            });

            // Chart for Pembelian Terlaris
            var salesCtx = document.getElementById('salesChart').getContext('2d');
            var salesChart = new Chart(salesCtx, {
                type: 'bar',
                data: {
                    labels: [
                        @foreach ($purchases as $purchase)
                            "{{ $purchase->name }}",
                        @endforeach
                    ],
                    datasets: [{
                        label: 'Total Purchases',
                        data: [
                            @foreach ($purchases as $purchase)
                                {{ $purchase->total }},
                            @endforeach
                        ],
                        backgroundColor: 'rgba(255, 255, 255, 1)', // White
                        borderColor: 'rgba(54, 162, 235, 1)', // Blue
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.yLabel + ' purchases';
                            }
                        }
                    }
                }
            });

            // Chart for Penjualan Terlaris
            var orderCtx = document.getElementById('orderChart').getContext('2d');
            var orderChart = new Chart(orderCtx, {
                type: 'bar',
                data: {
                    labels: [
                        @foreach ($orders as $order)
                            "{{ $order->name }}",
                        @endforeach
                    ],
                    datasets: [{
                        label: 'Total Orders',
                        data: [
                            @foreach ($orders as $order)
                                {{ $order->total }},
                            @endforeach
                        ],
                        backgroundColor: 'rgba(255, 255, 255, 1)', // White
                        borderColor: 'rgba(255, 99, 132, 1)', // Pink
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.yLabel + ' orders';
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
