<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit (karena Laravel defaultnya mencari 'kategoris')
    protected $table = 'kategori';

    // Kolom yang diizinkan untuk mass assignment
    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'icon',
        'warna'
    ];
}