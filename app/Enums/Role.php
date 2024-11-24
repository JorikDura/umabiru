<?php

declare(strict_types=1);

namespace App\Enums;

enum Role: string
{
    case MODERATOR = 'moderator';
    case ADMIN = 'admin';
    case USER = 'user';
}
