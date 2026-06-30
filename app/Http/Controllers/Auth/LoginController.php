<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        $user = Auth::user();

        if ($user->status === 'banned' || $user->status === 'suspended') {
            Auth::logout();
            return back()->withErrors(['email' => 'This account is not active.'])->onlyInput('email');
        }

        $request->session()->regenerate();
        self::recordLogin($user, $request);

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
     * Record login metadata for audit/security.
     */
    public static function recordLogin($user, Request $request): void
    {
        $user->forceFill([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
        ])->saveQuietly();
    }
}
