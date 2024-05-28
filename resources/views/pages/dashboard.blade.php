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
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h2 class="card-title text-center">Total Quatation</h2>
                        <p class="card-text text-center">Total Quatation: <span class="font-weight-bold">{{ $totalQuotations }}</span></p>
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

       <!-- New Section -->
       <div class="row justify-content-around">
           <div class="col-md-12">
               <div class="card bg-danger text-white">
                   <div class="card-body">
                       <h2 class="card-title">Penjualan Terlaris Bulan Ini</h2>
                       <p class="card-text">Detail penjualan terlaris bulan ini.</p>
                   </div>
               </div>
           </div>
       </div>

        <!-- Horizontal Divider -->
        <hr class="my-4">

        <!-- New Section -->
        <div class="row justify-content-around">
            <div class="col-md-12">
                <div class="card bg-warning text-dark">
                    <div class="card-body">
                        <h2 class="card-title text-center">Stock Produk</h2>
                        <canvas id="myChart" style="height: 150px";></canvas>

                    </div>
                </div>
            </div>
        </div>

    <!-- Horizontal Divider -->
        <hr class="my-4">

        <!-- New Section -->
        <div class="row justify-content-around">
            <div class="col-md-12">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h2 class="card-title">Pembelian Terbanyak Bulan Ini</h2>
                        <p class="card-text">Detail Pembelian Terbanyak bulan ini.</p>
                    </div>
                </div>
            </div>
        </div>

    </section>

</div>
@endsection




@push('scripts')
    <!-- JS Libraies -->
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
                        backgroundColor: 'rgba(255, 0, 0, 0.2)', // Merah dengan opacity 20%
                        borderColor: 'rgba(0, 0, 0, 1)', // Hitam
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
                    }
                }
            });
        });
    </script>
@endpush
