<?php

declare(strict_types=1);

namespace App\Action\Api\V1\Auth;

use App\Http\Requests\VerifyEmailRequest;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

final readonly class VerifyEmailAction
{
    public function __construct(
        private VerifyEmailRequest $request,
        #[CurrentUser('sanctum')] private User $user
    ) {
    }

    /**
     * Verify user email
     * @return void
     */
    public function __invoke(): void
    {
        abort_if(
            boolean: $this->user->hasVerifiedEmail(),
            code: Response::HTTP_BAD_REQUEST,
            message: "You already verified your email address."
        );

        /** @var int $userCode */
        $userCode = $this->request->validated('code');

        /** @var int $trueCode */
        $trueCode = Cache::get("email-{$this->user->id}");

        abort_if(
            boolean: $userCode !== $trueCode,
            code: Response::HTTP_BAD_REQUEST,
            message: "Wrong verification code."
        );

        $this->user->markEmailAsVerified();
    }
}
