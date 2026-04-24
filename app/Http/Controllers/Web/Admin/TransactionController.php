<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Book;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('user', 'book')
            ->whereIn('status', ['pending', 'approved', 'return_pending'])
            ->latest()
            ->get();
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

    public function confirmPayment($id)
    {
        $trx = Transaction::findOrFail($id);

        $trx->update([
            'is_paid' => true,
            'status' => 'done'
        ]);

        return back()->with('success', 'Pembayaran dikonfirmasi & transaksi selesai');
    }

    public function report()
    {
        $transactions = Transaction::with('user', 'book')
            ->whereIn('status', ['returned', 'done', 'rejected'])
            ->latest()
            ->get();

        return view('role.admin.report.index', compact('transactions'));
    }

    public function exportExcel(Request $request)
    {
        $status = $request->status;

        return Excel::download(
            new TransactionExport($status),
            'report_peminjaman.xlsx'
        );
    }

    public function exportPDF(Request $request)
    {
        $query = Transaction::with('user', 'book');

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $transactions = $query->get();

        $pdf = Pdf::loadView('role.admin.report.pdf', compact('transactions'));

        return $pdf->download('report_peminjaman.pdf');
    }
}
