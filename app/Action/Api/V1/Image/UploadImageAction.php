<?php

declare(strict_types=1);

namespace App\Action\Api\V1\Image;

use App\Exceptions\MissingMethodException;
use App\Http\Requests\UploadImageRequest;
use App\Models\Image;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Database\Eloquent\Model;
use ReflectionException;

final readonly class UploadImageAction
{
    public function __construct(
        private UploadImageRequest $request,
        #[CurrentUser('sanctum')] private User $user
    ) {
    }

    /**
     * @param  ?Model  $model
     * @return Image
     * @throws ReflectionException
     */
    public function __invoke(?Model $model = null): Image
    {
        $model ??= $this->user;

        if (!method_exists($model, 'image') && !method_exists($model, 'deleteImage')) {
            MissingMethodException::create($model::class, 'comments');
        }

        $model->deleteImage();

        return Image::create(
            file: $this->request->validated('image'),
            model: $model,
            user: $this->user
        );
    }
}
