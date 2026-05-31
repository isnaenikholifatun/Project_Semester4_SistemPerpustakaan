<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;



class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //// Ambil semua data buku dari database
        $bukus = Buku::latest()->get();
        
        // Statistik untuk card
        $totalBuku = Buku::count();
        $bukuTersedia = Buku::where('stok', '>', 0)->count();
        $bukuHabis = Buku::where('stok', 0)->count();
        
        // Return view dengan data
        return view('buku.index', compact(
            'bukus','totalBuku','bukuTersedia','bukuHabis'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('buku.create');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $buku = Buku::findOrFail($id);
        return view('buku.show', compact('buku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $buku = Buku::findOrFail($id);
        return view('buku.edit', compact('buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
public function search(Request $request)
{
    $query = Buku::query();

    // Search keyword
    if ($request->keyword) {

        $query->where(function ($q) use ($request) {

            $q->where('judul', 'like', '%' . $request->keyword . '%')
              ->orWhere('pengarang', 'like', '%' . $request->keyword . '%')
              ->orWhere('penerbit', 'like', '%' . $request->keyword . '%');

        });
    }

    // Filter kategori
    if ($request->kategori) {

        $query->where('kategori', $request->kategori);

    }

    // Filter tahun
    if ($request->tahun) {

        $query->where('tahun_terbit', $request->tahun);

    }

    // Filter stok tersedia
    if ($request->ketersediaan == 'tersedia') {

        $query->where('stok', '>', 0);

    }

    // Filter stok habis
    if ($request->ketersediaan == 'habis') {

        $query->where('stok', 0);

    }

    $bukus = $query->latest()->get();

    // Statistik
    $totalBuku = Buku::count();
    $bukuTersedia = Buku::where('stok', '>', 0)->count();
    $bukuHabis = Buku::where('stok', 0)->count();

    return view('buku.index', compact(
        'bukus',
        'totalBuku',
        'bukuTersedia',
        'bukuHabis'
    ));
}
    
}