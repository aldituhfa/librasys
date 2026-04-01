<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('category')->get();

        return view('role.user.book.index', compact('books'));
    }

    public function show($id)
    {
        $book = Book::with('category')->findOrFail($id);

        return view('role.user.book.show', compact('book'));
    }
}
