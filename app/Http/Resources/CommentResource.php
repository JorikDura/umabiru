<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Comment
 */
class CommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => UserResource::max(($this->whenLoaded('user'))),
            $this->mergeWhen(!$this->relationLoaded('comments'), [
                'user_id' => $this->user_id
            ])
        ];
    }
}
