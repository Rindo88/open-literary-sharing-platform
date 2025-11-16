<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AuthorProfile;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use App\Models\UserBook;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('authors.create');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authorProfile = AuthorProfile::where('user_id', auth()->id())->first();

        if (!$authorProfile) {
            return redirect()->route('author.create')->with('error', 'Profil penulis belum dibuat.');
        }

        return view('authors.show', compact('authorProfile'));
    }

    /**
     * Display the dashboard.
     */
    public function dashboard()
    {
        // Menampilkan data untuk grafik [cite: 30]
        $totalBooks = Book::where('author_id', auth()->id())->count();
        $mostReadBooks = Book::withCount('userBooks')
            ->where('author_id', auth()->id())
            ->orderBy('user_books_count', 'desc')
            ->take(5)
            ->get();

        return view('authors.dashboard', compact('totalBooks', 'mostReadBooks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pen_name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'is_verified' => 'nullable|boolean',
            'verified_at' => 'nullable|date',
            'categories' => 'nullable|array',
            'categories.*' => 'integer|exists:categories,id',
        ]);

        try {
            $data = [
                'user_id' => auth()->id(),
                'pen_name' => $validated['pen_name'],
                'bio' => $validated['bio'] ?? null,
                'is_verified' => (bool) $request->boolean('is_verified'),
                'verified_at' => $request->boolean('is_verified')
                    ? ($validated['verified_at'] ?? Carbon::now())
                    : null,
                'categories' => $validated['categories'] ?? [],
            ];

            if ($request->hasFile('avatar')) {
                $data['avatar'] = $request->file('avatar')->store('authors/avatars', 'public');
            }

            AuthorProfile::updateOrCreate([
                'user_id' => auth()->id(),
            ], $data);

            return redirect()->route('author.create')->with('success', 'Profil penulis berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan profil: ' . $e->getMessage());
        }
    }

    /**
     * Show page to manage books.
     */
    public function manageBooks()
    {
        $books = Book::where('author_id', auth()->id())->with('category')->latest()->paginate(10);
        return view('authors.books.index', compact('books'));
    }

    /**
     * Show the form to create a new book.
     */
    public function createBook()
    {
        $categories = Category::all();
        return view('authors.books.create', compact('categories'));
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
            'published_year' => 'required|integer|min:1000|max:' . date('Y'),
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

            return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan.');
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
        return view('authors.books.edit', compact('book', 'categories'));
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
            'published_year' => 'required|integer|min:1000|max:' . date('Y'),
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

            return redirect()->route('books.index')->with('success', 'Data buku berhasil diperbarui.');
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

        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus.');
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

        $popularBooks = Book::withCount(['userBooks as readers_count' => function ($query) {
            $query->whereIn('status', ['reading', 'finished']);
        }])
            ->orderBy('readers_count', 'desc')
            ->limit(10)
            ->get();

        $recentActivity = UserBook::with(['user', 'book'])
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->get();

        return view('authors.reports.index', compact(
            'totalBooks',
            'totalUsers',
            'totalReads',
            'totalCurrentlyReading',
            'popularBooks',
            'recentActivity'
        ));
    }
}
