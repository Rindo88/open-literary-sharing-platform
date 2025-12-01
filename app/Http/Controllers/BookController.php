<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\Rating;
use App\Models\UserBook;
use App\Models\AuthorProfile;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::published()->with(['author.user', 'ratings']);

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('author', function ($q2) use ($search) {
                        $q2->where('pen_name', 'like', "%{$search}%")
                            ->orWhereHas('user', function ($q3) use ($search) {
                                $q3->where('name', 'like', "%{$search}%");
                            });
                    });
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->whereJsonContains('categories', (int)$request->category);
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'popular':
                $query->withCount('discussions')->orderBy('discussions_count', 'desc');
                break;
            case 'rating':
                $query->withAvg('ratings', 'rating')->orderBy('ratings_avg_rating', 'desc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        // View type
        $view = $request->get('view', 'grid');

        $books = $query->paginate(12);

        // Get categories dengan manual count
        $categories = Category::all()->map(function ($category) {
            $category->books_count = Book::published()->whereJsonContains('categories', $category->id)->count();
            return $category;
        });

        $totalBooks = Book::published()->count();

        return view('books.index', compact('books', 'categories', 'totalBooks', 'view'));
    }

    public function home()
    {
        // Get categories dengan manual count
        $categories = Category::all()->map(function ($category) {
            $category->books_count = Book::published()->whereJsonContains('categories', $category->id)->count();
            return $category;
        });

        $popularBooks = Book::published()
            ->with(['author.user', 'ratings'])
            ->withCount('discussions')
            ->orderBy('discussions_count', 'desc')
            ->limit(8)
            ->get();

        $latestBooks = Book::published()
            ->with(['author.user', 'ratings'])
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        return view('home.index', compact('categories', 'popularBooks', 'latestBooks'));
    }

    public function booksByType($type)
    {
        // For now, redirect to books index with category filter
        return redirect()->route('books.index', ['category' => $type]);
    }

    public function show($type, $id)
    {
        $book = Book::published()
            ->with(['author.user', 'ratings.user', 'discussions'])
            ->findOrFail($id);

        $relatedBooks = Book::published()
            ->where('id', '!=', $book->id)
            ->where(function ($q) use ($book) {
                if ($book->categories) {
                    foreach ($book->categories as $categoryId) {
                        $q->orWhereJsonContains('categories', $categoryId);
                    }
                }
            })
            ->limit(4)
            ->get();

        // Get user book status jika user login
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

        // Get category objects untuk book
        $categoryList = $book->categoryObjects;

        return view('books.show', compact('book', 'relatedBooks', 'userBook', 'userRating', 'categoryList'));
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

    
    private function canUserReadBook($book)
    {
        // Logic untuk menentukan apakah user bisa membaca buku
        // Bisa berdasarkan subscription, purchase, atau free access
        if (Auth::check()) {
            // Untuk sekarang, semua user terdaftar bisa membaca
            return true;
        }
        return false; // atau true untuk akses gratis
    }

    public function myBooks()
    {
        $userBooks = UserBook::where('user_id', Auth::id())
            ->with(['book.ratings'])
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

    public function toggleWishlist(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $userBook = UserBook::where('user_id', Auth::id())
            ->where('book_id', $id)
            ->first();

        if ($userBook && $userBook->status === 'wishlist') {
            $userBook->delete();

            return response()->json([
                'status' => 'removed'
            ]);
        }

        UserBook::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'book_id' => $id
            ],
            [
                'status' => 'wishlist'
            ]
        );

        return response()->json([
            'status' => 'added'
        ]);
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

