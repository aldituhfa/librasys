<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\Admin\DashboardAdminController;
use App\Http\Controllers\Web\User\DashboardUserController;
use App\Http\Controllers\Web\Admin\CategoryController;
use App\Http\Controllers\Web\Admin\BookController;
use App\Http\Controllers\Web\Admin\UserController;
use App\Http\Controllers\Web\User\BookController as UserBookController;
use App\Http\Controllers\Web\User\TransactionController as UserTransaction;
use App\Http\Controllers\Web\Admin\TransactionController as AdminTransaction;
use App\Http\Controllers\Web\User\FavoriteController;
use App\Http\Controllers\Web\Admin\GenreController;



// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // =====================
    // MIDDLEWARE ADMIN
    // =====================
    Route::middleware('role:admin')->group(function () {

        //dashboard admin
        Route::get('/admin/dashboard', [DashboardAdminController::class, 'index'])
            ->name('admin.DashboardAdmin');

        // crud kategori
        Route::get('/admin/categories', [CategoryController::class, 'index'])
            ->name('admin.categories');
        Route::post('/admin/categories', [CategoryController::class, 'store'])
            ->name('admin.categories.store');
        Route::put('/admin/categories/{id}', [CategoryController::class, 'update'])
            ->name('admin.categories.update');
        Route::delete('/admin/categories/{id}', [CategoryController::class, 'destroy'])
            ->name('admin.categories.destroy');

        // crud genre
        Route::get('/admin/genres', [GenreController::class, 'index'])
            ->name('admin.genres');
        Route::post('/admin/genres', [GenreController::class, 'store'])
            ->name('admin.genres.store');
        Route::put('/admin/genres/{id}', [GenreController::class, 'update'])
            ->name('admin.genres.update');
        Route::delete('/admin/genres/{id}', [GenreController::class, 'destroy'])
            ->name('admin.genres.destroy');

        // crud buku
        Route::get('/admin/books', [BookController::class, 'index'])->name('admin.books');
        Route::post('/admin/books', [BookController::class, 'store'])->name('admin.books.store');
        Route::get('/admin/books/{id}', [BookController::class, 'show'])->name('admin.books.show');
        Route::get('/admin/books/{id}/edit', [BookController::class, 'edit'])->name('admin.books.edit');
        Route::put('/admin/books/{id}', [BookController::class, 'update'])->name('admin.books.update');
        Route::delete('/admin/books/{id}', [BookController::class, 'destroy'])->name('admin.books.destroy');


        // crud user
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
        Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
        Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');


        // approve and reject
        Route::get('/admin/transactions', [AdminTransaction::class, 'index'])
            ->name('admin.transactions');
        Route::post('/admin/transactions/{id}/approve', [AdminTransaction::class, 'approve'])
            ->name('admin.transactions.approve');
        Route::post('/admin/transactions/{id}/reject', [AdminTransaction::class, 'reject'])
            ->name('admin.transactions.reject');
        Route::post('/admin/transactions/{id}/confirm', [AdminTransaction::class, 'confirmPayment'])
            ->name('admin.transactions.confirm');


        // report peminjaman admin
        Route::get('/admin/report', [AdminTransaction::class, 'report'])
            ->name('admin.report');
        Route::get('/admin/report/excel', [AdminTransaction::class, 'exportExcel'])
            ->name('admin.report.excel');
        Route::get('/admin/report/pdf', [AdminTransaction::class, 'exportPDF'])
            ->name('admin.report.pdf');
    });


    // =====================
    // MIDDLEWARE USER
    // =====================
    Route::middleware('role:user')->group(function () {

        // dashboard user
        // Route::get('/user/dashboard', [DashboardUserController::class, 'index'])
        //     ->name('user.DashboardUser');

        // daftar buku 
        Route::get('/user/books', [UserBookController::class, 'index'])
            ->name('user.books');

        // pinjam buku
        Route::get('/user/books/{id}', [UserBookController::class, 'show'])
            ->name('user.books.show');
        Route::post('/user/borrow/{book}', [UserTransaction::class, 'store'])
            ->name('user.borrow');

        // riwayat peminjaman
        Route::get('/user/transactions', [UserTransaction::class, 'history'])
            ->name('user.transactions');

        // return book 
        Route::post('/user/return/{id}', [UserTransaction::class, 'returnBook'])
            ->name('user.return');

        // denda
        Route::post('/user/calculate-fine/{id}', [UserTransaction::class, 'calculateFine'])
            ->name('user.calculate.fine');

        // report peminjaman user
        Route::get('/user/report', [UserTransaction::class, 'report'])
            ->name('user.report');

        // favorite
        Route::get('/user/favorites', [FavoriteController::class, 'index'])
            ->name('user.favorites');
        Route::post('/user/favorite/{book}', [FavoriteController::class, 'toggle'])
            ->name('user.favorite.toggle');
    });
});
