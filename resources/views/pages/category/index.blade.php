@extends('layouts.app')

@section('title', 'Category')

@push('style')
<!-- Perpustakaan CSS -->
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Kategori</h1>
            <div class="section-header-button">
                <a href="{{ route('category.create') }}" class="btn btn-primary">Tambahkan Baru</a>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dasbor</a></div>
                <div class="breadcrumb-item"><a href="#">Kategori</a></div>
                <div class="breadcrumb-item">Semua Kategori</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <h2 class="section-title">Kategori</h2>
            <p class="section-lead">Anda dapat mengelola semua Kategori, seperti mengedit, menghapus, dan menambahkan.</p>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Semua Postingan</h4>
                        </div>
                        <div class="card-body">
                            <div class="float-right" style="margin-top: -2rem; margin-bottom: 1rem">
                                <form method="GET" action="{{ route('category.index') }}">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search" name="name">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                    <div class="table-responsive">
                        <table class="table-striped table">
                            <tr>
                                <th>Nomor</th>
                                <th>Nama</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                            </tr>
                            @php
                                $startNumber = 1; // Define start number here
                            @endphp
                            @foreach ($categories as $category)
                            <tr>
                                <td>{{ $startNumber++ }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->created_at }}</td>
                                <td>{{ $category->updated_at }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href='{{ route('category.edit', $category->id) }}' class="btn btn-sm btn-info btn-icon">
                                            <i class="fas fa-edit"></i> Sunting
                                        </a>
                                        <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="ml-2">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-sm btn-danger btn-icon konfirmasi-hapus">
                                                <i class="fas fa-times"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>

                    <!-- Navigasi halaman untuk paginasi -->
                    <!-- Navigasi halaman untuk paginasi -->
                    {{ $categories->links() }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- Perpustakaan JS -->
<script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
<!-- File JS Khusus Laman -->
<script>
    function resetNumberOrder() {
        var numberCells = document.querySelectorAll('.number-cell');
        numberCells.forEach((cell, index) => {
            cell.textContent = index + 1;
        });
    }
</script>
@endpush
