<?php

use App\Models\User;

use function Pest\Laravel\getJson;

describe('users test', function () {
    beforeEach(function () {
        $this->users = User::factory(15)->create();
    });

    it('get users', function () {
        /** @var User $user */
        $user = $this->users->random();

        getJson(uri: "api/v1/users")
            ->assertSuccessful()->assertSee([
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'gender' => $user->gender,
                'role' => $user->role
            ]);
    });

    it('search users', function () {
        /** @var User $user */
        $user = $this->users->random();

        getJson(uri: "api/v1/users?filter[username]=$user->username")
            ->assertSuccessful()->assertSee([
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'gender' => $user->gender,
                'role' => $user->role
            ]);
    });

    it('get user via id', function () {
        /** @var User $user */
        $user = $this->users->random();

        getJson(uri: "api/v1/users/$user->id")
            ->assertSuccessful()
            ->assertSee([
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'gender' => $user->gender,
                'role' => $user->role
            ]);
    });
});
