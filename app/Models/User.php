<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'avatar',
        'bio',
        'google_id',
        'role',
        'profile_photo',
        'phone',
        'address',
        'birth_date',
        'gender',
        'city',
        'postal_code',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'birth_date' => 'date',
    ];

    public function authorProfile()
    {
        return $this->hasOne(AuthorProfile::class);
    }

    // Relationships
    public function userBooks()
    {
        return $this->hasMany(UserBook::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function readingSessions()
    {
        return $this->hasMany(ReadingSession::class);
    }

    // Books dengan status tertentu
    public function readingBooks()
    {
        return $this->belongsToMany(Book::class, 'user_books')->wherePivot('status', 'reading');
    }

    public function finishedBooks()
    {
        return $this->belongsToMany(Book::class, 'user_books')->wherePivot('status', 'finished');
    }

    public function wishlistBooks()
    {
        return $this->belongsToMany(Book::class, 'user_books')->wherePivot('status', 'wishlist');
    }

    public function discussionMessages()
    {
        return $this->hasMany(DiscussionMessage::class);
    }

    public function participatedDiscussions()
    {
        return $this->belongsToMany(BookDiscussion::class, 'discussion_participants', 'user_id', 'discussion_id')
                    ->withPivot('role', 'joined_at', 'last_read_at', 'is_muted')
                    ->withTimestamps()
                    ->using(DiscussionParticipant::class);
    }

    public function createdDiscussions()
    {
        return $this->hasMany(BookDiscussion::class, 'created_by');
    }

}