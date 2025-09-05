<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Rating;
use App\Models\UserBook;
use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Get authenticated user's profile.
     */
    public function profile(Request $request)
    {
        // Menampilkan profil pengguna [cite: 26]
        return response()->json($request->user());
    }

    /**
     * Get user's book shelves (reading, finished, wishlist).
     */
    public function myBooks(Request $request)
    {
        $user = $request->user();

        // Mengambil data untuk halaman "Rak Buku Saya" [cite: 15]
        $reading = $user->readingBooks()->get();
        $finished = $user->finishedBooks()->get();
        $wishlist = $user->wishlistBooks()->get();

        return response()->json([
            'sedang_dibaca' => BookResource::collection($reading),
            'telah_dibaca' => BookResource::collection($finished),
            'daftar_keinginan' => BookResource::collection($wishlist),
        ]);
    }
    
    /**
     * Add or remove a book from the user's wishlist.
     */
    public function toggleWishlist(Request $request, Book $book)
    {
        $user = $request->user();
        $wishlistEntry = UserBook::where('user_id', $user->id)
                                 ->where('book_id', $book->id)
                                 ->where('status', 'wishlist')
                                 ->first();

        if ($wishlistEntry) {
            $wishlistEntry->delete();
            return response()->json(['message' => 'Buku dihapus dari daftar keinginan.']);
        } else {
            UserBook::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'status' => 'wishlist',
            ]);
            return response()->json(['message' => 'Buku ditambahkan ke daftar keinginan.']); // [cite: 23]
        }
    }

    /**
     * Start reading a book.
     */
    public function startReading(Request $request, Book $book)
    {
        // Logika saat tombol "baca" ditekan [cite: 11, 13]
        $userBook = UserBook::updateOrCreate(
            ['user_id' => $request->user()->id, 'book_id' => $book->id],
            ['status' => 'reading', 'started_at' => now()]
        );
        
        return response()->json(['message' => 'Anda mulai membaca buku ini.', 'data' => $userBook]);
    }

    /**
     * Rate and review a book.
     */
    public function rateBook(Request $request, Book $book)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ]);
        
        // Fitur untuk memberikan ulasan dan rating [cite: 20]
        $rating = Rating::updateOrCreate(
            ['user_id' => Auth::id(), 'book_id' => $book->id],
            ['rating' => $request->rating, 'review' => $request->review]
        );

        return response()->json(['message' => 'Ulasan berhasil disimpan.', 'data' => $rating]);
    }
}