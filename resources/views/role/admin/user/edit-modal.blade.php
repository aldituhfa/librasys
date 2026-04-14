@foreach($users as $user)
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
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ $user->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control"
                            value="{{ $user->email }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Password (opsional)</label>
                        <input type="password" name="password" class="form-control">
                        <small class="text-muted">Kosongkan jika tidak diubah</small>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Update</button>
                </div>

            </form>

        </div>
    </div>
</div>
@endforeach