<?php

declare(strict_types=1);

namespace App\Action\Api\V1\Comments;

use App\Exceptions\MissingMethodException;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

final readonly class ShowCommentAction
{
    public function __construct(
        #[CurrentUser('sanctum')] private ?User $user
    ) {
    }

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
            ->selectSub(
                query: fn (Builder $query) => $query->selectRaw('count(*)')
                    ->from('comment_likes')
                    ->whereRaw('"comment_likes"."comment_id" = "comments"."id"'),
                as: 'likes_count'
            )
            ->when(
                value: !is_null($this->user?->id),
                callback: fn (EloquentBuilder $query) => $query->selectSub(
                    query: fn (Builder $query) => $query
                        ->selectRaw('case count(*) when 0 then false else true end')
                        ->from('comment_likes')
                        ->whereRaw(
                            sql: '"comment_likes"."comment_id" = "comments"."id" AND "comment_likes"."user_id" = ?',
                            bindings: [$this->user->id]
                        ),
                    as: 'is_liked'
                )
            )
            ->findOrFail($commentId);
    }
}
