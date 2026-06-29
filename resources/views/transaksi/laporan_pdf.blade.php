<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Resmi Transaksi Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background-color: #fff; 
            font-family: "Times New Roman", Times, serif; /* Font standar dokumen formal */
            color: #000;
            line-height: 1.2;
        }
        .line-double {
            border-top: 4px double #000; /* Garis kop surat khas dokumen dinas */
            margin-top: 5px;
            margin-bottom: 20px;
        }
        .table {
            border-color: #000 !important;
        }
        .table th {
            background-color: #f2f2f2 !important; /* Warna abu-abu formal standar */
            color: #000 !important;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
            font-size: 14px;
            border: 1px solid #000 !important;
        }
        .table td {
            font-size: 13px;
            border: 1px solid #000 !important;
        }
        .ttd-container {
            margin-top: 50px;
            float: right;
            text-align: center;
            width: 250px;
            font-size: 14px;
        }
        .ttd-space {
            height: 80px; /* Space untuk tanda tangan fisik */
        }
        @media print { 
            .no-print { display: none; } 
            body { padding: 0; }
        }
    </style>
</head>
<body class="p-4">

    <div class="container">
        <div class="row align-items-center text-center">
            <div class="col-12">
                <h4 class="fw-bold m-0 uppercase" style="font-size: 18px; letter-spacing: 0.5px;">PERPUSTAKAAN PUSAT KOTA</h4>
                <h3 class="fw-bold m-0 uppercase" style="font-size: 22px;">SISTEM INFORMASI MANAJEMEN PERPUSTAKAAN</h3>
                <p class="m-0 text-muted" style="font-size: 12px; font-style: italic;">Jl. Teknokrat No. 123, Kota Baru, Telp: (021) 555-6789 | Email: info@perpustakaan.go.id</p>
            </div>
        </div>
        <div class="line-double"></div>

        <div class="text-center mb-4">
            <h5 class="fw-bold text-uppercase m-0" style="text-decoration: underline; font-size: 16px;">LAPORAN DATA TRANSAKSI PEMINJAMAN BUKU</h5>
            <p class="m-0 mt-1" style="font-size: 13px;">Waktu Cetak: {{ date('d F Y H:i') }} WIB</p>
        </div>

        <div class="mb-3" style="font-size: 14px;">
            <table class="table table-borderless w-auto m-0 p-0" style="line-height: 1.5;">
                <tr>
                    <td class="p-0 pe-3 fw-bold" style="border:none !important;">Total Koleksi Terpinjam</td>
                    <td class="p-0 pe-2" style="border:none !important;">:</td>
                    <td class="p-0 fw-bold" style="border:none !important;">{{ $totalTransaksi }} Eksemplar</td>
                </tr>
                <tr>
                    <td class="p-0 pe-3 fw-bold" style="border:none !important;">Total Akumulasi Denda</td>
                    <td class="p-0 pe-2" style="border:none !important;">:</td>
                    <td class="p-0 fw-bold" style="border:none !important;">Rp {{ number_format($totalDenda, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 13%">Kode Transaksi</th>
                    <th>Nama Anggota</th>
                    <th>Judul Buku</th>
                    <th style="width: 12%">Tgl Pinjam</th>
                    <th style="width: 12%">Batas Kembali</th>
                    <th style="width: 12%">Status</th>
                    <th style="width: 13%">Denda</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksis as $transaksi)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}.</td>
                    <td class="text-center fw-bold">{{ $transaksi->kode_transaksi }}</td>
                    <td>{{ $transaksi->anggota->nama ?? '-' }}</td>
                    <td>{{ $transaksi->buku->judul ?? '-' }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->format('d/m/Y') }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($transaksi->tanggal_kembali)->format('d/m/Y') }}</td>
                    <td class="text-center">{{ $transaksi->status }}</td>
                    
                    {{-- PERHITUNGAN DENDA DINAMIS PADA CETAKAN PDF --}}
                    <td class="text-end">
                        @if($transaksi->status == 'Dikembalikan')
                            Rp {{ number_format($transaksi->denda, 0, ',', '.') }}
                        @else
                            @if($transaksi->terlambat > 0)
                                Rp {{ number_format($transaksi->terlambat * 5000, 0, ',', '.') }}
                            @else
                                Rp 0
                            @endif
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="clearfix">
            <div class="ttd-container">
                <p class="m-0">Kota Baru, {{ date('d F Y') }}</p>
                <p class="m-0 fw-bold">Kepala Unit Perpustakaan,</p>
                <div class="ttd-space"></div>
                <p class="m-0 fw-bold" style="text-decoration: underline;">( Nama Pejabat / Admin )</p>
                <p class="m-0 text-muted" style="font-size: 12px;">NIP. 19920823 202603 1 002</p>
            </div>
        </div>

        <div class="text-end mt-4 no-print">
            <button onclick="window.print()" class="btn btn-dark px-4 font-monospace fw-bold">
                PRINT / SAVE AS PDF
            </button>
        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => { window.print(); }, 600);
        });
    </script>
</body>
</html>