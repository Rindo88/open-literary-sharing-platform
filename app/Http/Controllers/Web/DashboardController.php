<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Models\UserBook;
use App\Models\ReadingSession;
use App\Models\Rating;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return redirect()->route('login');
            }

            // Get total books count
            $totalBooks = Book::count();
            
            // Get user's finished books count
            $finishedBooks = UserBook::where('user_id', $user->id)
                ->where('status', 'finished')
                ->count();
            
            // Get user's currently reading books
            $currentlyReading = UserBook::where('user_id', $user->id)
                ->where('status', 'reading')
                ->count();
            
            // Get average rating for all books
            $averageRating = Rating::avg('rating');
            $averageRating = $averageRating ? round($averageRating, 1) : 0;
            
            // Get recent activity (sederhana dulu untuk menghindari error)
            $recentActivity = collect();
            
            // Get reading progress
            $readingProgress = ReadingSession::where('user_id', $user->id)
                ->whereNull('ended_at')
                ->with(['book'])
                ->get()
                ->map(function ($session) {
                    if (!$session->book) return null;
                    
                    $currentPage = $session->current_page ?? 1;
                    $totalPages = $session->total_pages ?? ($session->book->pages ?? 1);
                    $progress = $totalPages > 0 
                        ? round(($currentPage / $totalPages) * 100, 1)
                        : 0;
                    
                    return [
                        'book_title' => $session->book->title,
                        'book_slug' => $session->book->slug,
                        'current_page' => $currentPage,
                        'total_pages' => $totalPages,
                        'progress' => $progress,
                        'last_read' => $session->last_read_at
                    ];
                })
                ->filter()
                ->take(3);
            
            // Get popular books
            $popularBooks = Book::withCount(['userBooks as readers_count'])
                ->withAvg('ratings', 'rating')
                ->orderBy('readers_count', 'desc')
                ->limit(8)
                ->get()
                ->map(function ($book) {
                    $book->average_rating = round($book->ratings_avg_rating ?? 0, 1);
                    return $book;
                });

            return view('dashboard', compact(
                'totalBooks',
                'finishedBooks', 
                'currentlyReading',
                'averageRating',
                'recentActivity',
                'readingProgress',
                'popularBooks'
            ));
            
        } catch (\Exception $e) {
            \Log::error('Dashboard error: ' . $e->getMessage());
            return redirect()->route('books.index')->with('error', 'Terjadi kesalahan saat memuat dashboard.');
        }
    }
}