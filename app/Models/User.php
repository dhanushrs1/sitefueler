<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'uuid',
        'role_id',
        'name',
        'username',
        'email',
        'avatar',
        'status',
        'password',
        'last_login_at',
        'last_login_ip',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (User $user) {
            if (empty($user->uuid)) {
                $user->uuid = (string) Str::uuid();
            }
        });
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function socialAccounts(): HasMany
    {
        return $this->hasMany(SocialAccount::class);
    }

    /**
     * Does the user have any of the given role slugs?
     */
    public function hasRole(string|array $slugs): bool
    {
        $slugs = (array) $slugs;

        return $this->role && in_array($this->role->slug, $slugs, true);
    }

    /**
     * Is the user an admin (any configured admin role)?
     */
    public function isAdmin(): bool
    {
        return $this->hasRole(config('authentication.admin_roles', ['admin', 'super-admin']));
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
