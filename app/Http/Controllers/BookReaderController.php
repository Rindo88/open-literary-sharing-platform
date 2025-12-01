<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\ReadingSession;
use App\Models\UserBook;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookReaderController extends Controller
{
    public function show($slug)
    {
        try {
            $book = Book::where('slug', $slug)
                ->with(['author', 'ratings.user'])
                ->firstOrFail();

            // Check if user has access to this book
            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk membaca buku ini.');
            }

            // Check if user has the book in their library
            $userBook = UserBook::where('user_id', Auth::id())
                ->where('book_id', $book->id)
                ->first();

            // Allow access if user has book in reading status or wishlist
            if (!$userBook || !in_array($userBook->status, ['reading', 'wishlist'])) {
                return redirect()->route('books.show', $slug)->with('error', 'Anda harus menambahkan buku ini ke daftar baca atau wishlist terlebih dahulu untuk dapat membacanya.');
            }

            // Get or create reading session
            $readingSession = ReadingSession::where('user_id', Auth::id())
                ->where('book_id', $book->id)
                ->where('ended_at', null)
                ->first();

            if (!$readingSession) {
                $readingSession = ReadingSession::create([
                    'user_id' => Auth::id(),
                    'book_id' => $book->id,
                    'started_at' => now(),
                    'current_page' => 1,
                    'total_pages' => $book->pages ?? 1,
                    'last_read_at' => now(),
                ]);
            } else {
                // Update last_read_at for existing session
                $readingSession->update([
                    'last_read_at' => now(),
                ]);
            }

            // Get file path
            if (!$book->file_path || !Storage::disk('public')->exists($book->file_path)) {
                return redirect()->route('books.show', $slug)->with('error', 'File e-book tidak tersedia.');
            }

            $discussions = $book->discussions()
                ->orderBy('last_activity_at', 'desc')
                ->limit(3)
                ->get();

            return view('books.reader', compact('book', 'readingSession', 'discussions'));
        } catch (\Exception $e) {
            return redirect()->route('books.index')->with('error', 'Terjadi kesalahan saat membuka buku: ' . $e->getMessage());
        }
    }

    public function updateProgress(Request $request, $slug)
    {
        try {
            $request->validate([
                'current_page' => 'required|integer|min:1',
                'total_pages' => 'required|integer|min:1',
            ]);

            $book = Book::where('slug', $slug)->firstOrFail();

            // Get or create reading session
            $readingSession = ReadingSession::where('user_id', Auth::id())
                ->where('book_id', $book->id)
                ->where('ended_at', null)
                ->first();

            if (!$readingSession) {
                // Create new session if none exists
                $readingSession = ReadingSession::create([
                    'user_id' => Auth::id(),
                    'book_id' => $book->id,
                    'started_at' => now(),
                    'current_page' => $request->current_page,
                    'total_pages' => $request->total_pages,
                    'last_read_at' => now(),
                ]);
            } else {
                // Update existing session
                $readingSession->update([
                    'current_page' => $request->current_page,
                    'total_pages' => $request->total_pages,
                    'last_read_at' => now(),
                ]);
            }

            // Also update UserBook status to 'reading' if not already
            $userBook = UserBook::where('user_id', Auth::id())
                ->where('book_id', $book->id)
                ->first();

            if ($userBook && $userBook->status !== 'reading') {
                $userBook->update([
                    'status' => 'reading',
                ]);
            }

            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'error' => 'Data tidak valid'], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Terjadi kesalahan saat menyimpan progress'], 500);
        }
    }

    public function finishReading($slug)
    {
        try {
            $book = Book::where('slug', $slug)->firstOrFail();

            // End reading session
            $readingSession = ReadingSession::where('user_id', Auth::id())
                ->where('book_id', $book->id)
                ->where('ended_at', null)
                ->first();

            if ($readingSession) {
                $readingSession->update([
                    'ended_at' => now(),
                ]);
            }

            // Update user book status
            $userBook = UserBook::where('user_id', Auth::id())
                ->where('book_id', $book->id)
                ->first();

            if ($userBook) {
                $userBook->update([
                    'status' => 'finished',
                    'finished_at' => now(),
                ]);
            } else {
                // Create user book if doesn't exist
                UserBook::create([
                    'user_id' => Auth::id(),
                    'book_id' => $book->id,
                    'status' => 'finished',
                    'started_at' => now(),
                    'finished_at' => now(),
                ]);
            }

            return redirect()->route('books.show', ['type' => 'book', 'id' => $book->id])
                ->with('success', 'Selamat! Anda telah menyelesaikan membaca "' . $book->title . '".');
        } catch (\Exception $e) {
            \Log::error('Error in BookReaderController finishReading: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyelesaikan membaca buku: ' . $e->getMessage());
        }
    }
    public function getFile($slug)
    {
        $book = Book::where('slug', $slug)->firstOrFail();

        // Check if user has access
        if (!Auth::check()) {
            abort(403);
        }

        $userBook = UserBook::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->first();

        // Allow access if user has book in reading status or wishlist
        if (!$userBook || !in_array($userBook->status, ['reading', 'wishlist'])) {
            abort(403, 'Anda harus menambahkan buku ini ke daftar baca atau wishlist terlebih dahulu untuk dapat mengakses file.');
        }

        if (!$book->file_path || !Storage::disk('public')->exists($book->file_path)) {
            abort(404);
        }

        // Track reading progress
        $readingSession = ReadingSession::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->where('ended_at', null)
            ->first();

        if ($readingSession) {
            $readingSession->update([
                'last_read_at' => now(),
            ]);
        }

        // Get file path and MIME type using public disk
        if (!$book->file_path) {
            abort(404, 'File e-book tidak tersedia');
        }

        // Check if file exists in public storage
        if (!Storage::disk('public')->exists($book->file_path)) {
            abort(404, 'File e-book tidak ditemukan di storage: ' . $book->file_path);
        }

        // Get MIME type
        $extension = pathinfo($book->file_path, PATHINFO_EXTENSION);
        $mimeType = $this->getMimeType($extension);

        // Get the actual file path using public disk
        $filePath = storage_path('app/public/' . $book->file_path);

        // Check if file exists
        if (!file_exists($filePath)) {
            abort(404, 'File e-book tidak dapat diakses: ' . $filePath);
        }

        // Return file response
        // For EPUB files, force download instead of inline display
        $disposition = ($extension === 'epub') ? 'attachment' : 'inline';

        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => $disposition . '; filename="' . basename($book->file_path) . '"',
        ]);
    }

    /**
     * Stream file for PDF viewer (inline display)
     */
    public function streamFile($slug)
    {
        $book = Book::where('slug', $slug)->firstOrFail();

        // Check if user has access
        if (!Auth::check()) {
            abort(403);
        }

        $userBook = UserBook::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->first();

        // Allow access if user has book in reading status or wishlist
        if (!$userBook || !in_array($userBook->status, ['reading', 'wishlist'])) {
            abort(403, 'Anda harus menambahkan buku ini ke daftar baca atau wishlist terlebih dahulu untuk dapat mengakses file.');
        }

        // Check if file exists
        if (!$book->file_path || !Storage::disk('public')->exists($book->file_path)) {
            abort(404, 'File e-book tidak tersedia');
        }

        $filePath = storage_path('app/public/' . $book->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'File e-book tidak dapat diakses');
        }

        // For PDF files, return inline for viewer
        $extension = pathinfo($book->file_path, PATHINFO_EXTENSION);
        $mimeType = $this->getMimeType($extension);

        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($book->file_path) . '"',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    /**
     * Get MIME type based on file extension
     */
    private function getMimeType($extension)
    {
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'epub' => 'application/epub+zip',
            'txt' => 'text/plain',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];

        return $mimeTypes[strtolower($extension)] ?? 'application/octet-stream';
    }

    /**
     * Get EPUB metadata (basic implementation)
     */
    private function getEpubMetadata($filePath)
    {
        try {
            // Basic EPUB metadata extraction
            $zip = new \ZipArchive();
            if ($zip->open($filePath) === TRUE) {
                // Look for container.xml to get OPF file location
                $containerXml = $zip->getFromName('META-INF/container.xml');
                if ($containerXml) {
                    // Parse container.xml to find OPF file
                    $xml = simplexml_load_string($containerXml);
                    $opfPath = (string)$xml->rootfiles->rootfile['full-path'];

                    // Get OPF file content
                    $opfContent = $zip->getFromName($opfPath);
                    if ($opfContent) {
                        $opf = simplexml_load_string($opfContent);

                        // Extract basic metadata
                        $metadata = [
                            'title' => (string)$opf->metadata->dc->title ?? 'Unknown Title',
                            'creator' => (string)$opf->metadata->dc->creator ?? 'Unknown Author',
                            'language' => (string)$opf->metadata->dc->language ?? 'en',
                            'identifier' => (string)$opf->metadata->dc->identifier ?? '',
                            'publisher' => (string)$opf->metadata->dc->publisher ?? '',
                            'date' => (string)$opf->metadata->dc->date ?? '',
                        ];

                        $zip->close();
                        return $metadata;
                    }
                }
                $zip->close();
            }
        } catch (\Exception $e) {
            // Log error but don't fail
            \Log::warning('Failed to extract EPUB metadata: ' . $e->getMessage());
        }

        return null;
    }
}
