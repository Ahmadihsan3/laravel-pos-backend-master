@extends('layouts.app')

@section('title', 'General Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

<?php
?>
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
                            <p class="card-text text-center">Total Orders: <span
                                    class="font-weight-bold">{{ $totalOrders }}</span></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h2 class="card-title text-center">Total Purchases</h2>
                            <p class="card-text text-center">Total Purchases: <span
                                    class="font-weight-bold">{{ $totalPurchases }}</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Horizontal Divider -->
            <hr class="my-4">

            <!-- Pembelian Terlaris Section -->
            <div class="row justify-content-around">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title text-center">Pembelian Terlaris</h2>
                            <div class="text-center mb-4">
                                <form action="{{ route('dashboard.index') }}" method="GET">
                                    <div class="form-row align-items-center justify-content-center">
                                        <div class="col-auto">
                                            <label for="start_date" class="col-form-label">Start Date:</label>
                                            <input type="date" class="form-control mb-2" id="start_date"
                                                name="start_date" value="{{ $startDate }}">
                                        </div>
                                        <div class="col-auto">
                                            <label for="end_date" class="col-form-label">End Date:</label>
                                            <input type="date" class="form-control mb-2" id="end_date" name="end_date"
                                                value="{{ $endDate }}">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary mt-4">Filter</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <canvas id="purchaseChart" style="height: 150px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Horizontal Divider -->
            <hr class="my-4">

            <!-- Stock Produk Section -->
            <div class="row justify-content-around">
                <div class="col-md-12">
                    <div class="card text-dark">
                        <div class="card-body">
                            <h2 class="card-title text-center">Stock Produk</h2>
                            <canvas id="stockChart" style="height: 150px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Horizontal Divider -->
            <hr class="my-4">

            <!-- Penjualan Terlaris Section -->
            <div class="row justify-content-around">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title text-center">Penjualan Terlaris</h2>
                            <div class="text-center mb-4">
                                <form action="{{ route('dashboard.index') }}" method="GET">
                                    <div class="form-row align-items-center justify-content-center">
                                        <div class="col-auto">
                                            <label for="start_date" class="col-form-label">Start Date:</label>
                                            <input type="date" class="form-control mb-2" id="start_date"
                                                name="start_date" value="{{ $startDate }}">
                                        </div>
                                        <div class="col-auto">
                                            <label for="end_date" class="col-form-label">End Date:</label>
                                            <input type="date" class="form-control mb-2" id="end_date" name="end_date"
                                                value="{{ $endDate }}">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary mt-4">Filter</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <canvas id="orderChart" style="height: 150px;"></canvas>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function generateChartsByValue(chartId, values) {
            const ctx = document.getElementById(chartId).getContext('2d');
            var data = JSON.parse(values);
            var labels = [];
            var values = [];

            for (var d in data) {
                labels.push(data[d][0]);
                values.push(data[d][1]);
            }

            const stockChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '# of Votes',
                        data: values,
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        generateChartsByValue('stockChart', `<?php echo json_encode($stockChart); ?>`);
        generateChartsByValue('purchaseChart', `<?php echo json_encode($purchaseChart); ?>`);
        generateChartsByValue('orderChart', `<?php echo json_encode($orderChart); ?>`);
    </script>
@endpush
