<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Image
 */
class ImageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => $this->whenLoaded('user'),
            $this->mergeWhen(!$this->relationLoaded('user'), [
                'user_id' => $this->user_id
            ]),
            'original_path' => $this->original_path,
            'preview_path' => $this->preview_path
        ];
    }
}
