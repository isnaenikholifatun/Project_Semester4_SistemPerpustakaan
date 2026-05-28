<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = [
            [
                'nama_kategori' => 'Programming',
                'deskripsi' => 'Kategori buku seputar pemrograman dan rekayasa perangkat lunak.',
                'icon' => 'code-slash',
                'warna' => 'primary',
            ],
            [
                'nama_kategori' => 'Database',
                'deskripsi' => 'Kategori buku seputar basis data dan manajemen data.',
                'icon' => 'database',
                'warna' => 'success',
            ],
            [
                'nama_kategori' => 'Web Design',
                'deskripsi' => 'Kategori buku seputar desain antarmuka dan pengalaman pengguna web.',
                'icon' => 'palette',
                'warna' => 'info',
            ],
            [
                'nama_kategori' => 'Networking',
                'deskripsi' => 'Kategori buku seputar jaringan komputer dan infrastruktur.',
                'icon' => 'wifi',
                'warna' => 'warning',
            ],
            [
                'nama_kategori' => 'Data Science',
                'deskripsi' => 'Kategori buku seputar analisis data, machine learning, dan AI.',
                'icon' => 'graph-up',
                'warna' => 'danger',
            ],
        ];

        foreach ($kategori as $data) {
            Kategori::create($data);
        }
    }
}