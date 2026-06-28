<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Perpustakaan</h1>

                {{-- STATISTIK BUKU --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded shadow-sm">
                        <h5 class="text-sm font-medium text-blue-600 uppercase tracking-wider">Total Buku</h5>
                        <h2 class="text-3xl font-bold text-blue-900 mt-1">{{ $totalBuku }}</h2>
                    </div>

                    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-sm">
                        <h5 class="text-sm font-medium text-green-600 uppercase tracking-wider">Buku Tersedia</h5>
                        <h2 class="text-3xl font-bold text-green-900 mt-1">{{ $bukuTersedia }}</h2>
                    </div>

                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded shadow-sm">
                        <h5 class="text-sm font-medium text-red-600 uppercase tracking-wider">Buku Habis</h5>
                        <h2 class="text-3xl font-bold text-red-900 mt-1">{{ $bukuHabis }}</h2>
                    </div>
                </div>

                {{-- STATISTIK ANGGOTA --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <div class="bg-cyan-50 border-l-4 border-cyan-500 p-4 rounded shadow-sm">
                        <h5 class="text-sm font-medium text-cyan-600 uppercase tracking-wider">Total Anggota</h5>
                        <h2 class="text-3xl font-bold text-cyan-900 mt-1">{{ $totalAnggota }}</h2>
                    </div>

                    <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded shadow-sm">
                        <h5 class="text-sm font-medium text-emerald-600 uppercase tracking-wider">Anggota Actif</h5>
                        <h2 class="text-3xl font-bold text-emerald-900 mt-1">{{ $anggotaAktif }}</h2>
                    </div>

                    <div class="bg-gray-100 border-l-4 border-gray-500 p-4 rounded shadow-sm">
                        <h5 class="text-sm font-medium text-gray-600 uppercase tracking-wider">Anggota Nonaktif</h5>
                        <h2 class="text-3xl font-bold text-gray-800 mt-1">{{ $anggotaNonaktif }}</h2>
                    </div>
                </div>

                {{-- DATA TERBARU (BUKU & ANGGOTA) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- 5 Buku Terbaru --}}
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 rounded-t-lg font-semibold text-gray-700">
                            5 Buku Terbaru
                        </div>
                        <div class="p-4 divide-y divide-gray-100">
                            @forelse($bukuTerbaru as $buku)
                                <div class="py-2 first:pt-0 last:pb-0">
                                    <strong class="text-gray-900 text-sm block">{{ $buku->judul }}</strong>
                                    <span class="text-xs text-gray-500">{{ $buku->pengarang }}</span>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 py-2">Tidak ada data buku</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- 5 Anggota Terbaru --}}
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 rounded-t-lg font-semibold text-gray-700">
                            5 Anggota Terbaru
                        </div>
                        <div class="p-4 divide-y divide-gray-100">
                            @forelse($anggotaTerbaru as $anggota)
                                <div class="py-2 first:pt-0 last:pb-0">
                                    <strong class="text-gray-900 text-sm block">{{ $anggota->nama }}</strong>
                                    <span class="text-xs text-gray-500">{{ $anggota->email }}</span>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 py-2">Tidak ada data anggota</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- TOMBOL NAVIGASI / AKSI --}}
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('buku.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 transition duration-150">
                        Kelola Buku
                    </a>
                    <a href="{{ route('anggota.index') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 transition duration-150">
                        Kelola Anggota
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>