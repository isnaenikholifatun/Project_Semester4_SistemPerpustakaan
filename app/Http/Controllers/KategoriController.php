<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // Data dummy kategori
    private $kategori_list = [
        ['id' => 1, 'nama' => 'Programming', 'deskripsi' => 'Buku pemrograman, algoritma, dan coding', 'jumlah_buku' => 25],
        ['id' => 2, 'nama' => 'Desain Grafis', 'deskripsi' => 'Buku desain UI/UX, ilustrasi, dan multimedia', 'jumlah_buku' => 15],
        ['id' => 3, 'nama' => 'Bisnis', 'deskripsi' => 'Buku manajemen, marketing, dan startup', 'jumlah_buku' => 30],
        ['id' => 4, 'nama' => 'Fiksi', 'deskripsi' => 'Kumpulan novel, cerpen, dan sastra', 'jumlah_buku' => 50],
        ['id' => 5, 'nama' => 'Sejarah', 'deskripsi' => 'Buku sejarah dunia, nasional, dan biografi tokoh', 'jumlah_buku' => 20],
    ];

    // Data dummy buku berdasarkan ID kategori
    private $buku_list = [
        1 => [
            ['judul' => 'Belajar Laravel 10', 'penulis' => 'Budi Santoso', 'tahun' => 2023],
            ['judul' => 'Mastering React JS', 'penulis' => 'Ahmad Fauzi', 'tahun' => 2022],
        ],
        2 => [
            ['judul' => 'Prinsip Dasar UI/UX', 'penulis' => 'Dewi Lestari', 'tahun' => 2021],
            ['judul' => 'Ilustrasi Digital untuk Pemula', 'penulis' => 'Rina Sari', 'tahun' => 2020],
        ],
        // Menambahkan data buku untuk Bisnis (ID 3)
        3 => [
            ['judul' => 'Strategi Digital Marketing', 'penulis' => 'Denny Santoso', 'tahun' => 2021],
            ['judul' => 'Zero to One', 'penulis' => 'Peter Thiel', 'tahun' => 2014],
        ],
        // Menambahkan data buku untuk Fiksi (ID 4)
        4 => [
            ['judul' => 'Laskar Pelangi', 'penulis' => 'Andrea Hirata', 'tahun' => 2005],
            ['judul' => 'Negeri 5 Menara', 'penulis' => 'A. Fuadi', 'tahun' => 2009],
        ],
        // Menambahkan data buku untuk Sejarah (ID 5)
        5 => [
            ['judul' => 'Sejarah Dunia yang Disembunyikan', 'penulis' => 'Jonathan Black', 'tahun' => 2007],
            ['judul' => 'Api Sejarah', 'penulis' => 'Ahmad Mansur', 'tahun' => 2010],
        ],
    ];

    public function index()
    {
        $kategori_list = $this->kategori_list;
        return view('kategori.index', compact('kategori_list'));
    }

    public function show($id)
    {
        // Cari kategori berdasarkan ID menggunakan collection
        $kategori = collect($this->kategori_list)->firstWhere('id', $id);
        
        if (!$kategori) abort(404); // Jika tidak ketemu, lempar error 404

        $buku_list = $this->buku_list[$id] ?? []; // Ambil buku jika ada, jika tidak kosong array

        return view('kategori.show', compact('kategori', 'buku_list'));
    }

    public function search($keyword)
    {
        // Filter array kategori berdasarkan nama atau deskripsi
        $kategori_list = collect($this->kategori_list)->filter(function ($item) use ($keyword) {
            return stripos($item['nama'], $keyword) !== false || stripos($item['deskripsi'], $keyword) !== false;
        })->all();

        return view('kategori.search', compact('kategori_list', 'keyword'));
    }
}