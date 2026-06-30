<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Middleware\EnforceAdminSessionTimeout;
use App\Http\Middleware\EnsureTwoFactorVerified;
use App\Models\User;
use App\Services\TrustedDeviceService;
use App\Support\LoginAudit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function show(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect(self::homeFor(Auth::user()));
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $email = Str::lower($credentials['email']);
        $user = User::where('email', $email)->first();
        $tier = $user && $user->isAdmin() ? 'admin' : 'customer';
        [$maxAttempts, $decayMinutes] = $this->throttlePolicy($tier);
        $key = $this->throttleKey($email, $request);

        // Locked out?
        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            LoginAudit::record($user, $email, $request, false);

            return back()->withErrors([
                'email' => 'Too many login attempts. Please try again in '.ceil($seconds / 60).' minute(s).',
            ])->onlyInput('email');
        }

        // Wrong credentials.
        if (! Auth::validate($credentials)) {
            RateLimiter::hit($key, $decayMinutes * 60);
            LoginAudit::record($user, $email, $request, false);

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        RateLimiter::clear($key);
        $user = Auth::getLastAttempted();

        // Inactive accounts cannot sign in even with correct credentials.
        if (in_array($user->status, ['banned', 'suspended'], true)) {
            LoginAudit::record($user, $email, $request, false);

            return back()->withErrors(['email' => 'This account is not active.'])->onlyInput('email');
        }

        $remember = $request->boolean('remember');

        // Confirmed-2FA users: skip only on a trusted device, else challenge.
        if (self::needsTwoFactorChallenge($user, $request)) {
            self::stashPendingLogin($request, $user, $remember);

            return redirect()->route('two-factor.challenge');
        }

        // Either no 2FA, or 2FA required but not yet set up (forced into the
        // setup wizard by the 'two-factor.setup' redirect below + middleware).
        $markVerified = ! $user->requiresTwoFactor();
        self::completeLogin($user, $request, $remember, $markVerified);

        if ($user->requiresTwoFactor() && ! $user->hasConfirmedTwoFactor()) {
            return redirect()->route('two-factor.setup');
        }

        return redirect()->intended(self::homeFor($user));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Where to send a user after authentication, based on role.
     */
    public static function homeFor($user): string
    {
        return $user->isAdmin()
            ? route('admin.dashboard')
            : route('dashboard');
    }

    /**
     * Does this user need to pass a 2FA challenge for this request? True when
     * 2FA is required + confirmed and the request is NOT from a trusted device.
     */
    public static function needsTwoFactorChallenge(User $user, Request $request): bool
    {
        if (! $user->requiresTwoFactor() || ! $user->hasConfirmedTwoFactor()) {
            return false;
        }

        return ! app(TrustedDeviceService::class)->isTrusted($user, $request);
    }

    /**
     * Stash the pending (not-yet-authenticated) login for the challenge step.
     */
    public static function stashPendingLogin(Request $request, User $user, bool $remember): void
    {
        $request->session()->put('two_factor.login', [
            'id' => $user->id,
            'remember' => $remember,
        ]);
    }

    /**
     * Finalize an authenticated session: log in, regenerate, set security flags,
     * and write audit metadata.
     */
    public static function completeLogin(User $user, Request $request, bool $remember, bool $markVerified): void
    {
        Auth::login($user, $remember);
        $request->session()->regenerate();

        if ($markVerified) {
            $request->session()->put(EnsureTwoFactorVerified::SESSION_KEY, true);
        }

        if ($user->isAdmin()) {
            $request->session()->put(EnforceAdminSessionTimeout::SESSION_KEY, now()->getTimestamp());
        }

        self::recordLogin($user, $request);
        LoginAudit::record($user, $user->email, $request, true);
    }

    /**
     * Record login metadata for audit/security.
     */
    public static function recordLogin($user, Request $request): void
    {
        $user->forceFill([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
        ])->saveQuietly();
    }

    private function throttlePolicy(string $tier): array
    {
        $policy = config("authentication.throttle.{$tier}", ['max_attempts' => 5, 'decay_minutes' => 15]);

        return [$policy['max_attempts'], $policy['decay_minutes']];
    }

    private function throttleKey(string $email, Request $request): string
    {
        return 'login:'.Str::transliterate($email).'|'.$request->ip();
    }
}
