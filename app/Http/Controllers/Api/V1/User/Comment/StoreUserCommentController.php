<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\User\Comment;

use App\Action\Api\V1\Comments\StoreCommentAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\User;
use Throwable;

final class StoreUserCommentController extends Controller
{
    /**
     * @throws Throwable
     */
    public function __invoke(User $user, StoreCommentAction $action): CommentResource
    {
        $comment = $action($user);

        return CommentResource::make($comment);
    }
}
