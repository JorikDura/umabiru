<?php

declare(strict_types=1);

namespace App\Action\Api\V1\Auth;

use App\Http\Requests\LoginRequest;
use App\Models\User;

final readonly class LoginAction
{
    public function __construct(
        private LoginRequest $request
    ) {}

    public function __invoke(): ?User
    {
        auth()->attempt($this->request->validated());

        return auth()->user();
    }
}
