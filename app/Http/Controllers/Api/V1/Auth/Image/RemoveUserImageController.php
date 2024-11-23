<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth\Image;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\Response;

class RemoveUserImageController extends Controller
{
    public function __construct(
        #[CurrentUser('sanctum')] private User $user
    ) {
    }

    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        $this->user->deleteImage();

        return response()->noContent();
    }
}
