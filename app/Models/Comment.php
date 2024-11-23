<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    use HasFactory;
    use HasImages;

    protected $fillable = [
        'user_id',
        'text',
        'commentable_id',
        'commentable_type'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comment(): MorphTo
    {
        return $this->morphTo();
    }
}
