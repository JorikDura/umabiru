<?php

declare(strict_types=1);

namespace App\Action\Api\V1\User;

use App\Models\User;

final readonly class ShowUserAction
{
    public function __invoke(int $userId): User
    {
        return User::with(['image'])
            ->findOrFail(
                id: $userId,
                columns: [
                    'id',
                    'name',
                    'role',
                    'gender',
                    'username',
                    'created_at',
                    'description',
                ]
            );
    }
}
