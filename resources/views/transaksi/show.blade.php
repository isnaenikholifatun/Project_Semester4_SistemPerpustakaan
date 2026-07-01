<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        
        {{-- Breadcrumb --}}
        <div class="mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background: none; padding: 0;">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}" class="text-decoration-none text-primary">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('transaksi.index') }}" class="text-decoration-none text-primary">Transaksi</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: #6c757d;">{{ $transaksi->kode_transaksi }}</li>
                </ol>
            </nav>
        </div>
     
        <div class="row">
            {{-- Kolom Kiri: Card Utama Detail Transaksi --}}
            <div class="col-md-8 mb-4">
                <div class="card shadow-sm border-0" style="border-radius: 8px;">
                    {{-- Header Kustom: Meniru gaya 'Detail Anggota' dengan background hijau/biru kustom --}}
                    <div class="card-header text-white px-4 py-3 d-flex align-items-center" style="background-color: #198754; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                        <h4 class="mb-0 fs-5 fw-medium d-flex align-items-center">
                            <i class="bi bi-receipt me-2"></i> Detail Transaksi Peminjaman
                        </h4>
                    </div>
                    
                    <div class="card-body p-4 text-center">
                        {{-- Bundaran Icon Dokumen Transaksi di Tengah --}}
                        <div class="d-flex justify-content-center mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 90px; height: 90px; background-color: #f8f9fa; border: 2px solid #dee2e6;">
                                <i class="bi bi-file-earmark-text text-secondary" style="font-size: 2.5rem;"></i>
                            </div>
                        </div>
                        
                        <h3 class="fw-bold text-gray-800 mb-2">{{ $transaksi->kode_transaksi }}</h3>
                        
                        {{-- Badge Status Peminjaman --}}
                        <div class="mb-4">
                            @if($transaksi->status == 'Dipinjam')
                                <span class="badge bg-warning text-dark px-3 py-2 fw-semibold d-inline-flex align-items-center" style="border-radius: 4px; font-size: 0.85rem;">
                                    <i class="bi bi-clock-history me-1"></i> Dipinjam
                                </span>
                            @else
                                <span class="badge bg-success text-white px-3 py-2 fw-semibold d-inline-flex align-items-center" style="border-radius: 4px; font-size: 0.85rem;">
                                    <i class="bi bi-check-circle me-1"></i> Sudah Dikembalikan
                                endspan
                            @endif
                        </div>

                        {{-- Baris Informasi Detail bergaya List Ikon (Disamakan dengan halaman Anggota) --}}
                        <div class="text-start mx-auto mt-4" style="max-width: 550px;">
                            <table class="table table-borderless align-middle m-0">
                                <tr style="border-bottom: 1px solid #f1f1f1;">
                                    <td width="200" class="py-2 text-muted fw-medium">
                                        <i class="bi bi-hash text-success me-2"></i> Kode Transaksi
                                    </td>
                                    <td class="py-2 text-danger fw-bold">: {{ $transaksi->kode_transaksi }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #f1f1f1;">
                                    <td class="py-2 text-muted fw-medium">
                                        <i class="bi bi-person text-success me-2"></i> Nama Anggota
                                    </td>
                                    <td class="py-2 text-dark">: {{ $transaksi->anggota->nama ?? $transaksi->nama_anggota }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #f1f1f1;">
                                    <td class="py-2 text-muted fw-medium">
                                        <i class="bi bi-book text-success me-2"></i> Judul Buku
                                    </td>
                                    <td class="py-2 text-dark">: {{ $transaksi->buku->judul ?? $transaksi->judul_buku }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #f1f1f1;">
                                    <td class="py-2 text-muted fw-medium">
                                        <i class="bi bi-calendar-event text-success me-2"></i> Tanggal Pinjam
                                    </td>
                                    <td class="py-2 text-dark">: {{ \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->format('d M Y') }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #f1f1f1;">
                                    <td class="py-2 text-muted fw-medium">
                                        <i class="bi bi-calendar-x text-success me-2"></i> Batas Kembali
                                    </td>
                                    <td class="py-2 text-dark">: {{ \Carbon\Carbon::parse($transaksi->tanggal_kembali)->format('d M Y') }}</td>
                                </tr>
                            </table>
                        </div>

                        {{-- Kotak Denda Keterlambatan Lembut (Gaya Alert Tipis Transparan) --}}
                        @if($transaksi->status == 'Dipinjam')
                            @php
                                $hariIni = \Carbon\Carbon::now()->startOfDay();
                                $batasKembali = \Carbon\Carbon::parse($transaksi->tanggal_kembali)->startOfDay();
                                $terlambat = $hariIni->diffInDays($batasKembali, false);
                            @endphp

                            @if($terlambat < 0)
                                @php
                                    $jumlahHari = abs($terlambat);
                                    $denda = $jumlahHari * 5000;
                                @endphp
                                <div class="mt-4 p-3 text-start mx-auto alert-danger border-0 d-flex align-items-center shadow-sm" style="max-width: 550px; border-radius: 6px; background-color: #fff5f5; border-left: 4px solid #dc3545 !important;">
                                    <i class="bi bi-exclamation-triangle-fill text-danger fs-3 me-3"></i>
                                    <div>
                                        <div class="fw-bold text-danger" style="font-size: 0.95rem;">Terlambat {{ $jumlahHari }} Hari!</div>
                                        <div class="text-muted small">Estimasi denda saat ini sebesar: <span class="fw-bold text-danger">Rp {{ number_format($denda, 0, ',', '.') }}</span></div>
                                    </div>
                                </div>
                            @endif
                        @endif

                    </div>
                </div>
            </div>
                        
            {{-- Kolom Kanan: Card Aksi Abu-abu --}}
            <div class="col-md-4">
                <div class="card shadow-sm border-0" style="border-radius: 8px;">
                    <div class="card-header text-white px-3 py-2 d-flex align-items-center" style="background-color: #6c757d; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                        <h6 class="mb-0 small fw-medium d-flex align-items-center">
                            <i class="bi bi-gear me-1"></i> Aksi
                        </h6>
                    </div>
                    <div class="card-body d-grid gap-2 p-3">
                        
                        {{-- Tombol Tindakan Pengembalian --}}
                        @if($transaksi->status == 'Dipinjam')
                            <form action="{{ route('transaksi.kembalikan', $transaksi->id) }}" method="POST" class="w-100 m-0">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success w-100 py-2 fw-medium d-flex align-items-center justify-content-center" style="font-size: 0.9rem; border-radius: 4px;">
                                    <i class="bi bi-box-arrow-in-left me-1"></i> Kembalikan Buku
                                </button>
                            </form>
                        @endif
                        
                        {{-- Tombol Kembali Ke Daftar Utama --}}
                        <a href="{{ route('transaksi.index') }}" class="btn btn-outline-success w-100 py-2 fw-medium d-flex align-items-center justify-content-center" style="font-size: 0.9rem; border-radius: 4px; background-color: #ffffff; color: #198754; border-color: #198754;">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>