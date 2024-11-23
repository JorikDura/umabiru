<?php

declare(strict_types=1);

namespace App\Action\Api\V1\User;

use App\Models\User;

final readonly class ShowUserAction
{
    /**
     * @param  int  $userId
     * @return User
     */
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
                    'description'
                ]
            );
    }
}
