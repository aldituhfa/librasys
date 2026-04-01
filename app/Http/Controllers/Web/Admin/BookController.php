<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function index()
    {
        $books = Book::with('category')->latest()->get();
        $categories = Category::all();

        return view('role.admin.book.index', compact('books', 'categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required',
            'cover' => 'image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('cover')) {
            $cover = $request->file('cover')->store('books', 'public');
            $data['cover'] = $cover;
        }

        Book::create($data);

        return redirect()->back()->with('success', 'Buku berhasil ditambahkan');
    }


    public function show($id)
    {
        $book = Book::with('category')->findOrFail($id);

        return view('role.admin.book.show', compact('book'));
    }


    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $categories = Category::all();

        return view('role.admin.book.edit', compact('book', 'categories'));
    }


    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $data = $request->all();

        if ($request->hasFile('cover')) {
            $cover = $request->file('cover')->store('books', 'public');
            $data['cover'] = $cover;
        }

        $book->update($data);

        return redirect()->route('admin.books')->with('success', 'Buku berhasil diupdate');
    }


    public function destroy($id)
    {
        Book::destroy($id);

        return redirect()->back()->with('success', 'Buku berhasil dihapus');
    }
}
