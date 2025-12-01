<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'author_id',
        'description',
        'isbn',
        'published_year',
        'publisher',
        'pages',
        'cover_image',
        'categories',
        'status',
        'file_path',
    ];

    protected $casts = [
        'published_year' => 'integer',
        'pages' => 'integer',
        'categories' => 'array'
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(AuthorProfile::class, 'author_id');
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


    public function scopeByCategory($query, $categorySlug)
    {
        return $query->whereJsonContains('categories', $categorySlug);
    }


    public function getTotalRatingsAttribute()
    {
        return $this->ratings()->count();
    }

    // Accessors
    public function getDiscussionsCountAttribute()
    {
        return $this->discussions()->count();
    }

    public function getCategoryListAttribute()
    {
        if (!is_array($this->categories)) {
            return collect([]);
        }

        return Category::whereIn('id', $this->categories)->get();
    }

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

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
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

    // PERBAIKAN: Ambil category objects berdasarkan ID
    public function getCategoryObjectsAttribute()
    {
        if (!$this->categories) return collect();

        return Category::whereIn('id', $this->categories)->get();
    }

    // Untuk backward compatibility
    public function getCategoryNamesAttribute()
    {
        return $this->categoryObjects->pluck('name');
    }
}
