<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;

class TransactionExport implements FromCollection
{
    protected $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    public function collection()
    {
        $query = Transaction::with('user', 'book');

        if ($this->status && $this->status !== 'all') {
            $query->where('status', $this->status);
        }

        return $query->get()->map(function ($trx) {
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
