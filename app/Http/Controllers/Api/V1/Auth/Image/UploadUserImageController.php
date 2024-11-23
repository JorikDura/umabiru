<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth\Image;

use App\Action\Api\V1\Image\UploadImageAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\ImageResource;
use ReflectionException;

class UploadUserImageController extends Controller
{
    /**
     * @param  UploadImageAction  $action
     * @return void
     * @throws ReflectionException
     */
    public function __invoke(UploadImageAction $action)
    {
        $image = $action();

        return ImageResource::make($image);
    }
}
