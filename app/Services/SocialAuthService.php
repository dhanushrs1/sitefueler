<?php

namespace App\Services;

use App\Models\Role;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as SocialiteUser;

class SocialAuthService
{
    /**
     * Resolve (or create + link) the local user for an OAuth identity.
     *
     * Algorithm (docs/architecture/authentication.md §Account Linking):
     *   provider account exists?  → log in (refresh provider data)
     *   else email exists?        → link provider to that user (no new account)
     *   else                      → create a customer + link provider
     */
    public function resolveUser(string $provider, SocialiteUser $oauth): User
    {
        // 1) Already linked → that user.
        $social = SocialAccount::where('provider', $provider)
            ->where('provider_id', $oauth->getId())
            ->first();

        if ($social) {
            $user = $social->user;
            $this->refreshProviderData($social, $oauth);
            $this->applyDefaultAvatar($user, $oauth);

            return $user;
        }

        // 2) Existing email account → link (never create a duplicate).
        $user = User::where('email', $oauth->getEmail())->first();

        // 3) No user → create a customer (Google never creates an admin).
        if (! $user) {
            $user = User::create([
                'name' => $oauth->getName() ?: $oauth->getNickname() ?: 'Member',
                'email' => $oauth->getEmail(),
                'avatar' => $oauth->getAvatar(),       // default avatar from provider
                'role_id' => optional($this->customerRole())->id,
                'status' => 'active',
                'email_verified_at' => now(),
                'password' => null,                    // Google users have no password
            ]);
        } else {
            // Linking to an existing account: only fill avatar if none set yet.
            $this->applyDefaultAvatar($user, $oauth);
        }

        $this->linkAccount($user, $provider, $oauth);

        return $user;
    }

    protected function linkAccount(User $user, string $provider, SocialiteUser $oauth): SocialAccount
    {
        $social = new SocialAccount([
            'provider' => $provider,
            'provider_id' => $oauth->getId(),
            'provider_email' => $oauth->getEmail(),
            'provider_name' => $oauth->getName(),
            'provider_avatar' => $oauth->getAvatar(),
            'provider_data' => (array) ($oauth->user ?? []),
            'access_token' => $oauth->token ?? null,
            'refresh_token' => $oauth->refreshToken ?? null,
        ]);

        $user->socialAccounts()->save($social);

        return $social;
    }

    protected function refreshProviderData(SocialAccount $social, SocialiteUser $oauth): void
    {
        $social->forceFill([
            'provider_email' => $oauth->getEmail(),
            'provider_name' => $oauth->getName(),
            'provider_avatar' => $oauth->getAvatar(),
            'provider_data' => (array) ($oauth->user ?? []),
            'access_token' => $oauth->token ?? $social->access_token,
            'refresh_token' => $oauth->refreshToken ?? $social->refresh_token,
        ])->save();
    }

    /**
     * Avatar priority: custom upload > Google > default.
     * Only set the provider avatar when the user has no avatar yet, so a
     * custom upload is never overwritten by Google.
     */
    protected function applyDefaultAvatar(User $user, SocialiteUser $oauth): void
    {
        if (empty($user->avatar) && $oauth->getAvatar()) {
            $user->forceFill(['avatar' => $oauth->getAvatar()])->save();
        }
    }

    protected function customerRole(): ?Role
    {
        return Role::where('slug', config('authentication.default_role', 'customer'))->first();
    }
}
