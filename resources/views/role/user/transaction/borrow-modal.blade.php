<div class="modal fade" id="borrowModal{{ $book->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('user.borrow',$book->id) }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Pinjam Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Judul Buku</label>
                        <input type="text" class="form-control" value="{{ $book->title }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label>Tanggal Pinjam</label>
                        <input type="date" class="form-control" value="{{ date('Y-m-d') }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label>Jumlah Buku Yang Dipinjam</label>
                        <input type="text" class="form-control" value="1 Buku" readonly>
                    </div>

                    <div class="mb-3">
                        <label>Pilih Tanggal Pengembalian Buku</label>
                        <input type="date"
                            name="return_date"
                            class="form-control return-date"
                            data-borrow="{{ date('Y-m-d') }}"
                            min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                            max="{{ date('Y-m-d', strtotime('+7 days')) }}"
                            required>
                        <small class="text-danger">Maksimal peminjaman 7 hari</small>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">
                        Kirim Permintaan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- alert max peminjaman -->
<script>
    document.querySelectorAll('.return-date').forEach(function(input) {

        input.addEventListener('change', function() {

            let borrowDate = new Date(this.dataset.borrow);
            let returnDate = new Date(this.value);

            let diffTime = returnDate - borrowDate;
            let diffDays = diffTime / (1000 * 60 * 60 * 24);

            if (diffDays < 1) {
                alert("Tanggal pengembalian tidak boleh sama dengan tanggal pinjam");
                this.value = "";
            }

            if (diffDays > 7) {
                alert("Maksimal peminjaman hanya 7 hari");
                this.value = "";
            }

        });

    });
</script>