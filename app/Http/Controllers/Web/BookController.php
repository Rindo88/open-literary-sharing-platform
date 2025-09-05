<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\Rating;
use App\Models\UserBook;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with(['category', 'ratings']);

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Search by title or author
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sort options
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'author':
                $query->orderBy('author', 'asc');
                break;
            case 'rating':
                $query->withAvg('ratings', 'rating')->orderBy('ratings_avg_rating', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $books = $query->paginate(12);
        $categories = Category::all();

        return view('books.index', compact('books', 'categories'));
    }

    public function show($slug)
    {
        $book = Book::where('slug', $slug)
                    ->with(['category', 'ratings.user', 'ratings'])
                    ->firstOrFail();

        // Get user's interaction with this book
        $userBook = null;
        $userRating = null;
        
        if (Auth::check()) {
            $userBook = UserBook::where('user_id', Auth::id())
                               ->where('book_id', $book->id)
                               ->first();
            
            $userRating = Rating::where('user_id', Auth::id())
                               ->where('book_id', $book->id)
                               ->first();
        }

        // Get related books
        $relatedBooks = Book::where('category_id', $book->category_id)
                           ->where('id', '!=', $book->id)
                           ->with(['category', 'ratings'])
                           ->limit(4)
                           ->get();

        return view('books.show', compact('book', 'userBook', 'userRating', 'relatedBooks'));
    }

    public function myBooks()
    {
        $userBooks = UserBook::where('user_id', Auth::id())
                             ->with(['book.category', 'book.ratings'])
                             ->orderBy('updated_at', 'desc')
                             ->get();

        // Group by status
        $readingBooks = $userBooks->where('status', 'reading');
        $finishedBooks = $userBooks->where('status', 'finished');
        $wishlistBooks = $userBooks->where('status', 'wishlist');

        return view('books.my-books', compact('readingBooks', 'finishedBooks', 'wishlistBooks'));
    }

    public function startReading(Request $request, $id)
    {
        try {
            $book = Book::findOrFail($id);
            
            UserBook::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'book_id' => $book->id,
                ],
                [
                    'status' => 'reading',
                    'started_at' => now(),
                ]
            );

            return redirect()->back()->with('success', 'Buku "' . $book->title . '" telah ditambahkan ke daftar baca Anda.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan buku ke daftar baca: ' . $e->getMessage());
        }
    }

    public function finishReading(Request $request, $id)
    {
        try {
            $book = Book::findOrFail($id);
            
            $userBook = UserBook::where('user_id', Auth::id())
                               ->where('book_id', $book->id)
                               ->first();

            if ($userBook) {
                $userBook->update([
                    'status' => 'finished',
                    'finished_at' => now(),
                ]);
            }

            return redirect()->back()->with('success', 'Selamat! Anda telah menyelesaikan membaca "' . $book->title . '".');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyelesaikan buku: ' . $e->getMessage());
        }
    }

    public function addToWishlist(Request $request, $id)
    {
        try {
            $book = Book::findOrFail($id);
            
            UserBook::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'book_id' => $book->id,
                ],
                [
                    'status' => 'wishlist',
                ]
            );

            return redirect()->back()->with('success', 'Buku "' . $book->title . '" telah ditambahkan ke wishlist Anda.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan buku ke wishlist: ' . $e->getMessage());
        }
    }

    public function removeFromWishlist(Request $request, $id)
    {
        try {
            $book = Book::findOrFail($id);
            
            UserBook::where('user_id', Auth::id())
                    ->where('book_id', $book->id)
                    ->delete();

            return redirect()->back()->with('success', 'Buku "' . $book->title . '" telah dihapus dari wishlist Anda.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus buku dari wishlist: ' . $e->getMessage());
        }
    }

    public function rateBook(Request $request, $id)
    {
        try {
            $request->validate([
                'rating' => 'required|integer|min:1|max:5',
                'review' => 'nullable|string|max:1000',
            ]);

            $book = Book::findOrFail($id);
            
            Rating::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'book_id' => $book->id,
                ],
                [
                    'rating' => $request->rating,
                    'review' => $request->review,
                ]
            );

            return redirect()->back()->with('success', 'Rating Anda untuk "' . $book->title . '" telah disimpan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan rating: ' . $e->getMessage());
        }
    }

    public function bookmarkBook(Request $request, $id)
    {
        try {
            $book = Book::findOrFail($id);
            
            $bookmark = Bookmark::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'book_id' => $book->id,
                ],
                [
                    'created_at' => now(),
                ]
            );

            $message = $bookmark->wasRecentlyCreated 
                ? 'Buku "' . $book->title . '" telah ditambahkan ke bookmark.'
                : 'Buku "' . $book->title . '" telah dihapus dari bookmark.';

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengelola bookmark: ' . $e->getMessage());
        }
    }
} 