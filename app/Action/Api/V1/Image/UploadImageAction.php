<?php

declare(strict_types=1);

namespace App\Action\Api\V1\Image;

use App\Http\Requests\UploadImageRequest;
use App\Models\Image;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Database\Eloquent\Model;
use Log;
use ReflectionException;
use Symfony\Component\HttpFoundation\Response;

final readonly class UploadImageAction
{
    private const string ERROR_MESSAGE = "There's no image method in %s model.";

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

        if (!method_exists($model, 'image')) {
            Log::error(sprintf(self::ERROR_MESSAGE, $model::class));
            abort(Response::HTTP_CONFLICT);
        }

        $model->deleteImage();

        return Image::create(
            file: $this->request->validated('image'),
            model: $model,
            user: $this->user
        );
    }
}
