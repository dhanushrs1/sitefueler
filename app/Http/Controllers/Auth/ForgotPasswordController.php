<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    public function show(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * UI-only for now: validates the email and shows a neutral confirmation.
     * (Real reset-link logic will be wired later.)
     */
    public function send(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        return back()->with(
            'status',
            "If an account exists for that email, we've sent a password reset link."
        );
    }
}
