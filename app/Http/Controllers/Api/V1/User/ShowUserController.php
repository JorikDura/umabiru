<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\User;

use App\Action\Api\V1\User\ShowUserAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class ShowUserController extends Controller
{
    /**
     * @param  int  $userId
     * @param  ShowUserAction  $action
     * @return UserResource
     */
    public function __invoke(int $userId, ShowUserAction $action): UserResource
    {
        $user = $action($userId);

        return UserResource::make($user);
    }
}
