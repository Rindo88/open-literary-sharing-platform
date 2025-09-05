<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'author',
        'description',
        'isbn',
        'published_year',
        'publisher',
        'pages',
        'cover_image',
        'category_id',
        'status',
        'file_path',
        'total_copies',
    ];

    protected $casts = [
        'published_year' => 'integer',
        'pages' => 'integer',
    ];

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function userBooks(): HasMany
    {
        return $this->hasMany(UserBook::class);
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    public function readingSessions(): HasMany
    {
        return $this->hasMany(ReadingSession::class);
    }

    public function discussions(): HasMany
    {
        return $this->hasMany(BookDiscussion::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    // Accessors
    public function getAverageRatingAttribute(): float
    {
        return $this->ratings()->avg('rating') ?? 0.0;
    }

    public function getRatingCountAttribute(): int
    {
        return $this->ratings()->count();
    }

    public function getIsInUserWishlistAttribute(): bool
    {
        if (!auth()->check()) {
            return false;
        }
        
        return $this->userBooks()
            ->where('user_id', auth()->id())
            ->where('status', 'wishlist')
            ->exists();
    }

    public function getUserReadingStatusAttribute(): ?string
    {
        if (!auth()->check()) {
            return null;
        }
        
        $userBook = $this->userBooks()
            ->where('user_id', auth()->id())
            ->first();
            
        return $userBook ? $userBook->status : null;
    }

    // Mutators
    public function setTitleAttribute($value): void
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('author', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    public function scopeTopRated($query, $limit = 10)
    {
        return $query->withAvg('ratings', 'rating')
                    ->orderBy('ratings_avg_rating', 'desc')
                    ->limit($limit);
    }

    public function scopeLatest($query, $limit = 10)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

} 