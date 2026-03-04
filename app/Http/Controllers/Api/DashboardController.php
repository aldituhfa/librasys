<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function admin()
    {
        return response()->json([
            'total_books' => Book::count(),
            'total_users' => User::where('role', 'user')->count(),
            'books_borrowed' => Transaction::where('status', 'borrowed')->count(),
            'books_available' => Book::sum('stock')
        ]);
    }
}
