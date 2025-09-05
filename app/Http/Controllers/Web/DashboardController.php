<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\UserBook;
use App\Models\Rating;
use App\Models\ReadingSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get total books count
        $totalBooks = Book::count();
        
        // Get user's finished books count
        $finishedBooks = UserBook::where('user_id', $user->id)
            ->where('status', 'finished')
            ->count();
        
        // Get user's currently reading books count (from both UserBook and ReadingSession)
        $currentlyReading = UserBook::where('user_id', $user->id)
            ->where('status', 'reading')
            ->count();
        
        // Also check ReadingSession for active sessions
        $activeSessions = ReadingSession::where('user_id', $user->id)
            ->whereNull('ended_at')
            ->count();
        
        // Use the higher count between the two
        $currentlyReading = max($currentlyReading, $activeSessions);
        
        // Get average rating for all books
        $averageRating = Rating::avg('rating');
        $averageRating = $averageRating ? round($averageRating, 1) : null;
        
        // Get user's recent reading activity from both ReadingSession and UserBook
        $recentActivity = collect();
        
        // Get recent reading sessions
        $recentSessions = ReadingSession::where('user_id', $user->id)
            ->with(['book'])
            ->whereNotNull('last_read_at')
            ->orderBy('last_read_at', 'desc')
            ->limit(5)
            ->get()
            ->filter(function ($session) {
                return $session->book;
            })
            ->map(function ($session) {
                $timeAgo = $session->last_read_at->diffForHumans();
                $status = $session->ended_at ? 'Selesai' : 'Sedang dibaca';
                
                return [
                    'book_title' => $session->book->title,
                    'status' => $status,
                    'time_ago' => $timeAgo,
                    'icon' => $session->ended_at ? 'check' : 'book-open',
                    'color' => $session->ended_at ? 'green' : 'blue',
                    'timestamp' => $session->last_read_at
                ];
            });
        
        // Get recent book additions to library
        $recentAdditions = UserBook::where('user_id', $user->id)
            ->with(['book'])
            ->whereNotNull('created_at')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get()
            ->filter(function ($userBook) {
                return $userBook->book;
            })
            ->map(function ($userBook) {
                return [
                    'book_title' => $userBook->book->title,
                    'status' => 'Ditambahkan ke Library',
                    'time_ago' => $userBook->created_at->diffForHumans(),
                    'icon' => 'plus',
                    'color' => 'purple',
                    'timestamp' => $userBook->created_at
                ];
            });
        
        // Get recent book completions
        $recentCompletions = UserBook::where('user_id', $user->id)
            ->with(['book'])
            ->where('status', 'finished')
            ->whereNotNull('finished_at')
            ->orderBy('finished_at', 'desc')
            ->limit(3)
            ->get()
            ->filter(function ($userBook) {
                return $userBook->book;
            })
            ->map(function ($userBook) {
                return [
                    'book_title' => $userBook->book->title,
                    'status' => 'Selesai Dibaca',
                    'time_ago' => $userBook->finished_at->diffForHumans(),
                    'icon' => 'check',
                    'color' => 'green',
                    'timestamp' => $userBook->finished_at
                ];
            });
        
        // Merge all activities and sort by timestamp
        $recentActivity = $recentSessions
            ->concat($recentAdditions)
            ->concat($recentCompletions)
            ->sortByDesc('timestamp')
            ->take(5) // Show top 5 most recent activities
            ->values();
        
        // Get user's reading progress from ReadingSession with active status
        $readingProgress = ReadingSession::where('user_id', $user->id)
            ->whereNull('ended_at')
            ->with(['book'])
            ->get()
            ->filter(function ($session) {
                return $session->book; // Only include books that exist
            })
            ->map(function ($session) {
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
            ->sortByDesc('last_read') // Sort by last read date
            ->unique('book_id'); // Ensure only one entry per book
        
        // Get popular books based on readers count and ratings
        $popularBooks = Book::withCount(['userBooks as readers_count', 'ratings as ratings_count'])
            ->withAvg('ratings', 'rating')
            ->having('readers_count', '>', 0)
            ->orderBy('readers_count', 'desc')
            ->orderBy('ratings_count', 'desc')
            ->orderBy('ratings_avg_rating', 'desc')
            ->limit(8)
            ->get()
            ->filter(function ($book) {
                // Ensure book has valid ID
                return $book && $book->id;
            })
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
    }

}
