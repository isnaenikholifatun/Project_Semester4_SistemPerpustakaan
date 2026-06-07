@extends('layouts.app')
 
@section('title', 'Daftar Buku')
 
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>
        <i class="bi bi-book"></i>
        Daftar Buku
    </h1>

    <a href="{{ route('buku.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i>
        Tambah Buku
    </a>
</div>

{{-- Statistik Cards --}}
<div class="row mb-4">

    <div class="col-md-4">
        <div class="card border-primary">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <h6 class="text-muted mb-1">
                            Total Buku
                        </h6>

                        <h2 class="mb-0">
                            {{ $totalBuku }}
                        </h2>
                    </div>

                    <div class="text-primary">
                        <i class="bi bi-book-fill"
                           style="font-size: 3rem;"></i>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-success">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <h6 class="text-muted mb-1">
                            Buku Tersedia
                        </h6>

                        <h2 class="mb-0">
                            {{ $bukuTersedia }}
                        </h2>
                    </div>

                    <div class="text-success">
                        <i class="bi bi-check-circle-fill"
                           style="font-size: 3rem;"></i>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-danger">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <h6 class="text-muted mb-1">
                            Buku Habis
                        </h6>

                        <h2 class="mb-0">
                            {{ $bukuHabis }}
                        </h2>
                    </div>

                    <div class="text-danger">
                        <i class="bi bi-x-circle-fill"
                           style="font-size: 3rem;"></i>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>

{{-- Filter Kategori --}}
<div class="card mb-4">
    <div class="card-body">

        <h6 class="card-title">
            <i class="bi bi-funnel"></i>
            Filter Kategori:
        </h6>

        <div class="btn-group" role="group">

            <a href="{{ route('buku.index') }}"
               class="btn btn-sm {{ !isset($kategori) ? 'btn-primary' : 'btn-outline-primary' }}">
                Semua
            </a>

            <a href="{{ route('buku.kategori', 'Programming') }}"
               class="btn btn-sm {{ isset($kategori) && $kategori == 'Programming' ? 'btn-primary' : 'btn-outline-primary' }}">
                Programming
            </a>

            <a href="{{ route('buku.kategori', 'Database') }}"
               class="btn btn-sm {{ isset($kategori) && $kategori == 'Database' ? 'btn-primary' : 'btn-outline-primary' }}">
                Database
            </a>

            <a href="{{ route('buku.kategori', 'Web Design') }}"
               class="btn btn-sm {{ isset($kategori) && $kategori == 'Web Design' ? 'btn-primary' : 'btn-outline-primary' }}">
                Web Design
            </a>

            <a href="{{ route('buku.kategori', 'Networking') }}"
               class="btn btn-sm {{ isset($kategori) && $kategori == 'Networking' ? 'btn-primary' : 'btn-outline-primary' }}">
                Networking
            </a>

            <a href="{{ route('buku.kategori', 'Data Science') }}"
               class="btn btn-sm {{ isset($kategori) && $kategori == 'Data Science' ? 'btn-primary' : 'btn-outline-primary' }}">
                Data Science
            </a>

        </div>

    </div>
</div>

{{-- Form Search --}}
<div class="card mb-4">
    <div class="card-body">

        <form action="{{ route('buku.search') }}"
              method="GET">

            <div class="row">

                {{-- Keyword --}}
                <div class="col-md-3">
                    <input type="text"
                           name="keyword"
                           class="form-control"
                           placeholder="Cari judul, pengarang, penerbit">
                </div>

                {{-- Kategori --}}
                <div class="col-md-2">
                    <select name="kategori"
                            class="form-select">

                        <option value="">Semua Kategori</option>
                        <option value="Programming">Programming</option>
                        <option value="Database">Database</option>
                        <option value="Web Design">Web Design</option>
                        <option value="Networking">Networking</option>
                        <option value="Data Science">Data Science</option>

                    </select>
                </div>

                {{-- Tahun --}}
                <div class="col-md-2">
                    <input type="number"
                           name="tahun"
                           class="form-control"
                           placeholder="Tahun">
                </div>

                {{-- Ketersediaan --}}
                <div class="col-md-2">
                    <select name="ketersediaan"
                            class="form-select">

                        <option value="">Semua</option>
                        <option value="tersedia">Tersedia</option>
                        <option value="habis">Habis</option>

                    </select>
                </div>

                {{-- Button --}}
                <div class="col-md-3">
                    <button type="submit"
                            class="btn btn-primary w-100">

                        <i class="bi bi-search"></i>
                        Cari Buku

                    </button>
                </div>

            </div>

        </form>

    </div>
</div>
{{-- Daftar Buku --}}
@forelse ($bukus as $buku)

    <x-buku-card :buku="$buku" />

@empty

    <div class="alert alert-info">
        Tidak ada data buku
    </div>

@endforelse

@if ($bukus->count() > 0)

    <div class="text-center mt-4">

        <p class="text-muted">

            Menampilkan {{ $bukus->count() }} buku

            @isset($kategori)
                dari kategori <strong>{{ $kategori }}</strong>
            @endisset

        </p>

    </div>

@endif

    {{-- Delete Button dengan SweetAlert --}}
    <form action="{{ route('buku.destroy', $buku->id) }}" 
        method="POST" 
        class="d-inline delete-form">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-sm btn-danger w-100 btn-delete" 
                data-judul="{{ $buku->judul }}">
            <i class="bi bi-trash"></i> Hapus
        </button>
    </form>
    
    @push('scripts')
    <script>
        // SweetAlert confirmation untuk delete
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                const judul = this.getAttribute('data-judul');
                
                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: `Apakah Anda yakin ingin menghapus buku "${judul}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush

@push('scripts')
<script>
    // Loading state saat submit form
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn && !this.classList.contains('delete-form')) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
            }
        });
    });
</script>
@endpush

@endsection