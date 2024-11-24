<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\User\Comment;

use App\Action\Api\V1\Comments\IndexCommentAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Throwable;

class IndexCommentController extends Controller
{
    /**
     * @param  User  $user
     * @param  IndexCommentAction  $action
     * @return AnonymousResourceCollection
     * @throws Throwable
     */
    public function __invoke(User $user, IndexCommentAction $action): AnonymousResourceCollection
    {
        $comments = $action($user);

        return CommentResource::collection($comments);
    }
}
