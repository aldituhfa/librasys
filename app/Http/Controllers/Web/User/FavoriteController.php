<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Favorite::with('book.category')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $categories = Category::all();

        return view('role.user.favorite.index', compact('favorites', 'categories'));
    }

    public function toggle($bookId)
    {
        $favorite = Favorite::where('user_id', Auth::id())
            ->where('book_id', $bookId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $status = 'removed';
        } else {
            Favorite::create([
                'user_id' => Auth::id(),
                'book_id' => $bookId
            ]);
            $status = 'added';
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true
            ]);
        }

        return back();
    }
}
