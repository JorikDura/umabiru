<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Image;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasImage
{
    /**
     * @return MorphOne
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * @return void
     */
    public function deleteImage(): void
    {
        /** @var ?Image $image */
        $image = $this->image()->first();

        $image?->delete();
    }
}
