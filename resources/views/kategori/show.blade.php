@extends('layouts.app')

@section('title', 'Detail Kategori - ' . $kategori['nama'])

@section('content')
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('kategori.index') }}">Kategori</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $kategori['nama'] }}</li>
    </ol>
</nav>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-warning text-white">
        <h5 class="mb-0">Informasi Kategori</h5>
    </div>
    <div class="card-body">
        <h3>{{ $kategori['nama'] }}</h3>
        <p class="text-muted">{{ $kategori['deskripsi'] }}</p>
        <span class="badge bg-info text-dark">Total Koleksi: {{ $kategori['jumlah_buku'] }} Buku</span>
    </div>
</div>

<h4>Daftar Buku di Kategori Ini</h4>
<div class="table-responsive bg-white shadow-sm border rounded">
    <table class="table table-striped table-hover mb-0">
        <thead class="table-custom-header">
            <tr>
                <th width="5%">No</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Tahun Rilis</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($buku_list as $index => $buku)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $buku['judul'] }}</strong></td>
                    <td>{{ $buku['penulis'] }}</td>
                    <td>{{ $buku['tahun'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-3">Belum ada buku di kategori ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection