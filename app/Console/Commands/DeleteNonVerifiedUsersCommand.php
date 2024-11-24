<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class DeleteNonVerifiedUsersCommand extends Command
{
    protected $signature = 'delete:non-verified-users';

    protected $description = 'Command description';

    public function handle(): void
    {
        User::where('email_verified_at', null)
            ->where('updated_at', '<', now()->subDay())
            ->get()
            ->each(function (User $user) {
                $user->delete();
            });
    }
}