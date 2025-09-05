<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\DiscussionParticipant;

class BookDiscussion extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'title',
        'description',
        'status',
        'participants_count',
        'messages_count',
        'last_activity_at',
        'created_by',
    ];

    protected $casts = [
        'last_activity_at' => 'datetime',
    ];

    /**
     * Get the book that owns the discussion.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Get the user who created the discussion.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the messages for the discussion.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(DiscussionMessage::class, 'discussion_id');
    }

    /**
     * Get the participants for the discussion.
     */
    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'discussion_participants', 'discussion_id', 'user_id')
                    ->withPivot('role', 'joined_at', 'last_read_at', 'is_muted')
                    ->withTimestamps()
                    ->using(DiscussionParticipant::class);
    }

    /**
     * Get the latest message for the discussion.
     */
    public function latestMessage(): BelongsTo
    {
        return $this->belongsTo(DiscussionMessage::class, 'id', 'discussion_id')
                    ->latest();
    }

    /**
     * Check if a user is a participant in this discussion.
     */
    public function isParticipant(User $user): bool
    {
        return $this->participants()->where('user_id', $user->id)->exists();
    }

    /**
     * Get the role of a user in this discussion.
     */
    public function getUserRole(User $user): ?string
    {
        $participant = $this->participants()->where('user_id', $user->id)->first();
        return $participant ? $participant->pivot->role : null;
    }

    /**
     * Update the last activity timestamp.
     */
    public function updateLastActivity(): void
    {
        $this->update(['last_activity_at' => now()]);
    }

    /**
     * Increment the messages count.
     */
    public function incrementMessagesCount(): void
    {
        $this->increment('messages_count');
    }

    /**
     * Update the participants count.
     */
    public function updateParticipantsCount(): void
    {
        $this->update([
            'participants_count' => $this->participants()->count()
        ]);
    }
}
