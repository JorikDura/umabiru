<?php

use App\Enums\Role;
use App\Models\Comment;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
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

    it('get user comments', function () {
        /** @var User $user */
        $user = $this->users->random();

        $comments = Comment::factory(3)->create([
            'commentable_id' => $user->id,
            'commentable_type' => User::class
        ]);

        /** @var Comment $comment */
        $comment = $comments->random();

        getJson(uri: "api/v1/users/$user->id/comments")
            ->assertSuccessful()->assertSee([
                'id' => $comment->id,
                'text' => $comment->text
            ]);
    });

    it('get comments via id', function () {
        /** @var User $user */
        $user = $this->users->random();

        $comments = Comment::factory(3)->create([
            'commentable_id' => $user->id,
            'commentable_type' => User::class
        ]);

        /** @var Comment $comment */
        $comment = $comments->random();

        getJson(uri: "api/v1/users/$user->id/comments/$comment->id")
            ->assertSuccessful()->assertSee([
                'id' => $comment->id,
                'text' => $comment->text
            ]);
    });

    it('store user comment', function () {
        /** @var User $user */
        $user = $this->users->random();

        $comment = Comment::factory()->make([
            'commentable_id' => $user->id,
            'commentable_type' => User::class
        ]);

        actingAs($user)
            ->postJson(
                uri: "api/v1/users/$user->id/comments",
                data: $comment->toArray()
            )
            ->assertSuccessful()
            ->assertSee([
                'text' => $comment->text
            ]);

        assertDatabaseHas(
            table: 'comments',
            data: [
                'text' => $comment->text,
                'commentable_id' => $comment->commentable_id,
                'commentable_type' => $comment->commentable_type
            ]
        );
    });

    it('delete own comment', function () {
        /** @var User $user */
        $user = $this->users->random();

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'commentable_id' => $user->id,
            'commentable_type' => User::class
        ]);

        actingAs($user)
            ->deleteJson(uri: "api/v1/users/$user->id/comments/$comment->id")
            ->assertSuccessful()
            ->assertNoContent();

        assertDatabaseMissing(
            table: 'comments',
            data: $comment->toArray()
        );
    });

    it('delete another user comment', function () {
        /** @var User $user */
        $user = $this->users->random();

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'commentable_id' => $user->id,
            'commentable_type' => User::class
        ]);

        $newUser = User::factory()->create();

        actingAs($newUser)
            ->deleteJson(uri: "api/v1/users/$user->id/comments/$comment->id")
            ->assertForbidden();
    });

    it('admin deletes another user comment', function () {
        $user = $this->users->random();

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'commentable_id' => $user->id,
            'commentable_type' => User::class
        ]);

        $newAdmin = User::factory()->create([
            'role' => Role::ADMIN
        ]);

        actingAs($newAdmin)
            ->deleteJson(uri: "api/v1/users/$user->id/comments/$comment->id")
            ->assertSuccessful()
            ->assertNoContent();

        assertDatabaseMissing(
            table: 'comments',
            data: $comment->toArray()
        );
    });
});
