<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Action\Api\V1\Auth\CreateTokenAction;
use App\Action\Api\V1\Auth\LoginAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\TokenResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    /**
     * @param  LoginAction  $loginAction
     * @param  CreateTokenAction  $createTokenAction
     * @return TokenResource|JsonResponse
     */
    public function __invoke(
        LoginAction $loginAction,
        CreateTokenAction $createTokenAction
    ): TokenResource|JsonResponse {
        $user = $loginAction();

        if (is_null($user)) {
            return response()->json(
                data: [
                    'message' => 'These credentials do not match our records.'
                ],
                status: Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $token = $createTokenAction($user);

        return TokenResource::make($token);
    }
}
