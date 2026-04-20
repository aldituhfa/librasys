<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Book;
use App\Models\Category;
use App\Models\Transaction;

class DashboardAdminController extends Controller
{

    public function index()
    {
        // CARD DATA
        $totalUsers = User::where('role', 'user')->count();
        $totalBooks = Book::count();
        $totalCategories = Category::count();

        $activeTransactions = Transaction::whereIn('status', ['pending', 'approved', 'return_pending'])->count();
        $finishedTransactions = Transaction::whereIn('status', ['returned', 'done'])->count();

        $totalFine = Transaction::sum('fine');

        // CHART (7 hari terakhir)
        // CHART 7 HARI FULL (ANTI KOSONG)
        $days = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');

            $count = Transaction::whereDate('created_at', $date)->count();

            $days->push([
                'date' => \Carbon\Carbon::parse($date)->format('d M'),
                'total' => $count
            ]);
        }

        $chart = $days;

        // DATA TERBARU
        $latestTransactions = Transaction::with('user', 'book')
            ->latest()
            ->take(5)
            ->get();

        return view('role.admin.DashboardAdmin', compact(
            'totalUsers',
            'totalBooks',
            'totalCategories',
            'activeTransactions',
            'finishedTransactions',
            'totalFine',
            'chart',
            'latestTransactions'
        ));
    }
}
