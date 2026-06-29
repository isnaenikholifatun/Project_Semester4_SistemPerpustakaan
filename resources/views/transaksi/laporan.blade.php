<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Header Halaman --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="fs-3 fw-bold text-gray-800 m-0">
                        <i class="bi bi-file-earmark-bar-graph-fill text-primary"></i>
                        Laporan Transaksi Peminjaman
                    </h1>
                </div>

                {{-- FORM FILTER --}}
                <div class="card bg-light mb-4 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('transaksi.laporan') }}" method="GET">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label font-semibold text-muted text-xs uppercase">Dari Tanggal</label>
                                    <input type="date" name="dari_tanggal" class="form-control" value="{{ request('dari_tanggal') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label font-semibold text-muted text-xs uppercase">Sampai Tanggal</label>
                                    <input type="date" name="sampai_tanggal" class="form-control" value="{{ request('sampai_tanggal') }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label font-semibold text-muted text-xs uppercase">Status Buku</label>
                                    <select name="status" class="form-select">
                                        <option value="Semua" {{ request('status') == 'Semua' ? 'selected' : '' }}>Semua Status</option>
                                        <option value="Dipinjam" {{ request('status') == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                        <option value="Dikembalikan" {{ request('status') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label font-semibold text-muted text-xs uppercase">Anggota</label>
                                    <select name="anggota_id" class="form-select">
                                        <option value="">Semua Anggota</option>
                                        @foreach($anggotas as $anggota)
                                            <option value="{{ $anggota->id }}" {{ request('anggota_id') == $anggota->id ? 'selected' : '' }}>
                                                {{ $anggota->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="bi bi-funnel-fill"></i> Terapkan Filter
                                    </button>
                                    <a href="{{ route('transaksi.laporan') }}" class="btn btn-outline-secondary">Reset</a>
                                </div>
                                <a href="{{ route('transaksi.laporan.pdf', request()->all()) }}" target="_blank" class="btn btn-danger px-4">
                                    <i class="bi bi-file-pdf-fill"></i> Export ke PDF
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- WIDGET RINGKASAN DATA --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card border-primary bg-light">
                            <div class="card-body">
                                <small class="text-muted text-uppercase d-block fw-semibold mb-1" style="font-size: 11px;">Total Transaksi</small>
                                <h2 class="m-0 fw-bold text-primary">{{ $totalTransaksi }} Data</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-danger bg-light">
                            <div class="card-body">
                                <small class="text-muted text-uppercase d-block fw-semibold mb-1" style="font-size: 11px;">Total Denda</small>
                                <h2 class="m-0 fw-bold text-danger">Rp {{ number_format($totalDenda, 0, ',', '.') }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TABEL LAPORAN --}}
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Nama Anggota</th>
                                        <th>Judul Buku</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Batas Kembali</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-end">Denda</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transaksis as $transaksi)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><code>{{ $transaksi->kode_transaksi }}</code></td>
                                        <td>{{ $transaksi->anggota->nama ?? '-' }}</td>
                                        <td>{{ $transaksi->buku->judul ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->format('d M Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_kembali)->format('d M Y') }}</td>
                                        
                                        {{-- STATUS BADGE DARI MODEL --}}
                                        <td class="text-center">
                                            {!! $transaksi->status_badge !!}
                                        </td>
                                        
                                        {{-- PERHITUNGAN DENDA DINAMIS --}}
                                        <td class="text-end fw-semibold">
                                            @if($transaksi->status == 'Dikembalikan')
                                                <span class="{{ $transaksi->denda > 0 ? 'text-danger' : 'text-muted' }}">
                                                    Rp {{ number_format($transaksi->denda, 0, ',', '.') }}
                                                </span>
                                            @else
                                                @if($transaksi->terlambat > 0)
                                                    <span class="text-danger fw-bold">
                                                        Rp {{ number_format($transaksi->terlambat * 5000, 0, ',', '.') }}
                                                    </span>
                                                @else
                                                    <span class="text-success">Rp 0</span>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">Tidak ditemukan data transaksi.</td>
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