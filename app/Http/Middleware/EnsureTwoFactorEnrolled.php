<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Force users whose role requires 2FA to finish the setup wizard before they
 * can reach any protected (admin) area. They cannot skip it.
 */
class EnsureTwoFactorEnrolled
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->requiresTwoFactor() && ! $user->hasConfirmedTwoFactor()) {
            return redirect()->route('two-factor.setup');
        }

        return $next($request);
    }
}
