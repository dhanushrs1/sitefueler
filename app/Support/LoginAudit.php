<?php

namespace App\Support;

use App\Models\LoginHistory;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Append-only audit log of authentication attempts (successful and failed).
 */
class LoginAudit
{
    public static function record(?User $user, ?string $email, Request $request, bool $successful): void
    {
        $info = DeviceInfo::parse($request->userAgent());

        LoginHistory::create([
            'user_id' => $user?->id,
            'email' => $email,
            'ip_address' => $request->ip(),
            'browser' => $info['browser'],
            'device' => $info['device'],
            'successful' => $successful,
        ]);
    }
}
