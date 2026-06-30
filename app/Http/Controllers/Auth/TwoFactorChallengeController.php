<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\TrustedDeviceService;
use App\Services\TwoFactorService;
use App\Support\LoginAudit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

/**
 * Second-factor challenge shown after a correct password when the user has
 * confirmed 2FA and is not on a trusted device. Accepts a 6-digit TOTP code or
 * a one-time recovery code. Authentication is only completed here.
 */
class TwoFactorChallengeController extends Controller
{
    public function __construct(
        private TwoFactorService $twoFactor,
        private TrustedDeviceService $trustedDevices,
    ) {}

    public function show(Request $request): View|RedirectResponse
    {
        if (! $this->pendingUser($request)) {
            return redirect()->route('login');
        }

        return view('auth.two-factor.challenge');
    }

    public function verify(Request $request): RedirectResponse
    {
        $user = $this->pendingUser($request);

        if (! $user) {
            return redirect()->route('login');
        }

        $request->validate([
            'code' => ['required', 'string'],
        ]);

        $key = '2fa:'.$user->id.'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);

            return back()->withErrors([
                'code' => 'Too many attempts. Please try again in '.ceil($seconds / 60).' minute(s).',
            ]);
        }

        $input = trim((string) $request->input('code'));
        $isTotp = (bool) preg_match('/^\d{6}$/', preg_replace('/\s+/', '', $input));

        $passed = $isTotp
            ? $this->twoFactor->verifyCode($user, $input)
            : $this->twoFactor->consumeRecoveryCode($user, $input);

        if (! $passed) {
            RateLimiter::hit($key, 15 * 60);
            LoginAudit::record($user, $user->email, $request, false);

            return back()->withErrors(['code' => 'That code is invalid or has expired.']);
        }

        RateLimiter::clear($key);

        $remember = (bool) ($request->session()->get('two_factor.login.remember', false));
        $request->session()->forget('two_factor.login');

        LoginController::completeLogin($user, $request, $remember, markVerified: true);

        // Optionally remember this device to skip future challenges.
        if ($request->boolean('remember_device')) {
            $this->trustedDevices->trust($user, $request);
        }

        return redirect()->intended(LoginController::homeFor($user));
    }

    /**
     * The user awaiting a second factor (stashed at password step), if any.
     */
    private function pendingUser(Request $request): ?User
    {
        $id = $request->session()->get('two_factor.login.id');

        return $id ? User::find($id) : null;
    }
}
