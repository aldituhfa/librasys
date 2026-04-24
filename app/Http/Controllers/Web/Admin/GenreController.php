<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index()
    {
        $genres = \App\Models\Genre::latest()->get();
        return view('role.admin.genre.index', compact('genres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:genres,name'
        ]);

        \App\Models\Genre::create([
            'name' => $request->name
        ]);

        return back()->with('success', 'Genre berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $genre = \App\Models\Genre::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:genres,name,' . $id
        ]);

        $genre->update([
            'name' => $request->name
        ]);

        return back()->with('success', 'Genre berhasil diupdate');
    }

    public function destroy($id)
    {
        \App\Models\Genre::destroy($id);
        return back()->with('success', 'Genre berhasil dihapus');
    }
}
