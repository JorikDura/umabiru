<?php

declare(strict_types=1);

use App\Models\Image;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

describe('image tests', function () {
    it('like image', function () {
        /** @var User $user */
        $user = User::factory()->create();

        $image = Image::factory()->create([
            'imageable_id' => $user->id,
            'imageable_type' => User::class,
        ]);

        actingAs($user)
            ->postJson(uri: "api/v1/images/$image->id/like")
            ->assertSuccessful()
            ->assertSee([
                'likes' => 1,
            ]);

        assertDatabaseHas(
            table: 'image_likes',
            data: [
                'user_id' => $user->id,
                'image_id' => $image->id,
            ]
        );
    });
});
