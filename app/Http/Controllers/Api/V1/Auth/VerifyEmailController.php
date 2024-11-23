<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Action\Api\V1\Auth\VerifyEmailAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class VerifyEmailController extends Controller
{
    /**
     * @param  VerifyEmailAction  $action
     * @return Response
     */
    public function __invoke(VerifyEmailAction $action): Response
    {
        $action();

        return response()->noContent();
    }
}
