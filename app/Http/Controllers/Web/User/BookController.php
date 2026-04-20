<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Favorite;

use Illuminate\Http\Request;

class BookController extends Controller
{

    public function index(Request $request)
    {
        $query = Book::with('category');

        // SEARCH
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('author', 'like', '%' . $searchTerm . '%')
                    ->orWhere('publisher', 'like', '%' . $searchTerm . '%');
            });
        }

        // FILTER CATEGORY
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // TYPE (TAB) - Tersedia atau Terbaru
        if ($request->type == 'available') {
            $query->where('stock', '>', 0);
        }

        // Untuk tab "Terbaru" - urutkan dari yang terbaru
        if ($request->type == 'latest') {
            $query->latest();
        } else {
            $query->latest();
        }

        // AMBIL DATA SETELAH FILTER
        $books = $query->get();

        // CEK AJAX
        if ($request->ajax() || $request->has('ajax')) {
            return response()->json([
                'success' => true,
                'books' => $books->map(function ($book) {
                    return [
                        'id' => $book->id,
                        'title' => $book->title,
                        'cover' => $book->cover,
                        'author' => $book->author,
                        'publisher' => $book->publisher,
                        'category_name' => $book->category ? $book->category->name : 'Umum',
                        'is_favorite' => auth()->check() ?
                            Favorite::where('user_id', auth()->id())
                            ->where('book_id', $book->id)->exists() : false
                    ];
                })
            ]);
        }

        $categories = Category::all();

        return view('role.user.book.index', compact('books', 'categories'));
    }

    public function show($id)
    {
        $book = Book::with('category')->findOrFail($id);

        return view('role.user.book.show', compact('book'));
    }
}
