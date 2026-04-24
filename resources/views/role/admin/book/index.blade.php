@extends('layouts.admin')

@section('content')
<div x-data="{ 
    successVisible: {{ session('success') ? 'true' : 'false' }},
    coverPreview: null
}">

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-semibold mb-0" style="color: #1e293b;">Book Data</h2>
            <p class="text-muted mb-0 small mt-1">Manage your library's book collection</p>
        </div>
        <button class="btn btn-primary rounded-2 px-4 py-2 d-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahBuku">
            <i class="ti ti-plus"></i>
            <span> Add Book</span>
        </button>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
    <div x-show="successVisible" x-transition.duration.300ms class="alert alert-success alert-dismissible d-flex align-items-center gap-2 border-0 shadow-sm rounded-3 mb-4" role="alert">
        <i class="ti ti-check-circle fs-5"></i>
        <span>{{ session('success') }}</span>
        <button type="button" class="btn-close ms-auto" @click="successVisible = false"></button>
    </div>
    @endif

    {{-- Card Tabel --}}
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-header bg-transparent border-0 px-4 pt-4 pb-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <i class="ti ti-books text-primary fs-5"></i>
                <span class="fw-semibold text-secondary">Book List</span>
            </div>
            <div class="d-flex gap-2">
                <span class="badge bg-light text-secondary rounded-pill px-3 py-2">
                    <i class="ti ti-database me-1"></i> Total: {{ $books->count() }} Books
                </span>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive px-0">
                <table class="table table-hover align-middle mb-0" id="bookTable" style="width:100%">
                    <thead style="background-color: #f8fafc;">
                        <tr>
                            <th class="px-4 py-3 text-secondary fw-semibold small" style="width:45px">No</th>
                            <th class="py-3 text-secondary fw-semibold small" style="width:70px">Cover</th>
                            <th class="py-3 text-secondary fw-semibold small">Book Title</th>
                            <th class="py-3 text-secondary fw-semibold small">Author</th>
                            <th class="py-3 text-secondary fw-semibold small text-center" style="width:80px">Stock</th>
                            <th class="py-3 text-secondary fw-semibold small">Category</th>
                            <th class="py-3 text-secondary fw-semibold small text-center" style="width:120px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($books as $key => $book)
                        <tr>
                            <td class="px-4 text-muted small">{{ $key + 1 }}</td>
                            <td>
                                @if($book->cover)
                                <img src="{{ asset('storage/'.$book->cover) }}" width="42" height="56" class="rounded-1 shadow-sm" style="object-fit: cover;" alt="Cover">
                                @else
                                <div class="bg-light rounded-1 d-flex align-items-center justify-content-center" style="width:42px;height:56px;">
                                    <i class="ti ti-book text-muted opacity-50"></i>
                                </div>
                                @endif
                            </td>
                            <td>
                                <span class="fw-medium" style="color: #1e293b;">{{ $book->title }}</span>
                                @if($book->isbn)
                                <div class="text-muted small mt-1">
                                    <i class="ti ti-barcode" style="font-size: 11px;"></i> {{ $book->isbn }}
                                </div>
                                @endif
                            </td>
                            <td class="text-secondary small">{{ $book->author }}</td>
                            <td class="text-center">
                                <span class="fw-medium text-secondary">{{ $book->stock }}</span>
                            </td>
                            <td>
                                <span class="small text-secondary">
                                    <i class="ti ti-tag me-1" style="font-size: 12px;"></i>
                                    {{ $book->category->name ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center gap-1">
                                    <a href="{{ route('admin.books.show', $book->id) }}" class="btn btn-sm btn-outline-secondary rounded-2" title="Detail">
                                        <i class="ti ti-eye" style="font-size: 16px;"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-2" data-bs-toggle="modal" data-bs-target="#editBook{{ $book->id }}" title="Edit">
                                        <i class="ti ti-edit" style="font-size: 16px;"></i>
                                    </button>
                                    <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus buku ini?')" style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-secondary rounded-2" title="Hapus">
                                            <i class="ti ti-trash" style="font-size: 16px;"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="ti ti-book-off fs-1 text-muted mb-3 d-block opacity-50"></i>
                                <p class="text-muted mb-2">There is no book data yet</p>
                                <button class="btn btn-sm btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#modalTambahBuku">
                                    <i class="ti ti-plus me-1"></i> Add Book Now
                                </button>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ============================================ --}}
{{-- MODAL TAMBAH BUKU (SLATE/ABU-ABU seperti modal edit) --}}
{{-- ============================================ --}}
<div class="modal fade" id="modalTambahBuku" tabindex="-1" x-data="{ coverPreview: null }" @hidden.bs.modal="coverPreview = null">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header" style="background: linear-gradient(135deg, #475569 0%, #334155 100%); color: white; border-radius: 20px 20px 0 0;">
                <div class="d-flex align-items-center gap-2">
                    <i class="ti ti-plus-circle fs-4"></i>
                    <h5 class="modal-title fw-semibold mb-0">Add New Book</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <i class="ti ti-alert-circle me-2"></i>
                        <strong>An error occurred!</strong> Please check the data you entered.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Book Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="Enter book title" value="{{ old('title') }}" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Author <span class="text-danger">*</span></label>
                            <input type="text" name="author" class="form-control @error('author') is-invalid @enderror" placeholder="Enter author name" value="{{ old('author') }}" required>
                            @error('author')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Publisher</label>
                            <input type="text" name="publisher" class="form-control" placeholder="Publisher name" value="{{ old('publisher') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Tahun Terbit</label>
                            <input type="number" name="year" class="form-control" placeholder="Example: 2024" value="{{ old('year') }}" min="1900" max="{{ date('Y') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">ISBN</label>
                            <input type="text" name="isbn" class="form-control @error('isbn') is-invalid @enderror" placeholder="978-xxx-xxx" value="{{ old('isbn') }}">
                            @error('isbn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Genre <span class="text-danger">*</span></label>
                            <select name="genres[]" class="form-select" multiple required>
                                @foreach($genres as $genre)
                                <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Bisa pilih lebih dari 1 (Ctrl + Click)</small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Stock <span class="text-danger">*</span></label>
                            <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" placeholder="Jumlah stok" value="{{ old('stock') }}" min="0" required>
                            @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Price <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" placeholder="0" value="{{ old('price') }}" min="0" required>
                            </div>
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Number Of Pages</label>
                            <input type="number" name="pages" class="form-control" placeholder="Jumlah halaman" value="{{ old('pages') }}" min="1">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Book Cover</label>
                            <input type="file" name="cover" class="form-control" accept="image/*" @change="
                                const file = $event.target.files[0];
                                if(file) {
                                    const reader = new FileReader();
                                    reader.onload = e => coverPreview = e.target.result;
                                    reader.readAsDataURL(file);
                                } else {
                                    coverPreview = null;
                                }
                            ">
                        </div>
                    </div>

                    <div x-show="coverPreview" class="mb-3" x-transition>
                        <div class="bg-light rounded-3 p-3">
                            <label class="form-label fw-semibold small mb-2">Cover Preview</label>
                            <div>
                                <img :src="coverPreview" class="rounded-2 border shadow-sm" style="max-height: 120px;" alt="Preview">
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-semibold">Description / Synopsis</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Tulis sinopsis atau deskripsi singkat buku...">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="modal-footer border-0 px-4 pb-4 pt-2">
                    <button type="button" class="btn btn-outline-secondary rounded-2 px-4" data-bs-dismiss="modal">
                        <i class="ti ti-x me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn rounded-2 px-4" style="background: #475569; color: white; border: none;">
                        <i class="ti ti-device-floppy me-1"></i> Save Book
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ============================================ --}}
{{-- MODAL EDIT BUKU (SLATE/ABU-ABU KEBIRUAN) --}}
{{-- ============================================ --}}
@foreach($books as $book)
<div class="modal fade" id="editBook{{ $book->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header" style="background: linear-gradient(135deg, #475569 0%, #334155 100%); color: white; border-radius: 20px 20px 0 0;">
                <div class="d-flex align-items-center gap-2">
                    <i class="ti ti-edit-circle fs-4"></i>
                    <h5 class="modal-title fw-semibold mb-0">Edit Book</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" value="{{ $book->title }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Author <span class="text-danger">*</span></label>
                            <input type="text" name="author" class="form-control" value="{{ $book->author }}" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Publisher</label>
                            <input type="text" name="publisher" class="form-control" value="{{ $book->publisher }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Year Published</label>
                            <input type="number" name="year" class="form-control" value="{{ $book->year }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">ISBN</label>
                            <input type="text" name="isbn" class="form-control" value="{{ $book->isbn }}">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select" required>
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $book->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Genre</label>
                            <select name="genres[]" class="form-select" multiple>
                                @foreach($genres as $genre)
                                <option value="{{ $genre->id }}"
                                    {{ $book->genres->contains($genre->id) ? 'selected' : '' }}>
                                    {{ $genre->name }}
                                </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Bisa pilih lebih dari 1 (Ctrl + Click)</small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Stock <span class="text-danger">*</span></label>
                            <input type="number" name="stock" class="form-control" value="{{ $book->stock }}" min="0" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Price <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="price" class="form-control" value="{{ $book->price }}" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Number of Pages</label>
                            <input type="number" name="pages" class="form-control" value="{{ $book->pages }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Book Cover</label>
                            <input type="file" name="cover" class="form-control" accept="image/*">
                        </div>
                    </div>

                    @if($book->cover)
                    <div class="mb-3">
                        <div class="bg-light rounded-3 p-3">
                            <label class="form-label fw-semibold small mb-2">Current Cover</label>
                            <div>
                                <img src="{{ asset('storage/'.$book->cover) }}" class="rounded-2 border shadow-sm" style="max-height: 100px;" alt="Current Cover">
                                <p class="text-muted small mt-2 mb-0">Leave empty if you don't want to change the cover</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="mb-2">
                        <label class="form-label fw-semibold">Description / Synopsis</label>
                        <textarea name="description" class="form-control" rows="4">{{ $book->description }}</textarea>
                    </div>
                </div>

                <div class="modal-footer border-0 px-4 pb-4 pt-2">
                    <button type="button" class="btn btn-outline-secondary rounded-2 px-4" data-bs-dismiss="modal">
                        <i class="ti ti-x me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn rounded-2 px-4" style="background: #475569; color: white; border: none;">
                        <i class="ti ti-device-floppy me-1"></i> Update Book
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

{{-- Custom CSS --}}
<style>
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        padding: 0.75rem 1.25rem;
    }

    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 6px 12px;
        margin-left: 8px;
        outline: none;
        transition: all 0.2s;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.1);
    }

    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 4px 8px;
        margin: 0 4px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 8px !important;
        padding: 6px 12px !important;
        margin: 0 2px !important;
        border: 1px solid #e2e8f0 !important;
        background: white !important;
        color: #475569 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #0d6efd !important;
        border-color: #0d6efd !important;
        color: white !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #f1f5f9 !important;
        border-color: #cbd5e1 !important;
        color: #1e293b !important;
    }

    .dataTables_wrapper .dataTables_info {
        color: #64748b;
        font-size: 13px;
    }

    .table-hover tbody tr:hover {
        background-color: #f8fafc;
    }

    .rounded-4 {
        border-radius: 20px !important;
    }

    /* Modal styling yang lebih rapi */
    .modal-header {
        padding: 1rem 1.5rem;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        padding: 1rem 1.5rem;
    }

    .form-control,
    .form-select {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #475569;
        box-shadow: 0 0 0 2px rgba(71, 85, 105, 0.1);
    }

    .btn-outline-secondary:hover {
        background-color: #f1f5f9;
        border-color: #cbd5e1;
    }
</style>

@push('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
    $(document).ready(function() {
        $('#bookTable').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                zeroRecords: "Data tidak ditemukan",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "→",
                    previous: "←"
                }
            },
            columnDefs: [{
                    className: "text-center",
                    targets: [0, 4, 6]
                },
                {
                    orderable: false,
                    targets: [1, 6]
                }
            ],
            order: [
                [0, 'asc']
            ],
            pageLength: 10,
            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "Semua"]
            ]
        });
    });
</script>
@endpush

@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = new bootstrap.Modal(document.getElementById('modalTambahBuku'));
        modal.show();
    });
</script>
@endif
@endsection