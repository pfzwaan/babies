<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NameComment extends Model
{
    protected $fillable = [
        'name_id',
        'author_name',
        'author_email',
        'message',
        'is_approved',
        'approved_at',
        'ip_hash',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'approved_at' => 'datetime',
    ];

    public function name(): BelongsTo
    {
        return $this->belongsTo(Name::class);
    }
}
