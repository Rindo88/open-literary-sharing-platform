<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'color',
        'icon',
    ];

    // Accessors
    public function getBookCountAttribute(): int
    {
        return $this->books()->count();
    }

    public function getAverageRatingAttribute(): float
    {
        return $this->books()
            ->withAvg('ratings', 'rating')
            ->get()
            ->avg('ratings_avg_rating') ?? 0.0;
    }
}
