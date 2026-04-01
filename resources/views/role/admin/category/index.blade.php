@extends('layouts.admin')

@section('content')

<h2 class="mb-3">Data Kategori</h2>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-body">

        <form action="{{ route('admin.categories.store') }}" method="POST" class="mb-3">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="name" class="form-control" placeholder="Nama Kategori" required>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </form>

        <table id="categoryTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $key => $category)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $category->name }}</td>
                    <td>

                        <button class="btn btn-warning btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#editCategory{{ $category->id }}">
                            Edit
                        </button>

                        <form action="{{ route('admin.categories.destroy',$category->id) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin hapus kategori?')">
                                Hapus
                            </button>
                        </form>

                    </td>
                </tr>
                @endforeach

                @foreach($categories as $category)

                <div class="modal fade" id="editCategory{{ $category->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <form action="{{ route('admin.categories.update',$category->id) }}" method="POST">

                                @csrf
                                @method('PUT')

                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Kategori</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">

                                    <label>Nama Kategori</label>

                                    <input type="text"
                                        name="name"
                                        class="form-control"
                                        value="{{ $category->name }}"
                                        required>

                                </div>

                                <div class="modal-footer">

                                    <button class="btn btn-primary">
                                        Update
                                    </button>

                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Batal
                                    </button>

                                </div>

                            </form>

                        </div>
                    </div>
                </div>

                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection