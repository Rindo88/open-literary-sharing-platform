<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use App\Models\UserBook;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Anda perlu menambahkan middleware untuk admin di constructor atau di file routes/web.php
    // public function __construct() {
    //     $this->middleware('auth'); // Contoh dasar, idealnya ada middleware 'is_admin'
    // }

    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        // Menampilkan data untuk grafik [cite: 30]
        $totalUsers = User::count();
        $totalBooks = Book::count();
        $mostReadBooks = Book::withCount('userBooks')->orderBy('user_books_count', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('totalUsers', 'totalBooks', 'mostReadBooks'));
    }

    /**
     * Show page to manage books.
     */
    public function manageBooks()
    {
        // Fitur Manajemen Buku (Read) [cite: 28]
        $books = Book::with('category')->latest()->paginate(10);
        return view('admin.books.index', compact('books'));
    }

    /**
     * Show the form to create a new book.
     */
    public function createBook()
    {
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

    /**
     * Store a new book in the database.
     */
    public function storeBook(Request $request)
    {
        // Fitur Manajemen Buku (Create) [cite: 28]
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string',
            'published_year' => 'required|integer|min:1000|max:'.date('Y'),
            'pages' => 'required|integer',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'file_path' => 'nullable|file|mimes:pdf,epub',
            'isbn' => 'nullable|string|max:20',
        ]);

        try {
            $bookData = $request->except(['cover_image', 'file_path']);

            // Generate slug from title
            $bookData['slug'] = \Str::slug($request->title);
            
            // Handle ISBN - if empty or just dashes, set to null
            if (empty($request->isbn) || $request->isbn === '-') {
                $bookData['isbn'] = null;
            }

            if ($request->hasFile('cover_image')) {
                $bookData['cover_image'] = $request->file('cover_image')->store('covers', 'public');
            }

            if ($request->hasFile('file_path')) {
                $bookData['file_path'] = $request->file('file_path')->store('books', 'public');
            }
            
            // Set default status
            $bookData['status'] = 'published';

            Book::create($bookData);

            return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan.');

        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database errors
            if ($e->getCode() == 23000) { // Integrity constraint violation
                if (strpos($e->getMessage(), 'books_isbn_unique') !== false) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'ISBN sudah digunakan. Silakan gunakan ISBN yang berbeda atau kosongkan field ISBN.');
                } elseif (strpos($e->getMessage(), 'books_slug_unique') !== false) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Judul buku sudah ada. Silakan gunakan judul yang berbeda.');
                } else {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Terjadi kesalahan database. Data mungkin sudah ada atau tidak valid.');
                }
            }
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form to edit a book.
     */
    public function editBook(Book $book)
    {
        $categories = Category::all();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    /**
     * Update an existing book.
     */
    public function updateBook(Request $request, Book $book)
    {
        // Fitur Manajemen Buku (Update) [cite: 28]
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string',
            'published_year' => 'required|integer|min:1000|max:'.date('Y'),
            'pages' => 'required|integer',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'file_path' => 'nullable|file|mimes:pdf,epub',
            'status' => 'required|in:draft,published,archived',
            'isbn' => 'nullable|string|max:20',
        ]);
        
        try {
            $bookData = $request->except(['cover_image', 'file_path']);

            // Generate slug from title if title changed
            if ($request->title !== $book->title) {
                $bookData['slug'] = \Str::slug($request->title);
            }
            
            // Handle ISBN - if empty or just dashes, set to null
            if (empty($request->isbn) || $request->isbn === '-') {
                $bookData['isbn'] = null;
            }
            
            if ($request->hasFile('cover_image')) {
                // Hapus file lama jika ada
                if ($book->cover_image) {
                    Storage::disk('public')->delete($book->cover_image);
                }
                $bookData['cover_image'] = $request->file('cover_image')->store('covers', 'public');
            }

            if ($request->hasFile('file_path')) {
                // Hapus file lama jika ada
                if ($book->file_path) {
                    Storage::disk('public')->delete($book->file_path);
                }
                $bookData['file_path'] = $request->file('file_path')->store('books', 'public');
            }

            $book->update($bookData);
            
            return redirect()->route('admin.books.index')->with('success', 'Data buku berhasil diperbarui.');

        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database errors
            if ($e->getCode() == 23000) { // Integrity constraint violation
                if (strpos($e->getMessage(), 'books_isbn_unique') !== false) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'ISBN sudah digunakan. Silakan gunakan ISBN yang berbeda atau kosongkan field ISBN.');
                } elseif (strpos($e->getMessage(), 'books_slug_unique') !== false) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Judul buku sudah ada. Silakan gunakan judul yang berbeda.');
                } else {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Terjadi kesalahan database. Data mungkin sudah ada atau tidak valid.');
                }
            }
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Delete a book.
     */
    public function destroyBook(Book $book)
    {
        // Fitur Manajemen Buku (Delete) [cite: 28]
        // Hapus juga file dari storage
        // Storage::disk('public')->delete($book->cover_image);
        // Storage::disk('public')->delete($book->file_path);
        
        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus.');
    }

    /**
     * Show page to manage users.
     */
    public function manageUsers()
    {
        // Fitur Manajemen Pengguna [cite: 29]
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show reports page.
     */
    public function reports()
    {
        // Fitur Laporan [cite: 30]
        $totalBooks = Book::count();
        $totalUsers = User::where('role', 'user')->count();
        $totalReads = UserBook::where('status', 'finished')->count();
        $totalCurrentlyReading = UserBook::where('status', 'reading')->count();
        
        $popularBooks = Book::withCount(['userBooks as readers_count' => function($query) {
            $query->whereIn('status', ['reading', 'finished']);
        }])
        ->orderBy('readers_count', 'desc')
        ->limit(10)
        ->get();
        
        $recentActivity = UserBook::with(['user', 'book'])
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->get();
            
        return view('admin.reports.index', compact(
            'totalBooks', 
            'totalUsers', 
            'totalReads', 
            'totalCurrentlyReading',
            'popularBooks',
            'recentActivity'
        ));
    }
}