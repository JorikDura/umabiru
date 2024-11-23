<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\User;

use App\Action\Api\V1\User\IndexUserAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class IndexUserController extends Controller
{
    /**
     * @param  IndexUserAction  $action
     * @return AnonymousResourceCollection
     */
    public function __invoke(IndexUserAction $action): AnonymousResourceCollection
    {
        $users = $action();

        return UserResource::collection($users);
    }
}