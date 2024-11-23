<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'original_path',
        'preview_path',
        'imageable_id',
        'imageable_type'
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function image(): MorphTo
    {
        return $this->morphTo();
    }
}
