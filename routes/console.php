<?php

use App\Console\Commands\DeleteNonVerifiedUsersCommand;
use Illuminate\Support\Facades\Schedule;

Schedule::command(DeleteNonVerifiedUsersCommand::class)->hourly();
