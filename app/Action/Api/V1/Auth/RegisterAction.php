<?php

declare(strict_types=1);

namespace App\Action\Api\V1\Auth;

use App\Http\Requests\RegisterRequest;
use App\Models\User;

final readonly class RegisterAction
{
    public function __construct(
        private RegisterRequest $request
    ) {
    }

    public function __invoke(): User
    {
        return User::create($this->request->validated());
    }
}
