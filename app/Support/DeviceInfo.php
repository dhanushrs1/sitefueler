<?php

namespace App\Support;

/**
 * Tiny, dependency-free User-Agent parser.
 *
 * Good enough for security display ("Chrome on Windows 11") and device naming.
 * Not meant to be exhaustive — we deliberately avoid a heavy UA package.
 */
class DeviceInfo
{
    public static function parse(?string $userAgent): array
    {
        $ua = (string) $userAgent;

        return [
            'browser' => self::browser($ua),
            'platform' => self::platform($ua),
            'device' => self::device($ua),
        ];
    }

    /** A friendly label like "Chrome on Windows". */
    public static function label(?string $userAgent): string
    {
        $info = self::parse($userAgent);

        $browser = $info['browser'] ?: 'Unknown browser';
        $platform = $info['platform'] ?: 'Unknown OS';

        return "{$browser} on {$platform}";
    }

    protected static function browser(string $ua): ?string
    {
        return match (true) {
            str_contains($ua, 'Edg/') => 'Edge',
            str_contains($ua, 'OPR/') || str_contains($ua, 'Opera') => 'Opera',
            str_contains($ua, 'Firefox/') => 'Firefox',
            str_contains($ua, 'Chrome/') && ! str_contains($ua, 'Chromium') => 'Chrome',
            str_contains($ua, 'Safari/') && str_contains($ua, 'Version/') => 'Safari',
            default => null,
        };
    }

    protected static function platform(string $ua): ?string
    {
        return match (true) {
            str_contains($ua, 'Windows NT 10.0') => 'Windows',
            str_contains($ua, 'Windows') => 'Windows',
            str_contains($ua, 'Android') => 'Android',
            str_contains($ua, 'iPhone') || str_contains($ua, 'iPad') => 'iOS',
            str_contains($ua, 'Mac OS X') || str_contains($ua, 'Macintosh') => 'macOS',
            str_contains($ua, 'Linux') => 'Linux',
            default => null,
        };
    }

    protected static function device(string $ua): string
    {
        return match (true) {
            str_contains($ua, 'Mobile') || str_contains($ua, 'iPhone') || str_contains($ua, 'Android') => 'Mobile',
            str_contains($ua, 'iPad') || str_contains($ua, 'Tablet') => 'Tablet',
            default => 'Desktop',
        };
    }
}
