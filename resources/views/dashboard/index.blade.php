@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<h1 class="mb-4">Dashboard Perpustakaan</h1>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-primary">
            <div class="card-body">
                <h5>Total Buku</h5>
                <h2>{{ $totalBuku }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-success">
            <div class="card-body">
                <h5>Buku Tersedia</h5>
                <h2>{{ $bukuTersedia }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-danger">
            <div class="card-body">
                <h5>Buku Habis</h5>
                <h2>{{ $bukuHabis }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-info">
            <div class="card-body">
                <h5>Total Anggota</h5>
                <h2>{{ $totalAnggota }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-success">
            <div class="card-body">
                <h5>Anggota Aktif</h5>
                <h2>{{ $anggotaAktif }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-secondary">
            <div class="card-body">
                <h5>Anggota Nonaktif</h5>
                <h2>{{ $anggotaNonaktif }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                5 Buku Terbaru
            </div>
            <div class="card-body">
                @forelse($bukuTerbaru as $buku)
                    <p>
                        <strong>{{ $buku->judul }}</strong><br>
                        {{ $buku->pengarang }}
                    </p>
                    <hr>
                @empty
                    <p>Tidak ada data buku</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                5 Anggota Terbaru
            </div>
            <div class="card-body">
                @forelse($anggotaTerbaru as $anggota)
                    <p>
                        <strong>{{ $anggota->nama }}</strong><br>
                        {{ $anggota->email }}
                    </p>
                    <hr>
                @empty
                    <p>Tidak ada data anggota</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('buku.index') }}" class="btn btn-primary">
        Kelola Buku
    </a>
    <a href="{{ route('anggota.index') }}" class="btn btn-success">
        Kelola Anggota
    </a>
</div>

@endsection