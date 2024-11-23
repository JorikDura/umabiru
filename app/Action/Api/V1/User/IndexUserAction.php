<?php

declare(strict_types=1);

namespace App\Action\Api\V1\User;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

final readonly class IndexUserAction
{
    /**
     * @return LengthAwarePaginator
     */
    public function __invoke(): LengthAwarePaginator
    {
        return QueryBuilder::for(User::class)
            ->allowedFilters(['name'])
            ->with(['image'])
            ->paginate(columns: [
                'id',
                'name',
                'username',
                'role',
                'gender',
                'created_at'
            ]);
    }
}
