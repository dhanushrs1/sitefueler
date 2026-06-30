<?php

namespace App\Services;

use App\Models\User;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;

/**
 * Standard TOTP (RFC 6238) two-factor authentication.
 *
 * Works with any authenticator app (Google / Microsoft Authenticator, Authy,
 * 1Password, Bitwarden, ...). Secrets are stored encrypted on the user; recovery
 * codes are stored hashed and are single-use.
 */
class TwoFactorService
{
    public function __construct(private Google2FA $engine) {}

    /** Generate a new base32 TOTP secret. */
    public function generateSecret(): string
    {
        return $this->engine->generateSecretKey();
    }

    /** The otpauth:// URI for the given user + secret. */
    public function otpauthUri(User $user, string $secret): string
    {
        return $this->engine->getQRCodeUrl(
            config('authentication.two_factor.issuer', config('app.name', 'SiteFueler')),
            $user->email,
            $secret
        );
    }

    /** Render the otpauth URI as an inline SVG QR code. */
    public function qrCodeSvg(User $user, string $secret, int $size = 220): string
    {
        $renderer = new ImageRenderer(
            new RendererStyle($size, 1),
            new SvgImageBackEnd
        );

        return (new Writer($renderer))->writeString($this->otpauthUri($user, $secret));
    }

    /** Verify a 6-digit TOTP code against the user's secret. */
    public function verifyCode(User $user, string $code): bool
    {
        if (empty($user->two_factor_secret)) {
            return false;
        }

        $window = (int) config('authentication.two_factor.window', 1);

        return (bool) $this->engine->verifyKey($user->two_factor_secret, $this->normalize($code), $window);
    }

    /**
     * Generate, store (hashed), and return a fresh set of plaintext recovery
     * codes. Replaces any existing codes.
     */
    public function generateRecoveryCodes(User $user): Collection
    {
        $user->twoFactorRecoveries()->delete();

        $count = (int) config('authentication.two_factor.recovery_code_count', 10);

        return collect(range(1, $count))->map(function () use ($user) {
            $code = $this->formatRecoveryCode();

            $user->twoFactorRecoveries()->create([
                'code_hash' => Hash::make($code),
            ]);

            return $code;
        });
    }

    /**
     * Consume a recovery code if it matches an unused one. Returns true on success
     * and marks that code used.
     */
    public function consumeRecoveryCode(User $user, string $input): bool
    {
        $input = strtoupper(trim($input));

        foreach ($user->twoFactorRecoveries()->whereNull('used_at')->get() as $recovery) {
            if (Hash::check($input, $recovery->code_hash)) {
                $recovery->forceFill(['used_at' => now()])->save();

                return true;
            }
        }

        return false;
    }

    public function unusedRecoveryCount(User $user): int
    {
        return $user->twoFactorRecoveries()->whereNull('used_at')->count();
    }

    /** Mark setup complete after the first code is verified. */
    public function confirm(User $user): void
    {
        $user->forceFill([
            'two_factor_enabled' => true,
            'two_factor_confirmed_at' => now(),
        ])->save();
    }

    /** Fully disable 2FA and wipe secrets/recovery codes. */
    public function disable(User $user): void
    {
        $user->twoFactorRecoveries()->delete();
        $user->forceFill([
            'two_factor_secret' => null,
            'two_factor_enabled' => false,
            'two_factor_confirmed_at' => null,
        ])->save();
    }

    private function normalize(string $code): string
    {
        return preg_replace('/\D/', '', $code) ?? '';
    }

    private function formatRecoveryCode(): string
    {
        return strtoupper(Str::random(4).'-'.Str::random(4));
    }
}
