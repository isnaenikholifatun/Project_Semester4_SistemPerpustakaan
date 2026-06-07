<div class="card mb-3 shadow-sm">

    <div class="card-body">

    <div class="form-check mb-2">
        <input type="checkbox"
           name="selected_books[]"
           value="{{ $buku->id }}"
           class="form-check-input book-checkbox">
        <label class="form-check-label">
            Pilih
        </label>
    </div>

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

                        {{-- Delete Button dengan SweetAlert --}}
                        <form action="{{ route('buku.destroy', $buku->id) }}" 
                            method="POST" 
                            class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger w-100 btn-delete" 
                                    data-judul="{{ $buku->judul }}">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                        
                        @push('scripts')
                        <script>
                            // SweetAlert confirmation untuk delete
                            document.querySelectorAll('.btn-delete').forEach(button => {
                                button.addEventListener('click', function(e) {
                                    e.preventDefault();
                                    const form = this.closest('form');
                                    const judul = this.getAttribute('data-judul');
                                    
                                    Swal.fire({
                                        title: 'Konfirmasi Hapus',
                                        text: `Apakah Anda yakin ingin menghapus buku "${judul}"?`,
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#d33',
                                        cancelButtonColor: '#3085d6',
                                        confirmButtonText: 'Ya, Hapus!',
                                        cancelButtonText: 'Batal'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            form.submit();
                                        }
                                    });
                                });
                            });
                        </script>
                        @endpush

                    @push('scripts')
                    <script>
                        // Loading state saat submit form
                        document.querySelectorAll('form').forEach(form => {
                            form.addEventListener('submit', function() {
                                const submitBtn = this.querySelector('button[type="submit"]');
                                if (submitBtn && !this.classList.contains('delete-form')) {
                                    submitBtn.disabled = true;
                                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
                                }
                            });
                        });
                    </script>
                    @endpush

                    </div>

                @endif

            </div>

        </div>

    </div>

</div>