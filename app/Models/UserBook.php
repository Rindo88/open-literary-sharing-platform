<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'status',
        'started_at',
        'finished_at',
        'last_page',
        'reading_duration',
        'notes',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'last_page' => 'integer',
        'reading_duration' => 'integer', // in minutes
    ];

    // Status constants
    const STATUS_WISHLIST = 'wishlist';
    const STATUS_READING = 'reading';
    const STATUS_FINISHED = 'finished';
    const STATUS_ABANDONED = 'abandoned';

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Accessors
    public function getReadingProgressAttribute(): float
    {
        if (!$this->book || !$this->book->pages) {
            return 0.0;
        }

        if ($this->status === self::STATUS_FINISHED) {
            return 100.0;
        }

        if ($this->last_page && $this->book->pages) {
            return min(100.0, ($this->last_page / $this->book->pages) * 100);
        }

        return 0.0;
    }

    public function getFormattedReadingDurationAttribute(): string
    {
        if (!$this->reading_duration) {
            return '0 menit';
        }

        $hours = floor($this->reading_duration / 60);
        $minutes = $this->reading_duration % 60;

        if ($hours > 0) {
            return "{$hours} jam " . ($minutes > 0 ? "{$minutes} menit" : '');
        }

        return "{$minutes} menit";
    }
}
