<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\User\Comment\Like;

use App\Action\Api\V1\Like\LikeAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\LikeResource;
use App\Models\Comment;
use App\Models\User;

class LikeCommentController extends Controller
{
    public function __invoke(
        User $user,
        Comment $comment,
        LikeAction $action
    ) {
        $likesCount = $action($comment);

        return LikeResource::make($likesCount);
    }
}
