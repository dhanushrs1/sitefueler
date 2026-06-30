<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TrustedDeviceService;
use App\Services\TwoFactorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Admin "Security" settings: 2FA status, recovery-code regeneration, trusted
 * device management, and the recent login history (audit trail).
 */
class SecurityController extends Controller
{
    public function __construct(
        private TwoFactorService $twoFactor,
        private TrustedDeviceService $trustedDevices,
    ) {}

    public function index(Request $request): View
    {
        $user = $request->user();

        return view('admin.security.index', [
            'user' => $user,
            'recoveryCount' => $this->twoFactor->unusedRecoveryCount($user),
            'devices' => $user->trustedDevices()->latest('last_used_at')->get(),
            'logins' => $user->loginHistory()->latest()->limit(20)->get(),
            'newRecoveryCodes' => $request->session()->get('recovery_codes'),
        ]);
    }

    public function regenerateRecoveryCodes(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (! $user->hasConfirmedTwoFactor()) {
            return back()->withErrors(['recovery' => 'Set up two-factor authentication first.']);
        }

        $codes = $this->twoFactor->generateRecoveryCodes($user);

        return back()
            ->with('status', 'New recovery codes generated. Save them now — the old codes no longer work.')
            ->with('recovery_codes', $codes->all());
    }

    public function revokeDevice(Request $request, int $device): RedirectResponse
    {
        $this->trustedDevices->revoke($request->user(), $device);

        return back()->with('status', 'Trusted device removed.');
    }

    public function revokeAllDevices(Request $request): RedirectResponse
    {
        $this->trustedDevices->revokeAll($request->user());

        return back()->with('status', 'All trusted devices removed.');
    }
}
