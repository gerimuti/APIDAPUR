<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    // Menambahkan favorit
    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
        ]);

        $favorite = Favorite::create([
            'user_id' => Auth::id(),
            'item_id' => $request->item_id,
        ]);

        return response()->json([
            'message' => 'Item added to favorites',
            'data' => $favorite,
        ], 201);
    }

    // Menampilkan daftar favorit pengguna
    public function index()
    {
        $favorites = Favorite::with('item')
            ->where('user_id', Auth::id())
            ->get();

        return response()->json([
            'data' => $favorites,
        ]);
    }

    // Menghapus favorit
    public function destroy($id)
    {
        $favorite = Favorite::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if (!$favorite) {
            return response()->json(['message' => 'Favorite not found'], 404);
        }

        $favorite->delete();

        return response()->json(['message' => 'Favorite removed']);
    }
}
