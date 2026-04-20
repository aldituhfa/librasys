@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Manage Users</h2>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
        <i class="ti ti-plus me-1"></i> Add User
    </button>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="ti ti-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-body">

        <div class="table-responsive">
            <table id="userTable" class="table table-hover align-middle" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th width="12%">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($users as $key => $user)
                    <tr>
                        <td class="text-center">{{ $key+1 }}</td>
                        <td class="fw-semibold">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="text-center">

                            <button type="button"
                                class="btn btn-sm btn-outline-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editUser{{ $user->id }}">
                                <i class="ti ti-edit"></i>
                            </button>

                            <form action="{{ route('admin.users.destroy',$user->id) }}"
                                method="POST"
                                style="display:inline-block"
                                onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>

                        </td>
                    </tr>

                    {{-- MODAL EDIT --}}
                    <div class="modal fade" id="editUser{{ $user->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('admin.users.update',$user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit User</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Username</label>
                                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label>Email</label>
                                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label>Password (optional)</label>
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Update</button>
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
</div>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="modalTambahUser" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary">Save</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection


@push('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
$(document).ready(function() {
    $('#userTable').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            zeroRecords: "Data tidak ditemukan",
        },
        columnDefs: [
            { className: "text-center", targets: [0,3] },
            { orderable: false, targets: [3] }
        ],
        order: [[0, 'asc']],
        pageLength: 10
    });
});
</script>
@endpush