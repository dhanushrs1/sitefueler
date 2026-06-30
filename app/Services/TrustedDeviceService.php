<?php

namespace App\Services;

use App\Models\User;
use App\Support\DeviceInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

/**
 * "Remember this device" — a signed, expiring token lets a known device skip
 * the 2FA challenge until it expires. Only the SHA-256 hash of the token is
 * stored; the raw token lives in an encrypted, http-only cookie.
 */
class TrustedDeviceService
{
    private function cookieName(): string
    {
        return config('authentication.trusted_devices.cookie', 'sf_trusted_device');
    }

    private function lifetimeDays(): int
    {
        return (int) config('authentication.trusted_devices.lifetime_days', 30);
    }

    /**
     * Record a trusted device for the user and queue the cookie on the response.
     */
    public function trust(User $user, Request $request): void
    {
        $token = Str::random(64);
        $info = DeviceInfo::parse($request->userAgent());
        $days = $this->lifetimeDays();

        $user->trustedDevices()->create([
            'token_hash' => $this->hash($token),
            'name' => DeviceInfo::label($request->userAgent()),
            'browser' => $info['browser'],
            'platform' => $info['platform'],
            'ip_address' => $request->ip(),
            'last_used_at' => now(),
            'expires_at' => now()->addDays($days),
        ]);

        Cookie::queue(Cookie::make(
            $this->cookieName(),
            $token,
            $days * 24 * 60,        // minutes
            httpOnly: true,
        ));
    }

    /**
     * Is the current request coming from a still-valid trusted device for this
     * user? Refreshes last_used_at when matched.
     */
    public function isTrusted(User $user, Request $request): bool
    {
        $token = $request->cookie($this->cookieName());

        if (! $token) {
            return false;
        }

        $device = $user->trustedDevices()
            ->where('token_hash', $this->hash($token))
            ->where('expires_at', '>', now())
            ->first();

        if (! $device) {
            return false;
        }

        $device->forceFill([
            'last_used_at' => now(),
            'ip_address' => $request->ip(),
        ])->save();

        return true;
    }

    /** Revoke a single trusted device. */
    public function revoke(User $user, int $deviceId): void
    {
        $user->trustedDevices()->whereKey($deviceId)->delete();
    }

    /** Revoke all trusted devices for the user. */
    public function revokeAll(User $user): void
    {
        $user->trustedDevices()->delete();
    }

    /** Forget the trusted-device cookie on the current browser. */
    public function forgetCookie(): void
    {
        Cookie::queue(Cookie::forget($this->cookieName()));
    }

    private function hash(string $token): string
    {
        return hash('sha256', $token);
    }
}
