<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function index(Request $request)
    {
        $query = Book::with('category');

        // SEARCH
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // FILTER CATEGORY
        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        // TYPE (TAB)
        if ($request->type == 'available') {
            $query->where('stock', '>', 0);
        }

        $books = $query->latest()->get();
        $categories = Category::all();

        return view('role.user.book.index', compact('books', 'categories'));
    }

    public function show($id)
    {
        $book = Book::with('category')->findOrFail($id);

        return view('role.user.book.show', compact('book'));
    }
}
