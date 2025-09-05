<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource; // Buat dengan: php artisan make:resource BookResource

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Book::query()->with('category');

        // Fitur Pencarian berdasarkan judul dan penulis [cite: 12]
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('author', 'like', "%{$searchTerm}%");
            });
        }
        
        // Fitur Filter berdasarkan kategori [cite: 18]
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        // Menampilkan buku populer dan terbaru untuk Beranda [cite: 4]
        if($request->get('popular')) {
            $query->popular();
        } else {
            $query->latest();
        }

        $books = $query->paginate(15)->withQueryString();
        
        return BookResource::collection($books);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        // Menampilkan informasi lengkap buku [cite: 6]
        return new BookResource($book->load('category', 'ratings.user'));
    }
}