<?php

use App\Models\User;
use App\Notifications\VerificationCodeNotification;
use Illuminate\Support\Facades\Notification;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

describe('auth tests', function () {
    it('register user', function () {
        Notification::fake();

        /** @var User $user */
        $user = User::factory()->make();

        postJson(
            uri: "api/v1/auth/register",
            data: $user->toArray() + [
                'password' => $password = fake()->password(minLength: 8),
                'password_confirmation' => $password
            ]
        )->assertSuccessful()->assertSee(['token']);

        assertDatabaseHas(
            table: 'users',
            data: [
                'email' => $user->email,
                'name' => $user->name,
                'username' => $user->username
            ]
        );

        /** @var User $user */
        $user = User::where([
            'email' => $user->email,
            'name' => $user->name,
            'username' => $user->username
        ])->get();

        Notification::assertSentTo($user, VerificationCodeNotification::class);
    });

    it('login user', function () {
        /** @var User $user */
        $user = User::factory()->create([
            'password' => $password = fake()->password(minLength: 8)
        ]);

        postJson(
            uri: "api/v1/auth/login",
            data: [
                'email' => $user->email,
                'password' => $password
            ]
        )->assertSuccessful()->assertSee(['token']);
    });

    it('resend code', function () {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        Notification::fake();

        actingAs($user)
            ->postJson(
                uri: "api/v1/auth/email/resend"
            )->assertSuccessful()->assertNoContent();

        Notification::assertSentTo($user, VerificationCodeNotification::class);
    });
});
