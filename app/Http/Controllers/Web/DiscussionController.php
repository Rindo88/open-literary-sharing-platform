<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookDiscussion;
use App\Models\DiscussionMessage;
use App\Models\DiscussionParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiscussionController extends Controller
{
    public function index()
    {
        $readingBooks = auth()->user()->userBooks()
            ->with(['book', 'book.discussions' => function($query) {
                $query->where('status', 'active')->withCount(['participants', 'messages']);
            }])
            ->where('status', 'reading')
            ->get();
            
        $finishedBooks = auth()->user()->userBooks()
            ->with(['book', 'book.discussions' => function($query) {
                $query->where('status', 'active')->withCount(['participants', 'messages']);
            }])
            ->where('status', 'finished')
            ->get();

        return view('discussions.index', compact('readingBooks', 'finishedBooks'));
    }

    public function show(Book $book)
    {
        $discussions = $book->discussions()
            ->where('status', 'active')
            ->withCount(['participants', 'messages'])
            ->with(['latestMessage.user', 'participants'])
            ->orderBy('last_activity_at', 'desc')
            ->get();

        return view('discussions.show', compact('book', 'discussions'));
    }

    public function create(Book $book)
    {
        return view('discussions.create', compact('book'));
    }

    public function store(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'is_private' => 'boolean',
            'max_participants' => 'nullable|integer|min:2|max:100'
        ]);

        DB::beginTransaction();
        try {
            $discussion = BookDiscussion::create([
                'book_id' => $book->id,
                'created_by' => auth()->id(),
                'title' => $validated['title'],
                'description' => $validated['description'],
                'is_private' => $validated['is_private'] ?? false,
                'max_participants' => $validated['max_participants'],
                'status' => 'active',
                'last_activity_at' => now()
            ]);

            // Add creator as moderator
            DiscussionParticipant::create([
                'discussion_id' => $discussion->id,
                'user_id' => auth()->id(),
                'role' => 'moderator',
                'joined_at' => now(),
                'last_read_at' => now()
            ]);

            // Update counts
            $discussion->updateParticipantsCount();

            DB::commit();

            return redirect()->route('discussions.show', $book)
                ->with('success', 'Diskusi berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat diskusi: ' . $e->getMessage());
        }
    }

    public function join(Request $request, Book $book, BookDiscussion $discussion)
    {
        if ($discussion->isParticipant(auth()->user())) {
            return back()->with('error', 'Anda sudah bergabung dengan diskusi ini');
        }

        if ($discussion->max_participants && $discussion->participants()->count() >= $discussion->max_participants) {
            return back()->with('error', 'Diskusi ini sudah penuh');
        }

        DiscussionParticipant::create([
            'discussion_id' => $discussion->id,
            'user_id' => auth()->id(),
            'role' => 'participant',
            'joined_at' => now(),
            'last_read_at' => now()
        ]);

        $discussion->updateParticipantsCount();

        return back()->with('success', 'Berhasil bergabung dengan diskusi!');
    }

    public function leave(Request $request, Book $book, BookDiscussion $discussion)
    {
        $participant = $discussion->participants()
            ->where('user_id', auth()->id())
            ->first();

        if (!$participant) {
            return back()->with('error', 'Anda tidak bergabung dengan diskusi ini');
        }

        if ($participant->pivot->role === 'moderator' && $discussion->participants()->count() === 1) {
            return back()->with('error', 'Tidak bisa keluar karena Anda adalah moderator terakhir');
        }

        $discussion->participants()->detach(auth()->id());
        $discussion->updateParticipantsCount();

        return back()->with('success', 'Berhasil keluar dari diskusi');
    }

    public function storeMessage(Request $request, Book $book, BookDiscussion $discussion)
    {
        if (!$discussion->isParticipant(auth()->user())) {
            return back()->with('error', 'Anda harus bergabung dengan diskusi terlebih dahulu');
        }

        $validated = $request->validate([
            'message' => 'required|string|max:2000'
        ]);

        $message = DiscussionMessage::create([
            'discussion_id' => $discussion->id,
            'user_id' => auth()->id(),
            'message' => $validated['message'],
            'type' => 'text'
        ]);

        // Update last activity and message count
        $discussion->updateLastActivity();
        $discussion->incrementMessagesCount();

        // Update last read for sender
        $discussion->participants()
            ->where('user_id', auth()->id())
            ->update(['last_read_at' => now()]);

        return back()->with('success', 'Pesan berhasil dikirim');
    }

    public function chat(Book $book, BookDiscussion $discussion)
    {
        $discussion->load(['messages.user', 'participants']);
        
        return view('discussions.chat', compact('book', 'discussion'));
    }
}
