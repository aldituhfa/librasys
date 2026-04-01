<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Book;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('user', 'book')->get();
        return view('role.admin.transaction.index', compact('transactions'));
    }

    public function approve($id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->book->stock < $transaction->quantity) {
            return redirect()->back()->with('error', 'Stok tidak cukup');
        }

        $transaction->update(['status' => 'approved']);

        $transaction->book->decrement('stock', $transaction->quantity);

        return redirect()->back()->with('success', 'Peminjaman disetujui');
    }

    public function reject($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Peminjaman ditolak');
    }
}
