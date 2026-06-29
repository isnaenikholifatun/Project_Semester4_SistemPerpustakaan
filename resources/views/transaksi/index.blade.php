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
                 
                {{-- Statistik --}}
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card border-primary">
                            <div class="card-body">
                                <h6 class="text-muted">Total Transaksi</h6>
                                <h2>{{ $transaksis->count() }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-warning">
                            <div class="card-body">
                                <h6 class="text-muted">Sedang Dipinjam</h6>
                                <h2>{{ $transaksis->where('status', 'Dipinjam')->count() }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-success">
                            <div class="card-body">
                                <h6 class="text-muted">Sudah Dikembalikan</h6>
                                <h2>{{ $transaksis->where('status', 'Dikembalikan')->count() }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                 
                {{-- Tabel Transaksi --}}
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Transaksi</th>
                                        <th>Anggota</th>
                                        <th>Buku</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transaksis as $transaksi)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><code>{{ $transaksi->kode_transaksi }}</code></td>
                                        <td>{{ $transaksi->anggota->nama }}</td>
                                        <td>{{ $transaksi->buku->judul }}</td>
                                        <td>{{ $transaksi->tanggal_pinjam->format('d M Y') }}</td>
                                        <td>{{ $transaksi->tanggal_kembali->format('d M Y') }}</td>
                                        
                                        {{-- KOLOM STATUS (FIXED) --}}
                                        <td>
                                            @if($transaksi->status == 'Dipinjam')
                                                <span class="badge bg-warning text-dark px-2.5 py-1.5 rounded">Dipinjam</span>
                                                
                                                {{-- Cek Keterlambatan Hari ini vs Tanggal Kembali --}}
                                                @if(\Carbon\Carbon::now()->startOfDay()->gt(\Carbon\Carbon::parse($transaksi->tanggal_kembali)->startOfDay()))
                                                    <span class="badge bg-danger d-block mt-1">
                                                        Terlambat {{ \Carbon\Carbon::parse($transaksi->tanggal_kembali)->startOfDay()->diffInDays(\Carbon\Carbon::now()->startOfDay()) }} Hari
                                                    </span>
                                                @endif
                                            @else
                                                <span class="badge bg-success px-2.5 py-1.5 rounded">Dikembalikan</span>
                                            @endif
                                        </td>
                                        
                                        <td>
                                            <a href="{{ route('transaksi.show', $transaksi->id) }}" 
                                               class="btn btn-sm btn-info text-white">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">
                                            Belum ada transaksi
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