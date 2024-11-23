<?php

namespace App\Models;

use App\Enum\Gender;
use App\Enum\Role;
use App\Notifications\VerificationCodeNotification;
use App\Traits\HasComments;
use App\Traits\HasImage;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use Notifiable;
    use HasApiTokens;
    use HasImage;
    use HasComments;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'gender',
        'role',
        'description'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'gender' => Gender::class,
            'role' => Role::class
        ];
    }

    /**
     * @return void
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerificationCodeNotification());
    }

    /**
     * @return ?bool
     */
    public function delete(): ?bool
    {
        $this->deleteImage();

        $this->deleteComments();

        return parent::delete();
    }
}
