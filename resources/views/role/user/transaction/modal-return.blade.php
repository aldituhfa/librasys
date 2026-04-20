<div class="modal fade" id="returnModal{{ $trx->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('user.return',$trx->id) }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Pengembalian Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-2">
                        <label>Buku</label>
                        <input type="text" class="form-control" value="{{ $trx->book->title }}" readonly>
                    </div>

                    <div class="mb-2">
                        <label>Kondisi Buku</label>
                        <select name="condition"
                            class="form-control condition-select"
                            data-id="{{ $trx->id }}"
                            required>
                            <option value="">Pilih Kondisi</option>
                            <option value="baik">Baik</option>
                            <option value="rusak">Rusak</option>
                            <option value="hilang">Hilang</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label>Denda</label>
                        <input type="text"
                            class="form-control fine-result"
                            id="fine{{ $trx->id }}"
                            value="Rp 0"
                            readonly>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-warning">
                        Konfirmasi Pengembalian
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
<script>
    document.querySelectorAll('.condition-select').forEach(function(select) {

        select.addEventListener('change', function() {

            let trxId = this.dataset.id;
            let condition = this.value;

            fetch(`/user/calculate-fine/${trxId}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        condition: condition
                    })
                })
                .then(res => res.json())
                .then(data => {
                    document.getElementById('fine' + trxId).value =
                        "Rp " + data.fine.toLocaleString('id-ID');
                });

        });

    });
</script>