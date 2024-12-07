<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Comment
 */
final class CommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'user' => UserResource::make(($this->whenLoaded('user'))),
            $this->mergeWhen(! $this->relationLoaded('comments'), [
                'user_id' => $this->user_id,
            ]),
            'likes_count' => $this->whenHas('likes_count'),
            'is_liked' => $this->whenHas('is_liked'),
            'created_at' => $this->created_at,
        ];
    }
}
