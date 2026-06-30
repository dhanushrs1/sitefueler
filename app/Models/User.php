<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
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
        'two_factor_enabled',
        'two_factor_confirmed_at',
        'last_login_at',
        'last_login_ip',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'two_factor_enabled' => 'boolean',
            'two_factor_confirmed_at' => 'datetime',
            'two_factor_secret' => 'encrypted',
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

    public function twoFactorRecoveries(): HasMany
    {
        return $this->hasMany(TwoFactorRecovery::class);
    }

    public function trustedDevices(): HasMany
    {
        return $this->hasMany(TrustedDevice::class);
    }

    public function loginHistory(): HasMany
    {
        return $this->hasMany(LoginHistory::class);
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

    /**
     * Is two-factor authentication mandatory for this user's role?
     */
    public function requiresTwoFactor(): bool
    {
        return $this->hasRole(config('authentication.two_factor.required_roles', ['admin', 'super-admin']));
    }

    /**
     * Has the user finished 2FA setup (verified their first code)?
     */
    public function hasConfirmedTwoFactor(): bool
    {
        return $this->two_factor_enabled && ! is_null($this->two_factor_confirmed_at);
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
