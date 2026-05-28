@extends('layouts.app')

@section('title', 'Daftar Kategori - Perpustakaan')

@section('content')
<div class="mb-4">
    <h2 class="mb-3">Daftar Kategori Buku</h2>
    <hr>
</div>

<div class="row">
    @foreach ($kategori_list as $kategori)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100 border-0">
                
                <div class="card-header bg-success py-3">
                    <h5 class="card-title text-white fw-bold mb-0 fs-4">
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
                    <a href="{{ route('kategori.show', $kategori['id']) }}" class="btn btn-primary fw-bold px-4">
                        Detail
                    </a>
                </div>

            </div>
        </div>
    @endforeach
</div>
@endsection