<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Safety net for protected areas: a user whose role requires 2FA and who has
 * completed setup must have passed the second factor in the current session.
 *
 * The normal login flow already guarantees this (a confirmed-2FA user is sent
 * to the challenge before authentication completes). If we ever reach here
 * authenticated but unverified — e.g. a stale session — we sign out and send
 * them back through a fresh login + challenge.
 */
class EnsureTwoFactorVerified
{
    public const SESSION_KEY = 'two_factor_verified';

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user
            && $user->requiresTwoFactor()
            && $user->hasConfirmedTwoFactor()
            && ! $request->session()->get(self::SESSION_KEY)
        ) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors(['email' => 'Please sign in again to verify your identity.']);
        }

        return $next($request);
    }
}
