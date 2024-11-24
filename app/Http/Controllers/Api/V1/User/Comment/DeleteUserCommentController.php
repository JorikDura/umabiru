<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\User\Comment;

use App\Action\Api\V1\Comments\DeleteCommentAction;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Response;

class DeleteUserCommentController extends Controller
{
    /**
     * @param  User  $user
     * @param  Comment  $comment
     * @param  DeleteCommentAction  $action
     * @return Response
     */
    public function __invoke(
        User $user,
        Comment $comment,
        DeleteCommentAction $action
    ): Response {
        $action($comment);

        return response()->noContent();
    }
}
