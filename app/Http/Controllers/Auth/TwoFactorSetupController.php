<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Middleware\EnsureTwoFactorVerified;
use App\Services\TwoFactorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Mandatory 2FA setup wizard. Users whose role requires 2FA are forced here
 * (by the 'two-factor.setup' redirect + EnsureTwoFactorEnrolled middleware)
 * until they scan the QR, verify their first code, and save recovery codes.
 * They cannot skip it.
 */
class TwoFactorSetupController extends Controller
{
    public function __construct(private TwoFactorService $twoFactor) {}

    public function show(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if ($user->hasConfirmedTwoFactor()) {
            return redirect(LoginController::homeFor($user));
        }

        // Create a pending secret on first visit (reused if they return).
        if (empty($user->two_factor_secret)) {
            $user->forceFill(['two_factor_secret' => $this->twoFactor->generateSecret()])->save();
        }

        return view('auth.two-factor.setup', [
            'qrSvg' => $this->twoFactor->qrCodeSvg($user, $user->two_factor_secret),
            'secret' => $user->two_factor_secret,
        ]);
    }

    public function confirm(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasConfirmedTwoFactor()) {
            return redirect(LoginController::homeFor($user));
        }

        $request->validate(['code' => ['required', 'string']]);

        if (! $this->twoFactor->verifyCode($user, (string) $request->input('code'))) {
            return back()->withErrors(['code' => 'That code is incorrect. Make sure your device clock is accurate and try again.']);
        }

        $this->twoFactor->confirm($user);
        $codes = $this->twoFactor->generateRecoveryCodes($user);

        // They just proved possession — verify this session.
        $request->session()->put(EnsureTwoFactorVerified::SESSION_KEY, true);

        // Show the codes exactly once.
        $request->session()->flash('recovery_codes', $codes->all());

        return redirect()->route('two-factor.recovery-codes');
    }

    public function recoveryCodes(Request $request): View|RedirectResponse
    {
        $codes = $request->session()->get('recovery_codes');

        if (! $codes) {
            return redirect(LoginController::homeFor($request->user()));
        }

        return view('auth.two-factor.recovery-codes', [
            'codes' => $codes,
            'continueUrl' => LoginController::homeFor($request->user()),
        ]);
    }
}
