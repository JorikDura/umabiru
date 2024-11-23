<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Action\Api\V1\Auth\ResendCodeVerificationAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class ResendCodeVerificationController extends Controller
{
    /**
     * Resends code for email verification
     * @param  ResendCodeVerificationAction  $action
     * @return Response
     */
    public function __invoke(ResendCodeVerificationAction $action): Response
    {
        $action();

        return response()->noContent();
    }
}