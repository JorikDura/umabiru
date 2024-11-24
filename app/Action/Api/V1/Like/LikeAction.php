<?php

declare(strict_types=1);

namespace App\Action\Api\V1\Like;

use App\Exceptions\MissingMethodException;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Database\Eloquent\Model;

final readonly class LikeAction
{
    public function __construct(
        #[CurrentUser] private User $user
    ) {
    }

    public function __invoke(Model $model): int
    {
        if (!method_exists($model, 'likes')) {
            MissingMethodException::create($model::class, 'likes');
        }

        $model->likes()->toggle($this->user);

        return $model->likes()->count();
    }
}
