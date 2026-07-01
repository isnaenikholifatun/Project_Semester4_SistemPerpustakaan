<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <h1 class="fs-3 fw-bold text-gray-800 mb-4">Dashboard Perpustakaan</h1>

                {{-- 1. Statistik Utama (4 Card Atas Berjajar) --}}
                <div class="row mb-4 row-cols-1 row-cols-md-4 g-3">
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
                </div>

                {{-- 2. BARIS KETERLAMBATAN: Peringatan Menyatu di dalam Card Terlambat --}}
                @if(isset($jumlahTerlambat) && $jumlahTerlambat > 0)
                    <div class="row mb-4">
                        <div class="col-12">
                            {{-- Card Utama Terlambat (Warna Dasar Merah Lembut dengan Border Samping Merah Tegas) --}}
                            <div class="card shadow-sm p-4 h-100" style="background-color: #fff5f5; border: 1px solid #f5c6cb; border-left: 5px solid #dc3545 !important; border-radius: 8px;">
                                <div class="row align-items-start g-3">
                                    
                                    {{-- BAGIAN POJOK KIRI: Indikator Angka & Badge Terlambat --}}
                                    <div class="col-md-3 d-flex align-items-center gap-3 border-end border-danger border-opacity-25 pe-3">
                                        <div class="bg-danger text-white p-3 rounded-3 fs-3 d-flex align-items-center justify-content-center" style="width: 55px; height: 55px; flex-shrink: 0;">
                                            <i class="bi bi-clock-history"></i>
                                        </div>
                                        <div>
                                            <h6 class="text-muted small mb-1 text-uppercase fw-bold">Terlambat</h6>
                                            <h2 class="fw-bold m-0 fs-2 text-danger">{{ $jumlahTerlambat }}</h2>
                                        </div>
                                    </div>

                                    {{-- BAGIAN DALAM / KANAN: Isi Pesan Peringatan & List Anggota --}}
                                    <div class="col-md-9 ps-md-4">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-exclamation-triangle-fill text-danger me-2 fs-5"></i>
                                            <h5 class="fw-bold m-0 text-danger">Peringatan Keterlambatan Pengembalian!</h5>
                                        </div>
                                        
                                        <p class="mb-2 text-dark small">
                                            Saat ini terdapat <strong>{{ $jumlahTerlambat }} transaksi</strong> yang belum dikembalikan dan telah melewati batas waktu.
                                        </p>
                                        
                                        <hr class="my-2 text-danger opacity-25">
                                        
                                        {{-- List Anggota yang Terlambat --}}
                                        <ul class="mb-0 ps-3 text-dark small" style="list-style-type: square;">
                                            @foreach($transaksiTerlambat as $terlambat)
                                                @php
                                                    $tglKembali = \Carbon\Carbon::parse($terlambat->tanggal_kembali)->startOfDay();
                                                    $hariIni = \Carbon\Carbon::now()->startOfDay();
                                                    $selisihHari = $tglKembali->diffInDays($hariIni);
                                                @endphp
                                                <li class="mb-1">
                                                    <strong>{{ $terlambat->anggota->nama }}</strong> meminjam buku 
                                                    <span class="text-primary fw-medium">"{{ $terlambat->buku->judul ?? 'Buku dihapus' }}"</span> 
                                                    (Batas Kembali: {{ $tglKembali->format('d M Y') }}) 
                                                    <span class="badge bg-danger ms-1" style="font-size: 0.75rem;">Terlambat {{ $selisihHari }} Hari</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- 3. Aksi Cepat --}}
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

                {{-- 4. Transaksi Terbaru --}}
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