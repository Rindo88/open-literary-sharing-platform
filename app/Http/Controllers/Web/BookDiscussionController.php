<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookDiscussion;
use App\Models\DiscussionMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookDiscussionController extends Controller
{
    /**
     * Display the discussions for a specific book.
     */
    public function index(Book $book)
    {
        $discussions = $book->discussions()
            ->with(['latestMessage.user', 'participants'])
            ->orderBy('last_activity_at', 'desc')
            ->paginate(10);

        return view('discussions.index', compact('book', 'discussions'));
    }

    /**
     * Show a specific discussion with its messages.
     */
    public function show(Book $book, BookDiscussion $discussion)
    {
        // Check if user is participant, if not, auto-join
        if (!Auth::user()->participatedDiscussions()->where('discussion_id', $discussion->id)->exists()) {
            $this->joinDiscussion($discussion);
        }

        // Update last read timestamp
        $this->updateLastRead($discussion);

        $messages = $discussion->messages()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->paginate(50);

        $participants = $discussion->participants()
            ->orderBy('pivot_joined_at', 'asc')
            ->get();

        return view('discussions.show', compact('book', 'discussion', 'messages', 'participants'));
    }

    /**
     * Show the form for creating a new discussion.
     */
    public function create(Book $book)
    {
        return view('discussions.create', compact('book'));
    }

    /**
     * Store a new discussion.
     */
    public function store(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        DB::transaction(function () use ($request, $book) {
            $discussion = $book->discussions()->create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => 'active',
                'last_activity_at' => now(),
                'created_by' => Auth::id(),
            ]);

            // Auto-join the creator
            $discussion->participants()->attach(Auth::id(), [
                'role' => 'moderator',
                'joined_at' => now(),
            ]);

            $discussion->updateParticipantsCount();
        });

        return redirect()->route('books.discussions.index', $book)
            ->with('success', 'Diskusi baru berhasil dibuat!');
    }

    /**
     * Store a new message in the discussion.
     */
    public function storeMessage(Request $request, Book $book, BookDiscussion $discussion)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $message = $discussion->messages()->create([
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        // Update discussion stats
        $discussion->incrementMessagesCount();
        $discussion->updateLastActivity();

        return redirect()->route('books.discussions.show', [$book, $discussion])
            ->with('success', 'Pesan berhasil dikirim!');
    }

    /**
     * Join a discussion.
     */
    public function join(Book $book, BookDiscussion $discussion)
    {
        if (!Auth::user()->participatedDiscussions()->where('discussion_id', $discussion->id)->exists()) {
            $this->joinDiscussion($discussion);
            return redirect()->route('books.discussions.show', [$book, $discussion])
                ->with('success', 'Anda berhasil bergabung dengan diskusi!');
        }

        return redirect()->route('books.discussions.show', [$book, $discussion])
            ->with('info', 'Anda sudah bergabung dengan diskusi ini.');
    }

    /**
     * Leave a discussion.
     */
    public function leave(Book $book, BookDiscussion $discussion)
    {
        Auth::user()->participatedDiscussions()->detach($discussion->id);
        $discussion->updateParticipantsCount();

        return redirect()->route('books.discussions.index', $book)
            ->with('success', 'Anda berhasil keluar dari diskusi.');
    }

    /**
     * Join discussion helper method.
     */
    private function joinDiscussion(BookDiscussion $discussion): void
    {
        $discussion->participants()->attach(Auth::id(), [
            'role' => 'member',
            'joined_at' => now(),
        ]);
        $discussion->updateParticipantsCount();
    }

    /**
     * Update last read timestamp.
     */
    private function updateLastRead(BookDiscussion $discussion): void
    {
        $discussion->participants()->updateExistingPivot(Auth::id(), [
            'last_read_at' => now(),
        ]);
    }
}
