<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\SocialAuthService;
use Composer\CaBundle\CaBundle;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class SocialiteController extends Controller
{
    /** Providers SiteFueler supports today. */
    private const SUPPORTED = ['google'];

    public function __construct(private SocialAuthService $social) {}

    /**
     * Build the provider with an HTTP client that uses a known CA bundle, so
     * the server-side token exchange verifies SSL correctly on any host
     * (fixes cURL error 60 on Windows/XAMPP where no CA bundle is configured).
     */
    private function provider(string $name)
    {
        return Socialite::driver($name)->setHttpClient(new Client([
            'verify' => CaBundle::getSystemCaRootBundlePath(),
            'timeout' => 15,
        ]));
    }

    /**
     * Redirect to the OAuth provider. Scopes: openid, profile, email only.
     */
    public function redirect(string $provider, Request $request): RedirectResponse
    {
        abort_unless(in_array($provider, self::SUPPORTED, true), 404);

        if (! config("services.{$provider}.client_id")) {
            return redirect()->route('login')
                ->withErrors(['email' => ucfirst($provider).' sign-in is not configured yet.']);
        }

        // Remember whether the flow was opened in a popup window.
        $request->session()->put('oauth_popup', $request->boolean('popup'));

        return $this->provider($provider)
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }

    /**
     * Handle the OAuth callback: log in, link, or create a customer.
     */
    public function callback(string $provider, Request $request)
    {
        abort_unless(in_array($provider, self::SUPPORTED, true), 404);

        $popup = (bool) $request->session()->pull('oauth_popup', false);

        try {
            $oauth = $this->provider($provider)->user();
        } catch (Throwable $e) {
            Log::error('OAuth callback failed', [
                'provider' => $provider,
                'message' => $e->getMessage(),
            ]);

            return $this->fail($request, $popup, 'Could not sign in with '.ucfirst($provider).'. Please try again.');
        }

        if (! $oauth->getEmail()) {
            return $this->fail($request, $popup, 'Your '.ucfirst($provider).' account did not share an email address.');
        }

        $user = $this->social->resolveUser($provider, $oauth);

        if (in_array($user->status, ['banned', 'suspended'], true)) {
            return $this->fail($request, $popup, 'This account is not active.');
        }

        // Confirmed-2FA users must pass the challenge (unless on a trusted device).
        if (LoginController::needsTwoFactorChallenge($user, $request)) {
            LoginController::stashPendingLogin($request, $user, true);

            return $this->finish($request, $popup, route('two-factor.challenge'));
        }

        $markVerified = ! $user->requiresTwoFactor();
        LoginController::completeLogin($user, $request, true, $markVerified);

        // Required-but-not-enrolled users are forced into the setup wizard.
        $target = ($user->requiresTwoFactor() && ! $user->hasConfirmedTwoFactor())
            ? route('two-factor.setup')
            : LoginController::homeFor($user);

        return $this->finish($request, $popup, $target);
    }

    /**
     * Success response — popup posts the redirect to its opener; otherwise a
     * normal (intended-aware) redirect.
     */
    private function finish(Request $request, bool $popup, string $target)
    {
        return $popup
            ? view('auth.oauth-popup', ['payload' => ['status' => 'success', 'redirect' => $target]])
            : redirect()->intended($target);
    }

    /**
     * Failure response — popup posts an error to the opener (which navigates to
     * /login where the flashed error shows); otherwise a normal redirect.
     */
    private function fail(Request $request, bool $popup, string $message)
    {
        if (! $popup) {
            return redirect()->route('login')->withErrors(['email' => $message]);
        }

        // Flash the error so the opener's /login shows it.
        $bag = new ViewErrorBag;
        $bag->put('default', new MessageBag(['email' => [$message]]));
        $request->session()->flash('errors', $bag);

        return view('auth.oauth-popup', ['payload' => ['status' => 'error', 'redirect' => route('login')]]);
    }
}
