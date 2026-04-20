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
            'return_date' => 'required|date'
        ]);

        $borrowDate = now();
        $returnDate = $request->return_date;

        // =========================
        // FIX HITUNG 7 HARI (AKURAT)
        // =========================
        $borrow = \Carbon\Carbon::parse($borrowDate)->startOfDay();
        $return = \Carbon\Carbon::parse($returnDate)->startOfDay();

        $diffDays = $borrow->diffInDays($return);

        // maksimal 7 hari (hari ke-7 masih boleh)
        if ($diffDays > 7) {
            return redirect()->back()->with('error', 'Maksimal peminjaman 7 hari');
        }

        // =========================
        // CEK PINJAMAN AKTIF
        // =========================
        $activeBorrow = Transaction::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($activeBorrow) {
            return redirect()->back()->with('error', 'Kembalikan buku terlebih dahulu sebelum meminjam lagi');
        }

        // =========================
        // SIMPAN DATA
        // =========================
        Transaction::create([
            'user_id' => auth()->id(),
            'book_id' => $book_id,
            'borrow_date' => $borrow,
            'return_date' => $return,
            'quantity' => 1,
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Permintaan peminjaman dikirim');
    }

    public function history()
    {
        $transactions = Transaction::with('book')
            ->where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'approved', 'return_pending'])
            ->latest()
            ->get();

        return view('role.user.transaction.index', compact('transactions'));
    }

    public function returnBook(Request $request, $id)
    {
        $transaction = \App\Models\Transaction::findOrFail($id);

        if ($transaction->status !== 'approved') {
            return back()->with('error', 'Buku tidak bisa dikembalikan');
        }

        $condition = $request->condition;
        $fine = 0;

        // =========================
        // PRIORITAS HILANG
        // =========================
        if ($condition == 'hilang') {
            $fine = $transaction->book->price;
        }

        // =========================
        // HITUNG TERLAMBAT
        // =========================
        $today = now()->toDateString();
        $returnDate = \Carbon\Carbon::parse($transaction->return_date)->toDateString();

        $lateDays = \Carbon\Carbon::parse($returnDate)->diffInDays($today, false);
        $lateDays = max(0, $lateDays);

        $fine += $lateDays * 1000;

        // =========================
        // DENDA RUSAK
        // =========================
        if ($condition == 'rusak') {
            $fine += 5000;
        }

        // =========================
        // LOGIKA STATUS BARU
        // =========================
        if ($fine > 0) {
            $status = 'return_pending';
        } else {
            $status = 'returned';
        }

        $transaction->update([
            'status' => $status,
            'condition' => $condition,
            'fine' => $fine
        ]);

        // stok tetap balik
        $transaction->book->increment('stock', $transaction->quantity);

        return back()->with(
            'success',
            $fine > 0
                ? 'Pengembalian berhasil. Silakan lakukan pembayaran ke admin.'
                : 'Buku berhasil dikembalikan tanpa denda'
        );
    }

    public function calculateFine(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $condition = $request->condition;
        $fine = 0;

        // =========================
        // PRIORITAS HILANG
        // =========================
        if ($condition == 'hilang') {
            return response()->json([
                'fine' => $transaction->book->price
            ]);
        }

        // =========================
        // HITUNG TERLAMBAT (FIX)
        // =========================
        $today = now()->toDateString();
        $returnDate = \Carbon\Carbon::parse($transaction->return_date)->toDateString();

        $lateDays = \Carbon\Carbon::parse($returnDate)->diffInDays($today, false);
        $lateDays = max(0, $lateDays); // biar ga minus

        $fine += $lateDays * 1000;

        // =========================
        // DENDA RUSAK
        // =========================
        if ($condition == 'rusak') {
            $fine += 5000;
        }

        return response()->json([
            'fine' => $fine
        ]);
    }

    public function report()
    {
        $transactions = Transaction::with('book')
            ->where('user_id', auth()->id())
            ->whereIn('status', ['returned', 'done', 'rejected'])
            ->latest()
            ->get();

        return view('role.user.report.index', compact('transactions'));
    }
}
