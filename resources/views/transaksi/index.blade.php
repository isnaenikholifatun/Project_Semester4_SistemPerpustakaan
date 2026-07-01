<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Header Halaman dengan Tombol Tambahan Ke Laporan --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="fs-3 fw-bold text-gray-800 m-0">
                        <i class="bi bi-arrow-left-right"></i>
                        Daftar Transaksi Peminjaman
                    </h1>
                    <div class="d-flex gap-2">
                        {{-- TOMBOL KE HALAMAN LAPORAN --}}
                        <a href="{{ route('transaksi.laporan') }}" class="btn btn-success text-white">
                            <i class="bi bi-file-earmark-bar-graph-fill"></i> Lihat Laporan
                        </a>
                        <a href="{{ route('transaksi.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Pinjam Buku
                        </a>
                    </div>
                </div>

                {{-- Flash Message (Pesan Sukses / Gagal) --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                 
                {{-- Statistik Card dengan Logo/Ikon Terbuka di Sisi Kanan --}}
                <div class="row mb-4">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="card border-primary h-100" style="border-radius: 6px;">
                            <div class="card-body d-flex justify-content-between align-items-center p-3">
                                <div>
                                    <h6 class="text-muted mb-1 fw-medium">Total Transaksi</h6>
                                    <h2 class="fw-bold m-0" style="font-size: 2rem;">{{ $transaksis->count() }}</h2>
                                </div>
                                <div>
                                    <i class="bi bi-arrow-left-right text-primary" style="font-size: 2.5rem; opacity: 0.8;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="card border-warning h-100" style="border-radius: 6px;">
                            <div class="card-body d-flex justify-content-between align-items-center p-3">
                                <div>
                                    <h6 class="text-muted mb-1 fw-medium">Sedang Dipinjam</h6>
                                    <h2 class="fw-bold m-0" style="font-size: 2rem;">{{ $transaksis->where('status', 'Dipinjam')->count() }}</h2>
                                </div>
                                <div>
                                    <i class="bi bi-clock-history text-warning" style="font-size: 2.5rem; opacity: 0.8;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-success h-100" style="border-radius: 6px;">
                            <div class="card-body d-flex justify-content-between align-items-center p-3">
                                <div>
                                    <h6 class="text-muted mb-1 fw-medium">Sudah Dikembalikan</h6>
                                    <h2 class="fw-bold m-0" style="font-size: 2rem;">{{ $transaksis->where('status', 'Dikembalikan')->count() }}</h2>
                                </div>
                                <div>
                                    <i class="bi bi-check-circle text-success" style="font-size: 2.5rem; opacity: 0.8;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 
                {{-- Tabel Transaksi --}}
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="px-3" width="60">No</th>
                                        <th>Kode Transaksi</th>
                                        <th>Anggota</th>
                                        <th>Buku</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Status</th>
                                        <th width="100">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transaksis as $transaksi)
                                    <tr>
                                        <td class="px-3">{{ $loop->iteration }}</td>
                                        <td><span class="text-danger fw-semibold">{{ $transaksi->kode_transaksi }}</span></td>
                                        <td>{{ $transaksi->anggota->nama }}</td>
                                        <td>{{ $transaksi->buku->judul }}</td>
                                        <td>{{ $transaksi->tanggal_pinjam->format('d M Y') }}</td>
                                        <td>{{ $transaksi->tanggal_kembali->format('d M Y') }}</td>
                                        
                                        {{-- KOLOM STATUS --}}
                                        <td>
                                            @if($transaksi->status == 'Dipinjam')
                                                <span class="badge bg-warning text-dark px-2.5 py-1.5 rounded" style="font-size: 0.8rem;">Dipinjam</span>
                                                
                                                {{-- Cek Keterlambatan Hari ini vs Tanggal Kembali --}}
                                                @if(\Carbon\Carbon::now()->startOfDay()->gt(\Carbon\Carbon::parse($transaksi->tanggal_kembali)->startOfDay()))
                                                    <span class="badge bg-danger d-block mt-1 py-1" style="font-size: 0.75rem;">
                                                        Terlambat {{ \Carbon\Carbon::parse($transaksi->tanggal_kembali)->startOfDay()->diffInDays(\Carbon\Carbon::now()->startOfDay()) }} Hari
                                                    </span>
                                                @endif
                                            @else
                                                <span class="badge bg-success px-2.5 py-1.5 rounded" style="font-size: 0.8rem;">Dikembalikan</span>
                                            @endif
                                        </td>
                                        
                                        <td>
                                            <a href="{{ route('transaksi.show', $transaksi->id) }}" 
                                               class="btn btn-sm btn-info text-white d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            <i class="bi bi-info-circle d-block fs-3 mb-2"></i> Belum ada transaksi
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>