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
}
