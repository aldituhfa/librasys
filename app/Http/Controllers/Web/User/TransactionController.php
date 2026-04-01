<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function store(Request $request, $book_id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:3',
            'return_date' => 'required|date'
        ]);

        $borrowDate = now();
        $returnDate = $request->return_date;

        if (\Carbon\Carbon::parse($returnDate)->diffInDays($borrowDate) > 7) {
            return redirect()->back()->with('error', 'Maksimal peminjaman 7 hari');
        }

        $activeBorrow = Transaction::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'approved'])
            ->sum('quantity');

        if ($activeBorrow + $request->quantity > 3) {
            return redirect()->back()->with('error', 'Total peminjaman maksimal 3 buku, anda harus mengembalikan buku terlebih dahulu');
        }

        Transaction::create([
            'user_id' => auth()->id(),
            'book_id' => $book_id,
            'borrow_date' => $borrowDate,
            'return_date' => $returnDate,
            'quantity' => $request->quantity,
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Permintaan peminjaman dikirim');
    }

    public function history()
    {
        $transactions = \App\Models\Transaction::with('book')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('role.user.transaction.index', compact('transactions'));
    }

    public function returnBook($id)
    {
        $transaction = \App\Models\Transaction::findOrFail($id);

        if ($transaction->status !== 'approved') {
            return redirect()->back()->with('error', 'Buku tidak bisa dikembalikan');
        }

        // cek apakah terlambat
        if (now()->gt($transaction->return_date)) {
            $status = 'late';
        } else {
            $status = 'returned';
        }

        $transaction->update([
            'status' => $status
        ]);

        $transaction->book->increment('stock', $transaction->quantity);

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan');
    }
}
