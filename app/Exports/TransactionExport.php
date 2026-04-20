<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;

class TransactionExport implements FromCollection
{
    public function collection()
    {
        return Transaction::with('user', 'book')
            ->whereIn('status', ['returned', 'done', 'rejected'])
            ->get()
            ->map(function ($trx) {
                return [
                    'User' => $trx->user->name,
                    'Buku' => $trx->book->title,
                    'Tanggal Pinjam' => $trx->borrow_date,
                    'Tanggal Kembali' => $trx->return_date,
                    'Status' => $trx->status,
                    'Denda' => $trx->fine,
                ];
            });
    }
}
