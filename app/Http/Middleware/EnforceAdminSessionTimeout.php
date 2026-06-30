<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Admins get a shorter idle session than customers. We track last activity in
 * the session and sign the admin out after the configured idle window. The
 * global session lifetime still applies; this only tightens it for admins.
 */
class EnforceAdminSessionTimeout
{
    public const SESSION_KEY = 'admin_last_activity';

    public function handle(Request $request, Closure $next): Response
    {
        $idleMinutes = (int) config('authentication.admin_session_lifetime', 30);

        if ($idleMinutes > 0) {
            $last = $request->session()->get(self::SESSION_KEY);

            if ($last && (now()->getTimestamp() - $last) > ($idleMinutes * 60)) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->withErrors(['email' => 'Your admin session timed out. Please sign in again.']);
            }

            $request->session()->put(self::SESSION_KEY, now()->getTimestamp());
        }

        return $next($request);
    }
}
