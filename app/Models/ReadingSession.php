<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReadingSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'started_at',
        'ended_at',
        'duration',
        'pages_read',
        'notes',
        'current_page',
        'total_pages',
        'last_read_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'duration' => 'integer', // in minutes
        'pages_read' => 'integer',
        'current_page' => 'integer',
        'total_pages' => 'integer',
        'last_read_at' => 'datetime',
    ];

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
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByBook($query, $bookId)
    {
        return $query->where('book_id', $bookId);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('started_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('started_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('started_at', now()->month)
                    ->whereYear('started_at', now()->year);
    }

    // Accessors
    public function getFormattedDurationAttribute(): string
    {
        if (!$this->duration) {
            return '0 menit';
        }

        $hours = floor($this->duration / 60);
        $minutes = $this->duration % 60;

        if ($hours > 0) {
            return "{$hours} jam " . ($minutes > 0 ? "{$minutes} menit" : '');
        }

        return "{$minutes} menit";
    }

    public function getReadingSpeedAttribute(): float
    {
        if (!$this->duration || !$this->pages_read) {
            return 0.0;
        }

        // Pages per hour
        return ($this->pages_read / ($this->duration / 60));
    }
}