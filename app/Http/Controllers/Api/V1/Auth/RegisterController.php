<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Action\Api\V1\Auth\CreateTokenAction;
use App\Action\Api\V1\Auth\RegisterAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\TokenResource;

final class RegisterController extends Controller
{
    public function __invoke(
        RegisterAction $registerAction,
        CreateTokenAction $createTokenAction
    ): TokenResource {
        $user = $registerAction();

        $token = $createTokenAction($user);

        return TokenResource::make($token);
    }
}
