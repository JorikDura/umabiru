<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;

final class ShowSelfController extends Controller
{
    public function __construct(
        #[CurrentUser('sanctum')] private readonly User $user
    ) {
        $user->load([
            'image',
        ]);
    }

    public function __invoke()
    {
        return UserResource::make($this->user);
    }
}
