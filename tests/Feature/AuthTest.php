<?php

use App\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

describe('auth tests', function () {
    it('register user', function () {
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
});
