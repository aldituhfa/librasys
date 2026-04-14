@extends('layouts.admin')

@section('content')

<h2 class="mb-3">Kelola User</h2>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-body">

        <form action="{{ route('admin.users.store') }}" method="POST" class="mb-4">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="name" class="form-control" placeholder="Nama" required>
                </div>
                <div class="col-md-4">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="col-md-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </form>

        <table id="userTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $key => $user)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <!-- EDIT -->
                        <button class="btn btn-warning btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#editUser{{ $user->id }}">
                            Edit
                        </button>

                        <!-- DELETE -->
                        <form action="{{ route('admin.users.destroy',$user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @include('role.admin.user.edit-modal')
        
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#userTable').DataTable();
    });
</script>

@endsection