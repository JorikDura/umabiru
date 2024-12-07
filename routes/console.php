<?php

declare(strict_types=1);

use App\Console\Commands\DeleteNonVerifiedUsersCommand;
use Illuminate\Support\Facades\Schedule;

Schedule::command(DeleteNonVerifiedUsersCommand::class)->hourly();
