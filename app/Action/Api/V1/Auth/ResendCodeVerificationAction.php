<?php

declare(strict_types=1);

namespace App\Action\Api\V1\Auth;

use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

final readonly class ResendCodeVerificationAction
{
    public function __construct(
        #[CurrentUser('sanctum')] private User $user
    ) {}

    public function __invoke(): void
    {
        abort_if(
            boolean: $this->user->hasVerifiedEmail(),
            code: Response::HTTP_BAD_REQUEST,
            message: 'You already verified your email address.'
        );

        Cache::forget("email-{$this->user->id}");

        $this->user->sendEmailVerificationNotification();
    }
}
