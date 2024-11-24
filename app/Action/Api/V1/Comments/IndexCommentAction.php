<?php

declare(strict_types=1);

namespace App\Action\Api\V1\Comments;

use App\Exceptions\MissingMethodException;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

final readonly class IndexCommentAction
{
    /**
     * @param  Model  $model
     * @return LengthAwarePaginator
     * @throws Throwable
     */
    public function __invoke(Model $model): LengthAwarePaginator
    {
        if (!method_exists($model, 'comments')) {
            MissingMethodException::create($model::class, 'comments');
        }

        return QueryBuilder::for(Comment::class)
            ->allowedIncludes([
                'images',
                AllowedInclude::callback('user', fn (BelongsTo $query) => $query->with('image')),
            ])
            ->select([
                'id',
                'user_id',
                'comment_id',
                'text',
                'created_at'
            ])
            ->where([
                'commentable_id' => $model->getKey(),
                'commentable_type' => $model::class
            ])
            ->orderByDesc('created_at')
            ->paginate()
            ->appends(request()->query());
    }
}
