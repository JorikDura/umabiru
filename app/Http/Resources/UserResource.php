<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
final class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->whenHas('name'),
            'username' => $this->username,
            'gender' => $this->gender,
            'role' => $this->role,
            'description' => $this->whenHas('description'),
            'image' => ImageResource::make($this->whenLoaded('image')),
            'created_at' => $this->created_at,
        ];
    }
}
