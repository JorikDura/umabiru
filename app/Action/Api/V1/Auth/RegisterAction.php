<?php

declare(strict_types=1);

namespace App\Action\Api\V1\Auth;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

final readonly class RegisterAction
{
    public function __construct(
        private RegisterRequest $request
    ) {}

    public function __invoke(): User
    {
        $user = User::create($this->request->validated());

        event(new Registered($user));

        return $user;
    }
}
