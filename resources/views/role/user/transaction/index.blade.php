@extends('layouts.user')

@section('content')

<h2 class="mb-3">Riwayat Peminjaman</h2>

<table id="historyTable" class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Buku</th>
            <th>Jumlah</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Pengembalian</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach($transactions as $key => $trx)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $trx->book->title }}</td>
            <td>{{ $trx->quantity }}</td>
            <td>{{ $trx->borrow_date }}</td>
            <td>{{ $trx->return_date }}</td>

            <td>

                @if($trx->status == 'late')
                <span class="badge bg-red">Terlambat</span>

                @elseif($trx->status == 'pending')
                <span class="badge bg-yellow">Pending</span>

                @elseif($trx->status == 'approved' && now()->gt($trx->return_date))
                <span class="badge bg-red">Terlambat</span>

                @elseif($trx->status == 'approved')
                <span class="badge bg-green">Approved</span>

                @elseif($trx->status == 'rejected')
                <span class="badge bg-red">Rejected</span>

                @elseif($trx->status == 'returned')
                <span class="badge bg-blue">Returned</span>

                @endif

            </td>
            <td>
                @if($trx->status == 'approved')
                <form action="{{ route('user.return',$trx->id) }}" method="POST">

                    @csrf
                    <button class="btn btn-warning btn-sm">
                        Kembalikan
                    </button>
                </form>
                
                @elseif($trx->status == 'returned' || $trx->status == 'late')
                <span class="badge bg-blue">Returned</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#historyTable').DataTable();
    });
</script>

@endsection