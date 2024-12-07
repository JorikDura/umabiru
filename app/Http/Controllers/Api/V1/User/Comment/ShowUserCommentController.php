<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\User\Comment;

use App\Action\Api\V1\Comments\ShowCommentAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\User;
use Throwable;

final class ShowUserCommentController extends Controller
{
    /**
     * @throws Throwable
     */
    public function __invoke(
        User $user,
        int $commentId,
        ShowCommentAction $action
    ): CommentResource {
        $comments = $action($user, $commentId);

        return CommentResource::make($comments);
    }
}
