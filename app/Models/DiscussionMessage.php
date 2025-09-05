<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiscussionMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'discussion_id',
        'user_id',
        'message',
        'attachments',
        'is_edited',
        'edited_at',
    ];

    protected $casts = [
        'attachments' => 'array',
        'is_edited' => 'boolean',
        'edited_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the discussion that owns the message.
     */
    public function discussion(): BelongsTo
    {
        return $this->belongsTo(BookDiscussion::class, 'discussion_id');
    }

    /**
     * Get the user that owns the message.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the message can be edited by the given user.
     */
    public function canBeEditedBy(User $user): bool
    {
        return $user->id === $this->user_id || 
               $user->role === 'admin' ||
               $this->discussion->getUserRole($user) === 'moderator';
    }

    /**
     * Mark the message as edited.
     */
    public function markAsEdited(): void
    {
        $this->update([
            'is_edited' => true,
            'edited_at' => now()
        ]);
    }

    /**
     * Get the formatted message with edit indicator.
     */
    public function getFormattedMessage(): string
    {
        $message = $this->message;
        if ($this->is_edited) {
            $message .= ' <span class="text-xs text-gray-500">(diedit)</span>';
        }
        return $message;
    }

    /**
     * Scope to get recent messages.
     */
    public function scopeRecent($query, $limit = 50)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }
}
