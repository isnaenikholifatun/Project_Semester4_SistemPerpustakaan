<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;

class DashboardController extends Controller
{
    public function index()
    {
        // Data Statistik Buku
        $totalBuku = Buku::count();
        $bukuTersedia = Buku::where('stok', '>', 0)->count();
        $bukuHabis = Buku::where('stok', '<=', 0)->count();

        // Data Statistik Anggota
        // Asumsi di database tabel anggota ada kolom 'status' dengan value 'aktif' / 'nonaktif'
        $totalAnggota = Anggota::count();
        $anggotaAktif = Anggota::where('status', 'aktif')->count();
        $anggotaNonaktif = Anggota::where('status', 'nonaktif')->count();

        // Data 5 Terbaru
        $bukuTerbaru = Buku::latest()->take(5)->get();
        $anggotaTerbaru = Anggota::latest()->take(5)->get();

        // Kirim data ke view
        return view('dashboard.index', compact(
            'totalBuku', 
            'bukuTersedia', 
            'bukuHabis',
            'totalAnggota', 
            'anggotaAktif', 
            'anggotaNonaktif',
            'bukuTerbaru', 
            'anggotaTerbaru'
        ));
    }
}