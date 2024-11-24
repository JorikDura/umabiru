<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Image;

use App\Action\Api\V1\Like\LikeAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\LikeResource;
use App\Models\Image;

class LikeImageController extends Controller
{
    /**
     * @param  Image  $image
     * @param  LikeAction  $action
     * @return LikeResource
     */
    public function __invoke(Image $image, LikeAction $action): LikeResource
    {
        $likeCount = $action($image);

        return LikeResource::make($likeCount);
    }
}
