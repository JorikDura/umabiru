<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\User\Comment;

use App\Action\Api\V1\Comments\DeleteCommentAction;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Response;

final class DeleteUserCommentController extends Controller
{
    public function __invoke(
        User $user,
        Comment $comment,
        DeleteCommentAction $action
    ): Response {
        $action($comment);

        return response()->noContent();
    }
}
