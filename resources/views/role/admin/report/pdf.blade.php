<h2>Laporan Peminjaman</h2>

<table border="1" width="100%" cellpadding="5">
    <thead>
        <tr>
            <th>No</th>
            <th>User</th>
            <th>Book</th>
            <th>Borrow Date</th>
            <th>Return Date</th>
            <th>Status</th>
            <th>Fine</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions as $key => $trx)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $trx->user->name }}</td>
            <td>{{ $trx->book->title }}</td>
            <td>{{ $trx->borrow_date }}</td>
            <td>{{ $trx->return_date }}</td>
            <td>{{ $trx->status }}</td>
            <td>Rp {{ number_format($trx->fine) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>