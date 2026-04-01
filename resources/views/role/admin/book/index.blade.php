@extends('layouts.admin')

@section('content')

<h2 class="mb-3">Data Buku</h2>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-body">

        <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="mb-4">
            @csrf

            <div class="row mb-2">

                <div class="col-md-3">
                    <input type="text" name="title" class="form-control" placeholder="Judul Buku" required>
                </div>

                <div class="col-md-3">
                    <input type="text" name="author" class="form-control" placeholder="Penulis" required>
                </div>

                <div class="col-md-2">
                    <input type="number" name="stock" class="form-control" placeholder="Stok" required>
                </div>

                <div class="col-md-2">
                    <input type="text" name="publisher" class="form-control" placeholder="Penerbit">
                </div>

                <div class="col-md-2">
                    <input type="number" name="year" class="form-control" placeholder="Tahun">
                </div>

            </div>

            <div class="row mb-2">

                <div class="col-md-3">
                    <input type="text" name="isbn" class="form-control" placeholder="ISBN">
                </div>

                <div class="col-md-2">
                    <input type="number" name="pages" class="form-control" placeholder="Halaman">
                </div>

                <div class="col-md-3">
                    <select name="category_id" class="form-control" required>
                        <option value="">Pilih Kategori</option>

                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                        @endforeach

                    </select>
                </div>

                <div class="col-md-4">
                    <input type="file" name="cover" class="form-control">
                </div>

            </div>

            <div class="row mb-2">
                <div class="col-md-12">
                    <textarea name="description" class="form-control" placeholder="Deskripsi / Sinopsis Buku"></textarea>
                </div>
            </div>

            <button class="btn btn-primary">Tambah Buku</button>

        </form>


        <table id="bookTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Cover</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Stok</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @foreach($books as $key => $book)
                <tr>

                    <td>{{ $key+1 }}</td>

                    <td>
                        @if($book->cover)
                        <img src="{{ asset('storage/'.$book->cover) }}" width="60">
                        @else
                        <span class="text-muted">No Image</span>
                        @endif
                    </td>

                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->stock }}</td>
                    <td>{{ $book->category->name ?? '-' }}</td>

                    <td>

                        <a href="{{ route('admin.books.show',$book->id) }}"
                            class="btn btn-info btn-sm">
                            Detail
                        </a>

                        <a href="#"
                            class="btn btn-warning btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#editBook{{ $book->id }}">
                            Edit
                        </a>

                        <form action="{{ route('admin.books.destroy',$book->id) }}"
                            method="POST"
                            style="display:inline-block">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin hapus buku?')">
                                Hapus
                            </button>

                        </form>

                    </td>

                </tr>
                @endforeach

            </tbody>
        </table>

    </div>
</div>

<!-- modal edit -->
@foreach($books as $book)
@include('role.admin.book.edit')
@endforeach

@endsection