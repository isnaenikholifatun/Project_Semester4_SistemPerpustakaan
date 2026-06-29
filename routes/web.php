<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

// Redirect ke halaman login jika akses root
Route::get('/', function () {
    return redirect()->route('login');
});

// Grup route yang butuh login (Auth)
Route::middleware(['auth'])->group(function () {
    
    // Dashboard Mengirim data keterlambatan secara dinamis + Statistik Utama
    Route::get('/dashboard', function () {
        $hariIni = \Carbon\Carbon::now()->startOfDay();
        
        // 1. Ambil kembali data statistik utama agar kotak di dashboard terisi
        $totalBuku = \App\Models\Buku::count();
        $totalAnggota = \App\Models\Anggota::count();
        $totalDipinjam = \App\Models\Transaksi::where('status', 'Dipinjam')->count();
        $transaksiHariIni = \App\Models\Transaksi::whereDate('created_at', \Carbon\Carbon::today())->count();
        $transaksiTerbaru = \App\Models\Transaksi::with(['anggota', 'buku'])->latest()->take(5)->get();

        // 2. Data keterlambatan
        $transaksiTerlambat = \App\Models\Transaksi::with(['anggota', 'buku'])
            ->where('status', 'Dipinjam')
            ->whereDate('tanggal_kembali', '<', $hariIni->format('Y-m-d'))
            ->get();

        $jumlahTerlambat = $transaksiTerlambat->count();

        // 3. Kirim SEMUA variabel ke halaman dashboard
        return view('dashboard', compact(
            'totalBuku', 
            'totalAnggota', 
            'totalDipinjam', 
            'transaksiHariIni', 
            'transaksiTerbaru',
            'jumlahTerlambat', 
            'transaksiTerlambat'
        ));
    })->name('dashboard');

    // Profile (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Buku
    Route::get('/buku/search', [BukuController::class, 'search'])->name('buku.search');
    Route::get('buku/kategori/{kategori}', [BukuController::class, 'filterKategori'])->name('buku.kategori');
    Route::post('/buku/bulk-delete', [BukuController::class, 'bulkDelete'])->name('buku.bulk-delete');
    Route::get('/buku/export', [BukuController::class, 'export'])->name('buku.export');
    Route::resource('buku', BukuController::class);

    // Anggota
    Route::get('/anggota/export', [AnggotaController::class, 'export'])->name('anggota.export');
    Route::get('/anggota/search', [AnggotaController::class, 'search'])->name('anggota.search');
    Route::resource('anggota', AnggotaController::class);

    // Transaksi 
    Route::get('/transaksi/laporan', [TransaksiController::class, 'laporan'])->name('transaksi.laporan');
    Route::get('/transaksi/laporan/pdf', [TransaksiController::class, 'laporanPdf'])->name('transaksi.laporan.pdf');
    
    Route::resource('transaksi', TransaksiController::class);
    Route::put('/transaksi/{id}/kembalikan', [TransaksiController::class, 'kembalikan'])->name('transaksi.kembalikan');
});

// Auth Breeze (Login, Register, dll)
require __DIR__.'/auth.php';