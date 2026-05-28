# Tugas Pertemuan 9 - Pengenalan Framework Laravel MVC

---

**Nama:** Isnaeni Kholifatun  
**NIM:** 60324075  
**Prodi:** Informatika  
**Semester:** 4  
**Mata Kuliah:** Pemrograman Web II  
**Repository:** [https://github.com/isnaenikholifatun/-Tugas-Pertemuan-9-PENGENALAN-FRAMEWORK-LARAVEL-MVC]

---

## Tugas 1 - Routing dan View Anggota

### Route yang dibuat:

| Method | URL | Keterangan |
| :--- | :--- | :--- |
| GET | `/anggota` | Daftar semua anggota |
| GET | `/anggota/{id}` | Detail anggota |

### Screenshot :

#### 1. Tampilan Daftar Anggota Perpustakaan (`/anggota`)
![Screenshot Daftar Anggota](screenshots/tampilan-anggota.png)

#### 2. Tampilan Detail Anggota Perpustakaan (`/anggota/{2}`)
![Screenshot Detail Anggota](screenshots/detail-anggota.png)

## Tugas 2 - Controller Kategori

### Controller: `KategoriController`

* `index()` - Menampilkan daftar kategori
* `show($id)` - Menampilkan detail kategori + daftar buku
* `search($keyword)` - Mencari kategori berdasarkan keyword

### Route yang dibuat:

| Method | URL | Controller | Keterangan |
| :--- | :--- | :--- | :--- |
| GET | `/kategori` | `KategoriController@index` | Daftar kategori |
| GET | `/kategori/{id}` | `KategoriController@show` | Detail kategori |
| GET | `/kategori/search/{keyword}` | `KategoriController@search` | Cari kategori |

### Screenshot :

#### 1. Tampilan Daftar Kategori Perpustakaan (`/kategori`)
![Daftar Kategori](screenshots/tabel-kategori.png)

#### 2. Detail Kategori Perpustakaan (`/kategori/{2}`)
![Detail Kategori](screenshots/detail-kategori.png)

#### 3. Hasil Search Buku (`/kategori/search/programming`)
![Hasil Search Kategori](screenshots/search-kategori.png)