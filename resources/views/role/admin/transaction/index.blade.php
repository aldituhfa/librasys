@extends('layouts.admin')

@section('content')

<h2>Data Peminjaman</h2>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<table id="transactionTable" class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>User</th>
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
            <td>{{ $trx->user->name }}</td>
            <td>{{ $trx->book->title }}</td>
            <td>{{ $trx->quantity }}</td>
            <td>{{ $trx->borrow_date }}</td>
            <td>{{ $trx->return_date }}</td>
            <td>

                @if($trx->status == 'pending')
                <span class="badge bg-yellow">Pending</span>

                @elseif($trx->status == 'approved' && now()->gt($trx->return_date))
                <span class="badge bg-red">Terlambat</span>

                @elseif($trx->status == 'approved')
                <span class="badge bg-green">Approved</span>

                @elseif($trx->status == 'late')
                <span class="badge bg-red">Terlambat</span>

                @elseif($trx->status == 'rejected')
                <span class="badge bg-red">Rejected</span>

                @elseif($trx->status == 'returned')
                <span class="badge bg-blue">Returned</span>

                @endif

            </td>
            <td>
                @if($trx->status == 'pending')
                <form action="{{ route('admin.transactions.approve',$trx->id) }}" method="POST" style="display:inline">
                    @csrf
                    <button class="btn btn-success btn-sm">Approve</button>
                </form>

                <form action="{{ route('admin.transactions.reject',$trx->id) }}" method="POST" style="display:inline">
                    @csrf
                    <button class="btn btn-danger btn-sm">Reject</button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#transactionTable').DataTable();
    });
</script>

@endsection