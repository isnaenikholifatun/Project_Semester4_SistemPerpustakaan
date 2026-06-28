<x-app-layout>
    <x-slot name="header">
        {{-- Memberikan padding horizontal agar teks header sejajar dengan konten bawah --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="h4 mb-0 text-gray-800">
                {{ $buku->judul }}
            </h2>
        </div>
    </x-slot>

    {{-- PEMBUNGKUS UTAMA: Menggunakan kontainer agar layout tidak mepet ke pinggir layar --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        
        {{-- Breadcrumb --}}
        <div class="row">
            <div class="col-12 mb-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('buku.index') }}">Buku</a></li>
                        <li class="breadcrumb-item active">{{ $buku->judul }}</li>
                    </ol>
                </nav>
            </div>
        </div>
     
        <div class="row">
            {{-- Kolom Kiri: Info Buku --}}
            <div class="col-md-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0 fs-5 py-1">
                            <i class="bi bi-book text-white"></i> Detail Buku
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        {{-- Judul --}}
                        <h2 class="mb-3 h3 fw-bold text-gray-800">{{ $buku->judul }}</h2>
                        
                        {{-- Badge Kategori --}}
                        <div class="mb-4">
                            <span class="badge bg-{{ $buku->kategori == 'Programming' ? 'primary' : ($buku->kategori == 'Database' ? 'success' : ($buku->kategori == 'Web Design' ? 'info' : ($buku->kategori == 'Networking' ? 'warning' : 'danger'))) }} fs-6 px-3 py-2">
                                <i class="bi bi-tag"></i> {{ $buku->kategori }}
                            </span>
                        </div>
                        
                        {{-- Informasi Detail --}}
                        <table class="table table-borderless align-middle">
                            <tr>
                                <td width="200" class="fw-bold text-muted">
                                    <i class="bi bi-upc text-primary"></i> Kode Buku
                                </td>
                                <td>: {{ $buku->kode_buku }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">
                                    <i class="bi bi-person text-primary"></i> Pengarang
                                </td>
                                <td>: {{ $buku->pengarang }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">
                                    <i class="bi bi-building text-primary"></i> Penerbit
                                </td>
                                <td>: {{ $buku->penerbit }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">
                                    <i class="bi bi-calendar text-primary"></i> Tahun Terbit
                                </td>
                                <td>: {{ $buku->tahun_terbit }}</td>
                            </tr>
                            @if ($buku->isbn)
                                <tr>
                                    <td class="fw-bold text-muted">
                                        <i class="bi bi-hash text-primary"></i> ISBN
                                    </td>
                                    <td>: {{ $buku->isbn }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="fw-bold text-muted">
                                    <i class="bi bi-translate text-primary"></i> Bahasa
                                </td>
                                <td>: {{ $buku->bahasa }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">
                                    <i class="bi bi-cash text-primary"></i> Harga
                                </td>
                                <td>: <span class="text-success fs-5 fw-bold">{{ $buku->harga_format }}</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">
                                    <i class="bi bi-boxes text-primary"></i> Stok
                                </td>
                                <td>
                                    : <span class="fw-bold">{{ $buku->stok }}</span> buku
                                    @if ($buku->stok > 0)
                                        <span class="badge bg-success ms-2 px-2 py-1">
                                            <i class="bi bi-check-circle"></i> Tersedia
                                        </span>
                                    @else
                                        <span class="badge bg-danger ms-2 px-2 py-1">
                                            <i class="bi bi-x-circle"></i> Habis
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                        
                        {{-- Deskripsi --}}
                        @if ($buku->deskripsi)
                            <hr class="my-4">
                            <h5 class="fw-bold text-gray-700 mb-2"><i class="bi bi-file-text text-primary"></i> Deskripsi</h5>
                            <p class="text-justify text-secondary leading-relaxed">{{ $buku->deskripsi }}</p>
                        @else
                            <hr class="my-4">
                            <p class="text-muted fst-italic mb-0">
                                <i class="bi bi-info-circle"></i> Tidak ada deskripsi untuk buku ini
                            </p>
                        @endif

                        {{-- Timestamps --}}
                        <hr class="my-4">
                        <div class="row text-muted small">
                            <div class="col-md-6 mb-2 mb-md-0">
                                <i class="bi bi-clock"></i> 
                                Ditambahkan: 
                                {{ $buku->created_at ? $buku->created_at->format('d M Y H:i') : '-' }}
                            </div>

                            <div class="col-md-6 text-md-end">
                                <i class="bi bi-clock-history"></i> 
                                Terakhir Update: 
                                {{ $buku->updated_at ? $buku->updated_at->format('d M Y H:i') : '-' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                        
            {{-- Kolom Kanan: Actions & Info Tambahan --}}
            <div class="col-md-4">
                {{-- Card Actions --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0 py-1 fw-bold">
                            <i class="bi bi-gear text-white"></i> Aksi
                        </h6>
                    </div>
                    <div class="card-body d-grid gap-2 p-3">
                        <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning py-2 text-dark fw-medium">
                            <i class="bi bi-pencil"></i> Edit Buku
                        </a>
                        
                        @if ($buku->stok > 0)
                            <button class="btn btn-success py-2 fw-medium">
                                <i class="bi bi-cart-plus"></i> Pinjam Buku
                            </button>
                        @else
                            <button class="btn btn-secondary py-2" disabled>
                                <i class="bi bi-x-circle"></i> Stok Habis
                            </button>
                        @endif
                        
                        <a href="{{ route('buku.index') }}" class="btn btn-outline-primary py-2 fw-medium">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>

                        {{-- Delete Button dengan SweetAlert --}}
                        <form action="{{ route('buku.destroy', $buku->id) }}" 
                            method="POST" 
                            class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger w-100 py-2 fw-medium btn-delete" 
                                    data-judul="{{ $buku->judul }}">
                                <i class="bi bi-trash"></i> Hapus Buku
                            </button>
                        </form>
                        
                        @push('scripts')
                        <script>
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
                    </div>
                </div>
                
                {{-- Card Status Stok --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0 py-1 fw-bold">
                            <i class="bi bi-info-circle text-white"></i> Status Stok
                        </h6>
                    </div>
                    <div class="card-body p-3">
                        @if ($buku->stok == 0)
                            <div class="alert alert-danger mb-0 border-0 shadow-sm">
                                <i class="bi bi-exclamation-triangle"></i>
                                <strong>Stok Habis!</strong><br />
                                Buku ini sedang tidak tersedia.
                            </div>
                        @elseif ($buku->stok <= 5)
                            <div class="alert alert-warning mb-0 border-0 shadow-sm">
                                <i class="bi bi-exclamation-circle"></i>
                                <strong>Stok Menipis!</strong><br />
                                Tersisa {{ $buku->stok }} buku.
                            </div>
                        @else
                            <div class="alert alert-success mb-0 border-0 shadow-sm">
                                <i class="bi bi-check-circle"></i>
                                <strong>Stok Aman!</strong><br />
                                Tersedia {{ $buku->stok }} buku.
                            </div>
                        @endif
                    </div>
                </div>
                
                {{-- Card Buku Serupa --}}
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h6 class="mb-0 py-1 fw-bold">
                            <i class="bi bi-collection text-white"></i> Buku Serupa
                        </h6>
                    </div>
                    <div class="card-body p-3">
                        @php
                            $bukuSerupa = App\Models\Buku::where('kategori', $buku->kategori)
                                                          ->where('id', '!=', $buku->id)
                                                          ->take(3)
                                                          ->get();
                        @endphp
                        
                        @forelse ($bukuSerupa as $item)
                            <div class="mb-2 p-2 rounded hover:bg-light transition-all">
                                <a href="{{ route('buku.show', $item->id) }}" class="text-decoration-none">
                                    <h6 class="mb-1 text-primary fw-medium small">{{ Str::limit($item->judul, 40) }}</h6>
                                </a>
                                <small class="text-muted d-block"><i class="bi bi-person"></i> {{ $item->pengarang }}</small>
                            </div>
                            @if (!$loop->last)
                                <hr class="my-2 opacity-50">
                            @endif
                        @empty
                            <p class="text-muted small mb-0 py-2 text-center">
                                <i class="bi bi-info-circle"></i> Tidak ada buku serupa
                            </p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>