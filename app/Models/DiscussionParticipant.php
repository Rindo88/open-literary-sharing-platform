<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class DiscussionParticipant extends Pivot
{
    protected $table = 'discussion_participants';

    protected $fillable = [
        'discussion_id',
        'user_id',
        'role',
        'joined_at',
        'last_read_at',
        'is_muted',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
        'last_read_at' => 'datetime',
        'is_muted' => 'boolean',
    ];
}
