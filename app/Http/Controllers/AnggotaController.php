<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Http\Requests\StoreAnggotaRequest; 
use App\Http\Requests\UpdateAnggotaRequest;


class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $anggotas = Anggota::latest()->get();
        
        // Statistik
        $totalAnggota = Anggota::count();
        $anggotaAktif = Anggota::where('status', 'Aktif')->count();
        $anggotaNonaktif = Anggota::where('status', 'Nonaktif')->count();
        
        return view('anggota.index', compact(
            'anggotas',
            'totalAnggota',
            'anggotaAktif',
            'anggotaNonaktif'
        ));
    }

    /**
     * Export data anggota to CSV (Tanpa Package Tambahan).
     */
    public function export()
    {
        $fileName = 'anggota_' . date('Y-m-d_His') . '.csv';
        $anggotas = Anggota::all(); // Mengambil semua data anggota

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Kode', 'Nama', 'Email', 'Telepon', 'Alamat', 'Tanggal Lahir', 'Jenis Kelamin', 'Pekerjaan', 'Status', 'Tanggal Daftar');

        $callback = function() use($anggotas, $columns) {
            $file = fopen('php://output', 'w');
            
            // Tulis baris header (judul kolom)
            fputcsv($file, $columns);

            // Tulis data anggota baris demi baris
            foreach ($anggotas as $anggota) {
                $row['Kode']           = $anggota->kode_anggota;
                $row['Nama']           = $anggota->nama;
                $row['Email']          = $anggota->email;
                $row['Telepon']        = $anggota->telepon;
                $row['Alamat']         = $anggota->alamat;
                $row['Tanggal Lahir']  = $anggota->tanggal_lahir;
                $row['Jenis Kelamin']  = $anggota->jenis_kelamin;
                $row['Pekerjaan']      = $anggota->pekerjaan;
                $row['Status']         = $anggota->status;
                $row['Tanggal Daftar'] = $anggota->tanggal_daftar;

                fputcsv($file, array(
                    $row['Kode'], $row['Nama'], $row['Email'], $row['Telepon'], 
                    $row['Alamat'], $row['Tanggal Lahir'], $row['Jenis Kelamin'], 
                    $row['Pekerjaan'], $row['Status'], $row['Tanggal Daftar']
                ));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Advanced Search & Filter Anggota.
     */
    public function search(Request $request)
    {
        $query = Anggota::query();
        
        if ($request->keyword) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->keyword . '%')
                  ->orWhere('email', 'like', '%' . $request->keyword . '%')
                  ->orWhere('telepon', 'like', '%' . $request->keyword . '%');
            });
        }
        
        if ($request->jenis_kelamin) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->pekerjaan) {
            $query->where('pekerjaan', $request->pekerjaan);
        }
        
        $anggotas = $query->latest()->get();
        
        // Menghitung ulang Statistik berdasarkan hasil filter agar sinkron di layar
        $totalAnggota = $anggotas->count();
        $anggotaAktif = $anggotas->where('status', 'Aktif')->count();
        $anggotaNonaktif = $anggotas->where('status', 'Nonaktif')->count();
        
        return view('anggota.index', compact(
            'anggotas',
            'totalAnggota',
            'anggotaAktif',
            'anggotaNonaktif'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('anggota.show', compact('anggota'));
    }

    public function create()
    {
        $kodeAnggota = $this->generateKodeAnggota();
        return view('anggota.create', compact('kodeAnggota'));
    }   

    public function edit(string $id)
    { 
        $anggota = Anggota::findOrFail($id);
        return view('anggota.edit', compact('anggota'));   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnggotaRequest $request) 
    { 
        try {
            // Create anggota baru dengan validated data
            Anggota::create($request->validated());
                    
            // Redirect dengan success message
            return redirect()->route('anggota.index')
                             ->with('success', 'Anggota berhasil ditambahkan!');
                                 
        } catch (\Exception $e) {
            // Redirect dengan error message jika gagal
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Gagal menambahkan anggota: ' . $e->getMessage());
        }
    }

    /**
    * Update the specified resource in storage.
    */
    public function update(UpdateAnggotaRequest $request, string $id)
    {
        try {
            $anggota = Anggota::findOrFail($id);
            
            // Update anggota dengan validated data
            $anggota->update($request->validated());
            
            // Redirect dengan success message
            return redirect()->route('anggota.show', $anggota->id)
                            ->with('success', 'Data anggota berhasil diupdate!');
                            
        } catch (\Exception $e) {
            // Redirect dengan error message jika gagal
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Gagal mengupdate anggota: ' . $e->getMessage());
        }
    }

    /**
    * Remove the specified resource from storage.
    */
    public function destroy(string $id)
    {
        try {
            $anggota = Anggota::findOrFail($id);
            $namaAnggota = $anggota->nama;
            
            // Delete anggota
            $anggota->delete();
            
            // Redirect dengan success message
            return redirect()->route('anggota.index')
                            ->with('success', "Anggota '{$namaAnggota}' berhasil dihapus!");
                            
        } catch (\Exception $e) {
            // Redirect dengan error message jika gagal
            return redirect()->back()
                            ->with('error', 'Gagal menghapus anggota: ' . $e->getMessage());
        }
    }

    private function generateKodeAnggota()
    {
        $tahun = date('Y');
        $lastAnggota = Anggota::whereYear('created_at', $tahun)
                            ->orderBy('kode_anggota', 'desc')
                            ->first();
        
        if ($lastAnggota) {
            $lastNumber = intval(substr($lastAnggota->kode_anggota, -3));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return 'AGT-' . $tahun . '-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}