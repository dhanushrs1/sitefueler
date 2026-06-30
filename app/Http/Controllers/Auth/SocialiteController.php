<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\SocialAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class SocialiteController extends Controller
{
    /** Providers SiteFueler supports today. */
    private const SUPPORTED = ['google'];

    public function __construct(private SocialAuthService $social)
    {
    }

    /**
     * Redirect to the OAuth provider. Scopes: openid, profile, email only.
     */
    public function redirect(string $provider): RedirectResponse
    {
        abort_unless(in_array($provider, self::SUPPORTED, true), 404);

        if (! config("services.{$provider}.client_id")) {
            return redirect()->route('login')
                ->withErrors(['email' => ucfirst($provider) . ' sign-in is not configured yet.']);
        }

        return Socialite::driver($provider)
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }

    /**
     * Handle the OAuth callback: log in, link, or create a customer.
     */
    public function callback(string $provider, Request $request): RedirectResponse
    {
        abort_unless(in_array($provider, self::SUPPORTED, true), 404);

        try {
            $oauth = Socialite::driver($provider)->user();
        } catch (Throwable $e) {
            // Includes the user cancelling consent or an invalid callback.
            return redirect()->route('login')
                ->withErrors(['email' => 'Could not sign in with ' . ucfirst($provider) . '. Please try again.']);
        }

        if (! $oauth->getEmail()) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Your ' . ucfirst($provider) . ' account did not share an email address.']);
        }

        $user = $this->social->resolveUser($provider, $oauth);

        if (in_array($user->status, ['banned', 'suspended'], true)) {
            return redirect()->route('login')
                ->withErrors(['email' => 'This account is not active.']);
        }

        Auth::login($user, true);
        $request->session()->regenerate();
        LoginController::recordLogin($user, $request);

        return redirect()->intended(LoginController::homeFor($user));
    }
}
