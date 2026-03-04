<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Book;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function borrow(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id'
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->stock <= 0) {
            return response()->json([
                'message' => 'Stok buku habis'
            ], 400);
        }

        $transaction = Transaction::create([
            'user_id' => $request->user()->id,
            'book_id' => $book->id,
            'borrow_date' => now(),
            'status' => 'borrowed'
        ]);

        $book->decrement('stock');

        return response()->json([
            'message' => 'Buku berhasil dipinjam',
            'data' => $transaction
        ]);
    }

    public function returnBook($id)
    {
        $transaction = Transaction::findOrFail($id);

        $transaction->update([
            'return_date' => now(),
            'status' => 'returned'
        ]);

        $transaction->book->increment('stock');

        return response()->json([
            'message' => 'Buku berhasil dikembalikan'
        ]);
    }

    public function index(Request $request)
    {
        if ($request->user()->role === 'admin') {
            return response()->json(
                Transaction::with('user', 'book')->get()
            );
        }

        return response()->json(
            Transaction::with('book')
                ->where('user_id', $request->user()->id)
                ->get()
        );
    }
}
