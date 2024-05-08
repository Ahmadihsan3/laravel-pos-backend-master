@extends('layouts.app')

@section('title', 'unit')

@push('style')
<!-- Perpustakaan CSS -->
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Units</h1>
            <div class="section-header-button">
                <a href="{{ route('unit.create') }}" class="btn btn-primary">Tambahkan Baru</a>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dasbor</a></div>
                <div class="breadcrumb-item"><a href="#">Units</a></div>
                <div class="breadcrumb-item">Semua Units</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <h2 class="section-title">Units</h2>
            <p class="section-lead">Anda dapat mengelola semua Units, seperti mengedit, menghapus, dan menambahkan.</p>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Semua Postingan</h4>
                        </div>
                        <div class="card-body">
                            <div class="float-right" style="margin-top: -2rem; margin-bottom: 1rem">
                                <form method="GET" action="{{ route('unit.index') }}">
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
                                        <th>Parent</th>
                                        <th>Quantity</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Aksi</th>
                                    </tr>
                                    @php
                                    $startNumber = ($units->currentPage() - 1) * $units->perPage() + 1;
                                    @endphp
                                    @foreach ($units as $unit)
                                    <tr>
                                        <td>{{ $startNumber++ }}</td>
                                        <td>{{ $unit->name }}</td>
                                        <td>{{ $unit->parent ? $unit->parent->name : '-' }}</td>
                                        <td>{{ $unit->quantity }}</td>
                                        <td>{{ $unit->created_at }}</td>
                                        <td>{{ $unit->updated_at }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href='{{ route('unit.edit', $unit->id) }}' class="btn btn-sm btn-info btn-icon">
                                                    <i class="fas fa-edit"></i> Sunting
                                                </a>
                                                <form action="{{ route('unit.destroy', $unit->id) }}" method="POST" class="ml-2">
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
                            {{ $units->links() }}

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
