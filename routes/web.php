<?php
 
use Illuminate\Support\Facades\Route;
use App\Models\Buku;
use App\Models\Anggota;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/buku/search', [BukuController::class, 'search'])
    ->name('buku.search');

Route::get('buku/kategori/{kategori}', [BukuController::class, 'filterKategori'])
    ->name('buku.kategori');

Route::post('/buku/bulk-delete', [BukuController::class, 'bulkDelete'])
    ->name('buku.bulk-delete');

Route::get('/buku/export', [BukuController::class, 'export'])
    ->name('buku.export');
    
Route::resource('buku', BukuController::class);

Route::resource('anggota', AnggotaController::class);

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');
    
//TESTING BUKU
 
// List all buku
// Route::get('/buku', function () {
//     $bukus = Buku::all();
    
//     $html = '<h1>Daftar Buku</h1>';
//     $html .= '<a href="/buku/create">Tambah Buku</a><br /><br />';
//     $html .= '<table border="1" cellpadding="10">';
//     $html .= '<tr>
//                 <th>ID</th>
//                 <th>Kode</th>
//                 <th>Judul</th>
//                 <th>Kategori</th>
//                 <th>Harga</th>
//                 <th>Stok</th>
//                 <th>Aksi</th>
//               </tr>';
    
//     foreach ($bukus as $buku) {
//         $html .= '<tr>';
//         $html .= '<td>' . $buku->id . '</td>';
//         $html .= '<td>' . $buku->kode_buku . '</td>';
//         $html .= '<td>' . $buku->judul . '</td>';
//         $html .= '<td>' . $buku->kategori . '</td>';
//         $html .= '<td>' . $buku->harga_format . '</td>';
//         $html .= '<td>' . $buku->stok . '</td>';
//         $html .= '<td>
//                     <a href="/buku/' . $buku->id . '">Detail</a> | 
//                     <a href="/buku/' . $buku->id . '/edit">Edit</a>
//                   </td>';
//         $html .= '</tr>';
//     }
    
//     $html .= '</table>';
    
//     return $html;
// });
 
// // Show single buku
// Route::get('/buku/{id}', function ($id) {
//     $buku = Buku::findOrFail($id);
    
//     $html = '<h1>Detail Buku</h1>';
//     $html .= '<a href="/buku">Kembali</a><br /><br />';
//     $html .= '<table border="1" cellpadding="10">';
//     $html .= '<tr><th>Field</th><th>Value</th></tr>';
//     $html .= '<tr><td>ID</td><td>' . $buku->id . '</td></tr>';
//     $html .= '<tr><td>Kode Buku</td><td>' . $buku->kode_buku . '</td></tr>';
//     $html .= '<tr><td>Judul</td><td>' . $buku->judul . '</td></tr>';
//     $html .= '<tr><td>Kategori</td><td>' . $buku->kategori . '</td></tr>';
//     $html .= '<tr><td>Pengarang</td><td>' . $buku->pengarang . '</td></tr>';
//     $html .= '<tr><td>Penerbit</td><td>' . $buku->penerbit . '</td></tr>';
//     $html .= '<tr><td>Tahun</td><td>' . $buku->tahun_terbit . '</td></tr>';
//     $html .= '<tr><td>ISBN</td><td>' . $buku->isbn . '</td></tr>';
//     $html .= '<tr><td>Harga</td><td>' . $buku->harga_format . '</td></tr>';
//     $html .= '<tr><td>Stok</td><td>' . $buku->stok . '</td></tr>';
//     $html .= '<tr><td>Tersedia?</td><td>' . ($buku->tersedia ? 'Ya' : 'Tidak') . '</td></tr>';
//     $html .= '<tr><td>Created</td><td>' . $buku->created_at . '</td></tr>';
//     $html .= '<tr><td>Updated</td><td>' . $buku->updated_at . '</td></tr>';
//     $html .= '</table>';
    
//     return $html;
// });
 
// //TESTING ANGGOTA
 
// // List all anggota
// Route::get('/anggota', function () {
//     $anggotas = Anggota::all();
    
//     $html = '<h1>Daftar Anggota</h1>';
//     $html .= '<table border="1" cellpadding="10">';
//     $html .= '<tr>
//                 <th>ID</th>
//                 <th>Kode</th>
//                 <th>Nama</th>
//                 <th>Email</th>
//                 <th>Umur</th>
//                 <th>Status</th>
//                 <th>Aksi</th>
//               </tr>';
    
//     foreach ($anggotas as $anggota) {
//         $html .= '<tr>';
//         $html .= '<td>' . $anggota->id . '</td>';
//         $html .= '<td>' . $anggota->kode_anggota . '</td>';
//         $html .= '<td>' . $anggota->nama . '</td>';
//         $html .= '<td>' . $anggota->email . '</td>';
//         $html .= '<td>' . $anggota->umur . ' tahun</td>';
//         $html .= '<td>' . $anggota->status . '</td>';
//         $html .= '<td><a href="/anggota/' . $anggota->id . '">Detail</a></td>';
//         $html .= '</tr>';
//     }
    
//     $html .= '</table>';
    
//     return $html;
// });
 
// // Show single anggota
// Route::get('/anggota/{id}', function ($id) {
//     $anggota = Anggota::findOrFail($id);
    
//     $html = '<h1>Detail Anggota</h1>';
//     $html .= '<a href="/anggota">Kembali</a><br /><br />';
//     $html .= '<table border="1" cellpadding="10">';
//     $html .= '<tr><th>Field</th><th>Value</th></tr>';
//     $html .= '<tr><td>Kode Anggota</td><td>' . $anggota->kode_anggota . '</td></tr>';
//     $html .= '<tr><td>Nama</td><td>' . $anggota->nama . '</td></tr>';
//     $html .= '<tr><td>Email</td><td>' . $anggota->email . '</td></tr>';
//     $html .= '<tr><td>Telepon</td><td>' . $anggota->telepon . '</td></tr>';
//     $html .= '<tr><td>Alamat</td><td>' . $anggota->alamat . '</td></tr>';
//     $html .= '<tr><td>Tanggal Lahir</td><td>' . $anggota->tanggal_lahir->format('d-m-Y') . '</td></tr>';
//     $html .= '<tr><td>Umur</td><td>' . $anggota->umur . ' tahun</td></tr>';
//     $html .= '<tr><td>Jenis Kelamin</td><td>' . $anggota->jenis_kelamin . '</td></tr>';
//     $html .= '<tr><td>Pekerjaan</td><td>' . $anggota->pekerjaan . '</td></tr>';
//     $html .= '<tr><td>Tanggal Daftar</td><td>' . $anggota->tanggal_daftar->format('d-m-Y') . '</td></tr>';
//     $html .= '<tr><td>Lama Anggota</td><td>' . $anggota->lama_anggota . ' hari</td></tr>';
//     $html .= '<tr><td>Status</td><td>' . $anggota->status . '</td></tr>';
//     $html .= '</table>';
    
//     return $html;
// });
 
// // Testing Scope & Query
// Route::get('/test-query', function () {
//     $html = '<h1>Testing Query Eloquent</h1>';
    
//     // Buku tersedia
//     $tersedia = Buku::tersedia()->get();
//     $html .= '<h3>Buku Tersedia (Stok > 0): ' . $tersedia->count() . '</h3>';
//     $html .= '<ul>';
//     foreach ($tersedia as $buku) {
//         $html .= '<li>' . $buku->judul . ' (Stok: ' . $buku->stok . ')</li>';
//     }
//     $html .= '</ul>';
    
//     // Buku Programming
//     $programming = Buku::kategori('Programming')->get();
//     $html .= '<h3>Buku Programming: ' . $programming->count() . '</h3>';
//     $html .= '<ul>';
//     foreach ($programming as $buku) {
//         $html .= '<li>' . $buku->judul . '</li>';
//     }
//     $html .= '</ul>';
    
//     // Anggota Aktif
//     $aktif = Anggota::aktif()->get();
//     $html .= '<h3>Anggota Aktif: ' . $aktif->count() . '</h3>';
//     $html .= '<ul>';
//     foreach ($aktif as $anggota) {
//         $html .= '<li>' . $anggota->nama . ' (' . $anggota->email . ')</li>';
//     }
//     $html .= '</ul>';
    
//     return $html;
// });

// Route::get('/cek-kategori', function () {
//     return App\Models\Kategori::all();
// });

// //TESTING ACCESSOR & SCOPE

// Route::get('/test-accessor-scope', function () {

//     $html = '
//     <!DOCTYPE html>
//     <html>
//     <head>
//         <meta charset="UTF-8">
//         <title>Testing Accessor & Scope</title>

//         <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

//         <style>

//             body{
//                 background:#f4f8ff;
//                 font-family: Arial, sans-serif;
//             }

//             .judul{
//                 color:#0d6efd;
//                 font-weight:bold;
//             }

//             .custom-table thead{
//                 background:#0d6efd !important;
//                 color:white !important;
//             }

//             .custom-table th{
//                 background:#0d6efd !important;
//                 color:white !important;
//             }

//         </style>

//     </head>

//     <body class="p-4">

//     <div class="container">

//     <h1 class="mb-4 judul">
//         Testing Accessor & Scope
//     </h1>';

//     // SEMUA BUKU
//     $html .= '<h3 class="mt-4 text-primary">Semua Buku</h3>';

//     $html .= '
//     <table class="table table-bordered table-hover bg-white custom-table">

//         <thead>
//             <tr>
//                 <th>Judul</th>
//                 <th>Tahun</th>
//                 <th>Stok</th>
//                 <th>Status Stok</th>
//                 <th>Label Tahun</th>
//             </tr>
//         </thead>

//         <tbody>';

//     foreach (Buku::all() as $buku) {

//         $html .= "
//         <tr>
//             <td>{$buku->judul}</td>
//             <td>{$buku->tahun_terbit}</td>
//             <td>{$buku->stok}</td>
//             <td>{$buku->status_stok_badge}</td>
//             <td>{$buku->tahun_label}</td>
//         </tr>";
//     }

//     $html .= '
//         </tbody>
//     </table>';

//     // BUKU TERBARU
//     $html .= '<h3 class="mt-4 text-primary">Buku Terbaru</h3>';

//     $html .= '
//     <table class="table table-bordered table-hover bg-white custom-table">

//         <thead>
//             <tr>
//                 <th>Judul Buku</th>
//                 <th>Tahun</th>
//             </tr>
//         </thead>

//         <tbody>';

//     $terbaru = Buku::terbaru()->get();

//     if ($terbaru->isEmpty()) {

//         $html .= "
//         <tr>
//             <td colspan='2' class='text-center text-muted'>
//                 Tidak ada data
//             </td>
//         </tr>";

//     } else {

//         foreach ($terbaru as $buku) {

//             $html .= "
//             <tr>
//                 <td>{$buku->judul}</td>
//                 <td>{$buku->tahun_terbit}</td>
//             </tr>";
//         }
//     }

//     $html .= '
//         </tbody>
//     </table>';

//     // BUKU STOK MENIPIS
//     $html .= '<h3 class="mt-4 text-primary">Buku Stok Menipis</h3>';

//     $html .= '
//     <table class="table table-bordered table-hover bg-white custom-table">

//         <thead>
//             <tr>
//                 <th>Judul Buku</th>
//                 <th>Stok</th>
//             </tr>
//         </thead>

//         <tbody>';

//     $menipis = Buku::stokMenipis()->get();

//     if ($menipis->isEmpty()) {

//         $html .= "
//         <tr>
//             <td colspan='2' class='text-center text-muted'>
//                 Tidak ada data
//             </td>
//         </tr>";

//     } else {

//         foreach ($menipis as $buku) {

//             $html .= "
//             <tr>
//                 <td>{$buku->judul}</td>
//                 <td>{$buku->stok}</td>
//             </tr>";
//         }
//     }

//     $html .= '
//         </tbody>
//     </table>';

//     // SEMUA ANGGOTA
//     $html .= '<h3 class="mt-4 text-primary">Semua Anggota</h3>';

//     $html .= '
//     <table class="table table-bordered table-hover bg-white custom-table">

//         <thead>
//             <tr>
//                 <th>Nama</th>
//                 <th>Umur</th>
//                 <th>Jenis Kelamin</th>
//                 <th>Status</th>
//                 <th>Kategori Usia</th>
//             </tr>
//         </thead>

//         <tbody>';

//     foreach (Anggota::all() as $anggota) {

//         $html .= "
//         <tr>
//             <td>{$anggota->nama}</td>
//             <td>{$anggota->umur} tahun</td>
//             <td>{$anggota->jenis_kelamin}</td>
//             <td>{$anggota->status_badge}</td>
//             <td>{$anggota->kategori_usia}</td>
//         </tr>";
//     }

//     $html .= '
//         </tbody>
//     </table>';

//     // ANGGOTA TERDAFTAR BULAN INI
//     $html .= '
//     <h3 class="mt-4 text-primary">
//         Anggota Terdaftar Bulan Ini
//     </h3>';

//     $html .= '<ul class="list-group mb-4">';

//     $bulanIni = Anggota::terdaftarBulanIni()->get();

//     if ($bulanIni->isEmpty()) {

//         $html .= "
//         <li class='list-group-item text-muted'>
//             Tidak ada anggota terdaftar bulan ini
//         </li>";

//     } else {

//         foreach ($bulanIni as $anggota) {

//             $html .= "
//             <li class='list-group-item'>
//                 {$anggota->nama}
//                 ({$anggota->tanggal_daftar->format('d-m-Y')})
//             </li>";
//         }
//     }

//     $html .= '
//     </ul>

//     </div>
//     </body>
//     </html>';

//     return $html;
// });
