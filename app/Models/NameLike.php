<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NameLike extends Model
{
    protected $fillable = [
        'name_id',
        'ip_hash',
        'voter_token_hash',
    ];

    public function name(): BelongsTo
    {
        return $this->belongsTo(Name::class);
    }
}
