<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthorProfile extends Model
{
    protected $fillable = [
        'user_id',
        'pen_name',
        'bio',
        'avatar',
        'is_verified',
        'verified_at',
        'categories',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
        'categories' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function books()
    {
        return $this->hasMany(Book::class, 'author_id');
    }

    public function getDisplayNameAttribute()
    {
        return $this->pen_name ?? $this->user->name;
    }

    public function getVerifiedBadgeAttribute()
    {
        return $this->is_verified ? '✅ Verified Author' : null;
    }

    //  Untuk mendapatkan buku yang sudah published
    public function getPublishedBooksAttribute()
    {
        return $this->books()->published()->get();
    }

    // Untuk mendapatkan total buku published
    public function getPublishedBooksCountAttribute()
    {
        return $this->books()->published()->count();
    }
}
