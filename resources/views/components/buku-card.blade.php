<div class="card mb-3 shadow-sm">

    <div class="card-body">

        <div class="row align-items-center">

            {{-- Icon --}}
            <div class="col-md-2 text-center">

                <i class="bi bi-book text-primary"
                   style="font-size: 4rem;"></i>

                <div class="mt-2">

                    <span class="badge
                        @if($buku->kategori == 'Programming') bg-primary
                        @elseif($buku->kategori == 'Database') bg-success
                        @elseif($buku->kategori == 'Web Design') bg-info
                        @elseif($buku->kategori == 'Networking') bg-warning
                        @else bg-danger
                        @endif">

                        {{ $buku->kategori }}

                    </span>

                </div>

            </div>

            {{-- Informasi Buku --}}
            <div class="col-md-7">

                <h5 class="fw-bold text-primary">
                    {{ $buku->judul }}
                </h5>

                <p class="text-muted mb-1">

                    <i class="bi bi-person"></i>
                    {{ $buku->pengarang }}

                    |

                    <i class="bi bi-building"></i>
                    {{ $buku->penerbit }}

                    |

                    <i class="bi bi-calendar"></i>
                    {{ $buku->tahun_terbit }}

                </p>

                <p class="small text-muted mb-2">

                    <i class="bi bi-upc"></i>
                    ISBN: {{ $buku->isbn }}

                </p>

                <p class="mb-0">
                    {{ Str::limit($buku->deskripsi, 100) }}
                </p>

            </div>

            {{-- Harga & Tombol --}}
            <div class="col-md-3 text-end">

                <h4 class="text-primary fw-bold">
                    {{ $buku->harga_format }}
                </h4>

                @if($buku->stok > 0)

                    <span class="badge bg-success">
                        <i class="bi bi-check-circle"></i>
                        Tersedia
                    </span>

                    <div class="small text-muted mt-1">
                        Stok: {{ $buku->stok }} buku
                    </div>

                @else

                    <span class="badge bg-danger">
                        <i class="bi bi-x-circle"></i>
                        Habis
                    </span>

                @endif

                @if($showActions)

                    <div class="d-grid gap-2 mt-3">

                        <a href="{{ route('buku.show', $buku->id) }}"
                           class="btn btn-sm btn-info text-white">
                            <i class="bi bi-eye"></i>
                            Detail
                        </a>

                        <a href="{{ route('buku.edit', $buku->id) }}"
                           class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                            Edit
                        </a>

                        {{-- Delete Button --}}
                        <form action="{{ route('buku.destroy', $buku->id) }}"
                              method="POST"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku {{ $buku->judul }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger w-100">
                                <i class="bi bi-trash"></i>
                                Hapus
                            </button>
                        </form>

                    </div>

                @endif

            </div>

        </div>

    </div>

</div>