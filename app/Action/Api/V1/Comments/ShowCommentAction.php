<?php

declare(strict_types=1);

namespace App\Action\Api\V1\Comments;

use App\Exceptions\MissingMethodException;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

final readonly class ShowCommentAction
{
    /**
     * @param  Model  $model
     * @param  int  $commentId
     * @return Comment|Model
     * @throws Throwable
     */
    public function __invoke(Model $model, int $commentId): Comment|Model
    {
        if (!method_exists($model, 'comments')) {
            MissingMethodException::create($model::class, 'comments');
        }

        return QueryBuilder::for(Comment::class)
            ->allowedIncludes([
                'images',
                AllowedInclude::callback('user', static fn (BelongsTo $query) => $query->with(['image']))
            ])
            ->allowedSorts(['created_at'])
            ->select([
                'id',
                'user_id',
                'comment_id',
                'text',
                'created_at'
            ])
            ->findOrFail($commentId);
    }
}
