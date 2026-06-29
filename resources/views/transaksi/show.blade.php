<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Header Halaman --}}
                <div class="d-flex justify-content-between align-items-center mb-4 border-b pb-3">
                    <h1 class="fs-3 fw-bold text-gray-800 m-0">
                        <i class="bi bi-info-circle-fill text-info"></i>
                        Detail Transaksi Peminjaman
                    </h1>
                    <span class="badge {{ $transaksi->status == 'Dipinjam' ? 'bg-warning text-dark' : 'bg-success' }} fs-6 px-3 py-2">
                        {{ $transaksi->status }}
                    </span>
                </div>

                {{-- Flash Message (Pesan Sukses / Gagal) --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="auto-close-alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="auto-close-alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Informasi Data Utama --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <table class="table table-borderless sm:text-sm">
                            <tr>
                                <th width="40%">Kode Transaksi</th>
                                <td>: <code>{{ $transaksi->kode_transaksi }}</code></td>
                            </tr>
                            <tr>
                                <th>Nama Anggota</th>
                                <td>: {{ $transaksi->anggota->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Judul Buku</th>
                                <td>: {{ $transaksi->buku->judul ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless sm:text-sm">
                            <tr>
                                <th width="40%">Tanggal Pinjam</th>
                                <td>: {{ is_root_obj($transaksi->tanggal_pinjam) ? $transaksi->tanggal_pinjam->format('d M Y') : \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <th>Batas Kembali</th>
                                <td>: {{ is_root_obj($transaksi->tanggal_kembali) ? $transaksi->tanggal_kembali->format('d M Y') : \Carbon\Carbon::parse($transaksi->tanggal_kembali)->format('d M Y') }}</td>
                            </tr>
                            @if($transaksi->status == 'Dikembalikan')
                            <tr>
                                <th>Tanggal Dikembalikan</th>
                                <td>: {{ is_root_obj($transaksi->tanggal_dikembalikan) ? $transaksi->tanggal_dikembalikan->format('d M Y') : \Carbon\Carbon::parse($transaksi->tanggal_dikembalikan)->format('d M Y') }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                {{-- PANEL PERHITUNGAN DENDA --}}
                <div class="card bg-light mb-4">
                    <div class="card-body">
                        <h5 class="card-title fs-6 fw-bold text-secondary mb-2">Informasi Pengembalian & Perhitungan Denda</h5>
                        
                        @if($transaksi->status == 'Dikembalikan')
                            <p class="card-text text-muted mb-1">Status Pengembalian: <span class="text-success fw-bold">Buku Sudah Diterima</span></p>
                            <h3 class="text-danger fw-bold m-0">Total Denda: Rp {{ number_format($transaksi->denda, 0, ',', '.') }}</h3>
                        @else
                            @if($transaksi->terlambat > 0)
                                <div class="alert alert-danger m-0" role="alert">
                                    <i class="bi bi-exclamation-octagon-fill me-2"></i>
                                    <strong>Terlambat {{ $transaksi->terlambat }} Hari!</strong> Estimasi denda saat ini sebesar: 
                                    <span class="fs-5 d-block mt-1 fw-bold">Rp {{ number_format($transaksi->terlambat * 5000, 0, ',', '.') }}</span>
                                </div>
                            @else
                                <p class="text-success m-0 font-medium">
                                    <i class="bi bi-shield-check me-1"></i> Buku belum melewati batas pengembalian. Bebas denda!
                                </p>
                            @endif
                        @endif
                    </div>
                </div>

                {{-- TOMBOL AKSI KEMBALIKAN BUKU --}}
                <div class="d-flex gap-2 border-top pt-3">
                    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali Ke Daftar
                    </a>

                    @if($transaksi->status == 'Dipinjam')
                        <form action="{{ route('transaksi.kembalikan', $transaksi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memproses pengembalian buku ini? Stok buku akan bertambah otomatis +1.')">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-box-arrow-in-left"></i> Kembalikan Buku
                            </button>
                        </form>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

@php
// Helper pengecekan objek Carbon internal blade agar tidak crash
function is_root_obj($val) {
    return is_object($val) && method_exists($val, 'format');
}
@endphp

{{-- SCRIPT JAVASCRIPT UNTUK MENUTUP ALERT OTOMATIS SETELAH 5 DETIK --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const alertElement = document.getElementById('auto-close-alert');
        if (alertElement) {
            setTimeout(function() {
                if (typeof bootstrap !== 'undefined' && bootstrap.Alert) {
                    const bsAlert = new bootstrap.Alert(alertElement);
                    bsAlert.close();
                } else {
                    alertElement.classList.remove('show');
                    alertElement.classList.add('fade');
                    setTimeout(() => alertElement.remove(), 150);
                }
            }, 5000);
        }
    });
</script>