@extends('layouts.user')

@section('content')

<h2 class="mb-3">Daftar Buku</h2>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif


<div class="card">
    <div class="card-body">

        <table id="userBookTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Cover</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Kategori</th>
                    <th>Stok</th>
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
                    <td>{{ $book->category->name }}</td>
                    <td>
                        @if($book->stock > 0)
                        <span class="badge bg-green">{{ $book->stock }}</span>
                        @else
                        <span class="badge bg-red">Habis</span>
                        @endif
                    </td>

                    <td>

                        <a href="{{ route('user.books.show', $book->id) }}"
                            class="btn btn-info btn-sm">
                            Detail
                        </a>

                        @if($book->stock > 0)

                        <button class="btn btn-primary btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#borrowModal{{ $book->id }}">
                            Pinjam
                        </button>

                        @else
                        <span class="badge bg-red">Tidak tersedia</span>
                        @endif

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @include('role.user.transaction.borrow-modal')
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#userBookTable').DataTable();
    });
</script>

@endsection