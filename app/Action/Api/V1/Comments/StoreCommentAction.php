<?php

declare(strict_types=1);

namespace App\Action\Api\V1\Comments;

use App\Exceptions\MissingMethodException;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Image;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Throwable;

final readonly class StoreCommentAction
{
    public function __construct(
        private StoreCommentRequest $request,
        #[CurrentUser('sanctum')] private User $user
    ) {}

    /**
     * @throws Throwable
     */
    public function __invoke(Model $model): Comment
    {
        if (! method_exists($model, 'comments')) {
            MissingMethodException::create($model::class, 'comments');
        }

        return DB::transaction(function () use ($model) {
            $comment = $model->comments()->create([
                'user_id' => $this->user->id,
                'comment_id' => $this->request->validated('comment_id'),
                'text' => $this->request->validated('text'),
                'commentable_id' => $model->getKey(),
                'commentable_type' => $model::class,
            ]);

            $this->request->whenHas('images', function () use ($comment) {
                Image::insert(
                    files: $this->request->validated('images'),
                    model: $comment,
                    user: $this->user
                );
            });

            return $comment;
        });
    }
}
