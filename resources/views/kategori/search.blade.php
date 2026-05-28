@extends('layouts.app')

@section('title', 'Hasil Pencarian Kategori')

@section('content')
<div class="mb-4">
    <h2 class="mb-4">Hasil Pencarian: "<span class="bg-warning-subtle px-2">{{ $keyword }}</span>"</h2>
</div>

<div class="row">
    @forelse ($kategori_list as $kategori)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100 border-0">
                
                <div class="card-header bg-warning py-3">
                    <h5 class="card-title text-white fw-bold mb-0 fs-5">
                        {{ $kategori['nama'] }}
                    </h5>
                </div>
                
                <div class="card-body">
                    <p class="card-text text-muted">{{ $kategori['deskripsi'] }}</p>
                    <p class="card-text">
                        <span class="fw-bold">Jumlah Buku:</span> {{ $kategori['jumlah_buku'] }}
                    </p>
                </div>

                <div class="card-footer bg-white py-3">
                    <a href="{{ route('kategori.show', $kategori['id']) }}" class="btn btn-primary fw-bold px-3">
                        Detail
                    </a>
                </div>

            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">
                Kategori dengan kata kunci "<strong>{{ $keyword }}</strong>" tidak ditemukan.
            </div>
        </div>
    @endforelse
</div>

<div class="mt-3">
    <a href="{{ route('kategori.index') }}" class="btn btn-secondary shadow-sm">
        <i class="bi bi-arrow-left"></i> ← Kembali
    </a>
</div>
@endsection