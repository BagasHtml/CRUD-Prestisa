@extends('layouts.app')

@section('title', 'Inventori Bunga - Prestisa')

@section('content')
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stat-card text-center">
            <i class="bi bi-flower2 stat-icon"></i>
            <h3 class="mt-2">{{ $flowers->total() }}</h3>
            <p class="text-muted mb-0">Total Jenis Bunga</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card text-center">
            <i class="bi bi-basket stat-icon"></i>
            <h3 class="mt-2">{{ $totalStock }}</h3>
            <p class="text-muted mb-0">Total Stok</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card text-center">
            <i class="bi bi-exclamation-triangle stat-icon text-warning"></i>
            <h3 class="mt-2">{{ $lowStockCount }}</h3>
            <p class="text-muted mb-0">Stok Menipis</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card text-center">
            <i class="bi bi-tag stat-icon text-success"></i>
            <h3 class="mt-2">{{ $categories->count() }}</h3>
            <p class="text-muted mb-0">Kategori</p>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white py-3">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="mb-0"><i class="bi bi-flower1"></i> Daftar Inventori Bunga</h4>
            </div>
            <div class="col-auto">
                <a href="{{ route('flowers.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Tambah Bunga Baru
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            @forelse ($flowers as $flower)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        @if($flower->image)
                            <img src="{{ asset('storage/'.$flower->image) }}" class="card-img-top" style="height: 180px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $flower->name }}</h5>
                            <p class="card-text text-muted mb-1">Stok: {{ $flower->stock }}</p>
                            <p class="card-text text-muted mb-1">Kategori: {{ $flower->category ?? '-' }}</p>
                            <p class="card-text fw-bold text-primary">Rp {{ number_format($flower->price, 0, ',', '.') }}</p>
                        </div>
                        <div class="card-footer text-end bg-white border-top-0">
                            <a href="{{ route('flowers.edit', $flower->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('flowers.destroy', $flower->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted py-4">
                    <p>Tidak ada data bunga yang tersedia.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-3">
            {{ $flowers->links() }}
        </div>
    </div>
</div>
@endsection
