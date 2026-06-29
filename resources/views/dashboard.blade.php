<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <h1 class="fs-3 fw-bold text-gray-800 mb-4">Dashboard Perpustakaan</h1>

                {{-- Statistik Utama (Sekarang Menjadi 5 Card Sejajar) --}}
                <div class="row mb-4 row-cols-1 row-cols-md-5 g-3">
                    <div class="col">
                        <div class="card border-0 shadow-sm p-3 d-flex flex-row align-items-center gap-3 h-100">
                            <div class="bg-primary text-white p-3 rounded-3 fs-3 d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                                <i class="bi bi-book"></i>
                            </div>
                            <div>
                                <h6 class="text-muted small mb-1">Total Buku</h6>
                                <h2 class="fw-bold m-0 fs-3">{{ $totalBuku }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card border-0 shadow-sm p-3 d-flex flex-row align-items-center gap-3 h-100">
                            <div class="bg-success text-white p-3 rounded-3 fs-3 d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                                <i class="bi bi-people"></i>
                            </div>
                            <div>
                                <h6 class="text-muted small mb-1">Total Anggota</h6>
                                <h2 class="fw-bold m-0 fs-3">{{ $totalAnggota }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card border-0 shadow-sm p-3 d-flex flex-row align-items-center gap-3 h-100">
                            <div class="bg-warning text-white p-3 rounded-3 fs-3 d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                                <i class="bi bi-arrow-left-right"></i>
                            </div>
                            <div>
                                <h6 class="text-muted small mb-1">Dipinjam</h6>
                                <h2 class="fw-bold m-0 fs-3">{{ $totalDipinjam }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card border-0 shadow-sm p-3 d-flex flex-row align-items-center gap-3 h-100">
                            <div class="bg-info text-white p-3 rounded-3 fs-3 d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                            <div>
                                <h6 class="text-muted small mb-1">Transaksi Hari Ini</h6>
                                <h2 class="fw-bold m-0 fs-3">{{ $transaksiHariIni }}</h2>
                            </div>
                        </div>
                    </div>
                    {{-- CARD BARU: BUKU TERLAMBAT (IKUT DESAIN MINIMALIS BAWAAN) --}}
                    <div class="col">
                        <div class="card border-0 shadow-sm p-3 d-flex flex-row align-items-center gap-3 h-100">
                            <div class="bg-danger text-white p-3 rounded-3 fs-3 d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                                <i class="bi bi-clock-history"></i>
                            </div>
                            <div>
                                <h6 class="text-muted small mb-1">Terlambat</h6>
                                <h2 class="fw-bold m-0 fs-3 text-danger">{{ $jumlahTerlambat ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ALERT NOTIFIKASI KETERLAMBATAN & LIST ANGGOTA --}}
                @if(isset($jumlahTerlambat) && $jumlahTerlambat > 0)
                    <div class="alert alert-danger shadow-sm border-start border-danger border-4 mb-4" role="alert">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-exclamation-triangle-fill text-danger me-2 fs-4"></i>
                            <h5 class="alert-heading fw-bold m-0 text-danger">Peringatan Keterlambatan Pengembalian!</h5>
                        </div>
                        <p class="mb-2">Saat ini terdapat <strong>{{ $jumlahTerlambat }} transaksi</strong> yang belum dikembalikan dan telah melewati batas waktu.</p>
                        <hr class="my-2 text-danger">
                        
                        {{-- List Detail Anggota yang Terlambat dengan Tambahan Selisih Hari --}}
                        <ul class="mb-0 ps-3 text-dark small">
                            @foreach($transaksiTerlambat as $terlambat)
                                @php
                                    $tglKembali = \Carbon\Carbon::parse($terlambat->tanggal_kembali)->startOfDay();
                                    $hariIni = \Carbon\Carbon::now()->startOfDay();
                                    $selisihHari = $tglKembali->diffInDays($hariIni);
                                @endphp
                                <li class="mb-1">
                                    <strong>{{ $terlambat->anggota->nama }}</strong> meminjam buku 
                                    <span class="text-primary">"{{ $terlambat->buku->judul ?? 'Buku dihapus' }}"</span> 
                                    (Batas Kembali: {{ $tglKembali->format('d M Y') }}) 
                                    <span class="badge bg-danger ms-1">Terlambat {{ $selisihHari }} Hari</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Aksi Cepat --}}
                <div class="mb-4">
                    <h5 class="fw-bold text-gray-700 mb-3">Aksi Cepat</h5>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('buku.create') }}" class="card border-0 shadow-sm p-3 text-decoration-none bg-primary bg-opacity-10 hover-shadow transition-all">
                                <div class="d-flex align-items-center gap-2 text-primary fw-bold">
                                    <i class="bi bi-plus-lg"></i> Tambah Buku
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('anggota.create') }}" class="card border-0 shadow-sm p-3 text-decoration-none bg-success bg-opacity-10 hover-shadow transition-all">
                                <div class="d-flex align-items-center gap-2 text-success fw-bold">
                                    <i class="bi bi-person-plus"></i> Tambah Anggota
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('transaksi.create') }}" class="card border-0 shadow-sm p-3 text-decoration-none bg-warning bg-opacity-10 hover-shadow transition-all">
                                <div class="d-flex align-items-center gap-2 text-warning-dark fw-bold">
                                    <i class="bi bi-arrow-left-right"></i> Pinjam Buku
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('transaksi.index') }}" class="card border-0 shadow-sm p-3 text-decoration-none bg-purple bg-opacity-10 hover-shadow transition-all">
                                <div class="d-flex align-items-center gap-2 text-purple fw-bold">
                                    <i class="bi bi-list-task"></i> Lihat Transaksi
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Transaksi Terbaru --}}
                <div>
                    <h5 class="fw-bold text-gray-700 mb-3">Transaksi Terbaru</h5>
                    <div class="table-responsive bg-white rounded shadow-sm">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>KODE</th>
                                    <th>ANGGOTA</th>
                                    <th>BUKU</th>
                                    <th>TANGGAL PINJAM</th>
                                    <th>STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksiTerbaru as $terbaru)
                                    <tr>
                                        <td><code>{{ $terbaru->kode_transaksi }}</code></td>
                                        <td>{{ $terbaru->anggota->nama ?? '-' }}</td>
                                        <td>{{ $terbaru->buku->judul ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($terbaru->tanggal_pinjam)->format('d M Y') }}</td>
                                        <td>
                                            @if($terbaru->status == 'Dipinjam')
                                                <span class="badge bg-warning text-dark px-2.5 py-1.5 rounded">Dipinjam</span>
                                            @else
                                                <span class="badge bg-success px-2.5 py-1.5 rounded">Dikembalikan</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-3">Belum ada transaksi terbaru</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>