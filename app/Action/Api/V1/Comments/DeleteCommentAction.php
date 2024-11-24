<?php

declare(strict_types=1);

namespace App\Action\Api\V1\Comments;

use App\Models\Comment;

final readonly class DeleteCommentAction
{
    public function __invoke(Comment $comment): void
    {
        $comment->delete();
    }
}
