<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Gender;
use App\Enums\Role;
use App\Notifications\VerificationCodeNotification;
use App\Traits\HasComments;
use App\Traits\HasImage;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

final class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;

    use HasComments;
    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use HasImage;
    use Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'gender',
        'role',
        'description',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerificationCodeNotification());
    }

    public function delete(): ?bool
    {
        $this->deleteImage();

        $this->deleteComments();

        return parent::delete();
    }

    public function isAdmin(): bool
    {
        return $this->role === Role::ADMIN;
    }

    public function isModerator(): bool
    {
        return $this->role === Role::MODERATOR;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array{
     *     email_verified_at: 'datetime',
     *     password: 'hashed',
     *     gender: 'App\Enums\Gender',
     *     role: 'App\Enums\Role'
     * }
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'gender' => Gender::class,
            'role' => Role::class,
        ];
    }
}
