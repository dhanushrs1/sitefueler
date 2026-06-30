<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class SocialiteController extends Controller
{
    /**
     * Redirect to the OAuth provider (currently Google).
     */
    public function redirect(string $provider): RedirectResponse
    {
        abort_unless($provider === 'google', 404);

        if (! config("services.{$provider}.client_id")) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Google sign-in is not configured yet.']);
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle the OAuth callback: log in an existing user or create a customer.
     */
    public function callback(string $provider, Request $request): RedirectResponse
    {
        abort_unless($provider === 'google', 404);

        try {
            $oauth = Socialite::driver($provider)->user();
        } catch (Throwable $e) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Could not sign in with Google. Please try again.']);
        }

        // 1) Existing social account → log in.
        $social = SocialAccount::where('provider', $provider)
            ->where('provider_id', $oauth->getId())
            ->first();

        if ($social) {
            $user = $social->user;
        } else {
            // 2) Match an existing user by email, else create a customer.
            $user = User::where('email', $oauth->getEmail())->first();

            if (! $user) {
                $customer = Role::where('slug', config('authentication.default_role', 'customer'))->first();
                $user = User::create([
                    'name' => $oauth->getName() ?: $oauth->getNickname() ?: 'Member',
                    'email' => $oauth->getEmail(),
                    'avatar' => $oauth->getAvatar(),         // default avatar from provider
                    'role_id' => $customer?->id,
                    'status' => 'active',
                    'email_verified_at' => now(),
                    'password' => Str::random(40), // unusable; user signs in via Google
                ]);
            }

            $social = new SocialAccount([
                'provider' => $provider,
                'provider_id' => $oauth->getId(),
                'provider_email' => $oauth->getEmail(),
                'provider_avatar' => $oauth->getAvatar(),
                'provider_data' => (array) ($oauth->user ?? []),
                'access_token' => $oauth->token ?? null,
                'refresh_token' => $oauth->refreshToken ?? null,
            ]);
            $user->socialAccounts()->save($social);
        }

        Auth::login($user, true);
        $request->session()->regenerate();
        LoginController::recordLogin($user, $request);

        return redirect()->intended(LoginController::homeFor($user));
    }
}
