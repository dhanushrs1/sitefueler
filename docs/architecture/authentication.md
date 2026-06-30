# Identity & Authentication v1.1

**Status:** Accepted

> **v1.1 adds** mandatory TOTP two-factor authentication for staff roles,
> trusted devices, recovery codes, a login audit trail, login throttling, a
> role-aware password policy, and a shorter admin idle-session timeout.

One identity system for everyone — frontend, customer, and admin. **Roles** decide
access; there is **one session**, not separate admin/customer sessions.

```
Email Login ─┐
Google Login ─┼─→ Authentication → User Account → Roles & Permissions → {Frontend, Customer, Admin}
Future OAuth ─┘
```

## Login methods

- ✅ Email + Password
- ✅ Google Sign-In (Socialite)
- ✅ Two-Factor (TOTP) — mandatory for staff roles (see below)
- ⬜ GitHub / Microsoft / Apple (future — `social_accounts` schema already supports them)

## Pages (unified)

- `GET /login`, `POST /login` — one login page (marketing layout)
- `GET /register`, `POST /register` — public registration (always creates a **customer**)
- `POST /logout`
- `GET /auth/google/redirect`, `GET /auth/google/callback`
- `GET|POST /two-factor/challenge` — second-factor prompt (pre-authentication)
- `GET|POST /two-factor/setup`, `GET /two-factor/recovery-codes` — enrollment wizard
- Admin **Security** page (`/{admin}/security`) — 2FA status, recovery codes,
  trusted devices, login history

There is **no separate admin login** — admins sign in at `/login` and are routed
to the admin area by role.

## Roles

Seeded by `RoleSeeder`: `customer`, `admin`, `editor`, `support`, `super-admin`.
A user has one `role_id`. Helpers: `$user->hasRole([...])`, `$user->isAdmin()`.
Public registration and Google sign-up always assign **customer**. Admins are only
created by existing admins (no public path).

## Authorization

- `auth` middleware protects authenticated areas.
- `role:<slugs>` middleware (`EnsureUserHasRole`) gates the admin area
  (`role:admin,super-admin`, from `config('authentication.admin_roles')`).
- Unauthenticated requests redirect to `/login`.

## Database

**users** (added): `uuid`, `role_id`, `username`, `avatar`, `status`
(`pending|active|suspended|banned`), `last_login_at`, `last_login_ip`.
The numeric `id` stays internal; `uuid` is the public reference (route key).

**roles**: `id`, `name`, `slug`.

**social_accounts**: `user_id`, `provider`, `provider_id`, `provider_email`,
`provider_avatar`, `provider_data` (JSON — raw payload for forward-compat),
`access_token`/`refresh_token` (encrypted), `token_expires_at`. Unique on
`(provider, provider_id)`. Keeping OAuth data here (not on `users`) lets a user
connect multiple providers without schema changes.

**users** (2FA, added in v1.1): `two_factor_secret` (encrypted), `two_factor_enabled`,
`two_factor_confirmed_at`.

**two_factor_recoveries**: `user_id`, `code_hash` (hashed), `used_at` (single-use).

**trusted_devices**: `user_id`, `token_hash` (SHA-256, unique), `name`, `browser`,
`platform`, `ip_address`, `last_used_at`, `expires_at`.

**login_history**: `user_id` (nullable), `email`, `ip_address`, `browser`, `device`,
`location` (reserved), `successful`, `created_at`. Append-only audit trail.

## Google sign-in flow

```
Continue with Google → Google → social account exists?
  yes → log in (refresh provider data)
  no  → email exists?
          yes → link provider to that user (no duplicate account)
          no  → create customer + link provider
        → log in
```

Resolution lives in `App\Services\SocialAuthService` (used by
`Auth\SocialiteController`); routes are provider-agnostic
(`/auth/{provider}/redirect|callback`) so GitHub/Microsoft/Apple add without
redesign.

**Scopes (Google):** `openid`, `profile`, `email` only. SiteFueler never requests
contacts, calendar, drive, gmail, location, etc.

**Account linking:** an existing email account + Google sign-in with the same
email links to the **same** user (one account, never two). Linking does not
change the user's role.

**Avatar priority:** custom upload → Google → default. `provider_avatar` is stored
on the social account and copied to `users.avatar` **only when the user has no
avatar yet**, so a custom upload is never overwritten by Google.

**Password strategy:** email users have a hashed password; Google-created users
have `password = NULL` (column is nullable) and can set one later in settings to
enable both methods.

**Admin rule:** Google sign-in always yields a **customer** and never creates or
promotes an admin. Admins are promoted internally only.

## Two-factor authentication (TOTP)

Standard **TOTP (RFC 6238)** — works with any authenticator app (Google /
Microsoft Authenticator, Authy, 1Password, Bitwarden, …). Not tied to any single
vendor.

**Mandatory for staff.** Roles in
`config('authentication.two_factor.required_roles')` (`admin`, `super-admin`,
`editor`, `support`) **must** complete 2FA setup before they can reach the admin
panel. Customers are not required to use 2FA (optional, later).

### First login (forced enrollment)

```
Email + password OK → role requires 2FA → not yet configured
  → forced setup wizard (cannot skip):
      scan QR  →  enter first code  →  verified
      → generate + show recovery codes (once)
      → two_factor_confirmed_at set → admin dashboard
```

An account is only marked `two_factor_confirmed_at` **after** the first code is
verified, so a staff member can never reach the admin interface with 2FA in a
half-configured state. Enforced by the `2fa.enrolled` middleware
(`EnsureTwoFactorEnrolled`) — it redirects unconfirmed staff to
`two-factor.setup`.

### Every login afterwards (challenge)

```
Email + password OK → 2FA confirmed → trusted device?
  yes → straight in (challenge skipped)
  no  → 6-digit code (or recovery code) → verified → dashboard
```

Credentials are checked **without** logging the user in; the pending login is
stashed in the session and authentication is only completed once the second
factor passes (`TwoFactorChallengeController`). Google sign-in funnels staff
through the same challenge/enrollment, so OAuth cannot bypass 2FA.

### Storage

- `users.two_factor_secret` — **encrypted** (Eloquent `encrypted` cast), nullable.
- `users.two_factor_enabled`, `users.two_factor_confirmed_at`.
- `two_factor_recoveries` — one row per recovery code, **hashed** (`code_hash`),
  single-use (`used_at`). ~10 codes generated; regenerable from the Security page.

`App\Services\TwoFactorService` owns secret generation, QR rendering
(`bacon/bacon-qr-code`), TOTP verification (`pragmarx/google2fa`), and recovery
codes.

## Trusted devices

"Remember this device for 30 days" issues a random token: the SHA-256 hash is
stored in `trusted_devices` and the raw token lives in an encrypted, http-only
cookie (`sf_trusted_device`). A valid, unexpired token lets a device skip the
challenge. Devices are listed and individually (or fully) revocable from the
admin **Security** page. Managed by `App\Services\TrustedDeviceService`.

## Login throttling

Failed attempts are rate-limited per `email + IP` (`Illuminate\…\RateLimiter`):
customers 5 attempts / 15 min, admins 5 / 30 min
(`config('authentication.throttle')`). The 2FA challenge is independently limited
to 5 attempts per 15 min.

## Password policy

Role-aware (`App\Support\PasswordRules`, `config('authentication.passwords')`):

- **Customer:** min 8 characters (the `Password::defaults()` baseline).
- **Admin:** min 12, mixed case, number, symbol, and an `uncompromised()`
  (HaveIBeenPwned) check.

## Admin prefix

Configurable via `ADMIN_PREFIX` (`config('authentication.admin_prefix')`, default
`admin`). Routes are named `admin.*`, so views use `route('admin.*')` regardless
of the prefix.

## Security / audit

- **Login history** — every attempt (success and failure) is recorded in
  `login_history` (user, email, IP, browser, device, result, time) and shown on
  the admin **Security** page. UA parsing is a tiny dependency-free helper
  (`App\Support\DeviceInfo`); `location` is reserved for future geo-IP.
- **Session hardening** — on each successful login the session ID and CSRF token
  are regenerated and `last_login_at` / `last_login_ip` recorded.
- **Admin idle timeout** — admins get a shorter idle session
  (`ADMIN_SESSION_LIFETIME`, default 30 min) via the `admin.timeout` middleware,
  on top of the global session lifetime.
- OAuth tokens are encrypted at rest. Cancelled consent and invalid callbacks
  fail gracefully back to `/login`.

### Admin middleware stack

```
auth → role:<admin roles> → 2fa.enrolled → 2fa.verified → admin.timeout
```

Each middleware has a single responsibility.

## Default admin (dev only)

`admin@sitefueler.test` / `password` (seeded). On first sign-in this account is
forced through 2FA setup. **Change the password before deployment.**

## Setup

```bash
php artisan migrate:fresh --seed
composer require laravel/socialite pragmarx/google2fa bacon/bacon-qr-code  # already installed
# add GOOGLE_CLIENT_ID / GOOGLE_CLIENT_SECRET to .env to enable Google
```

## Future (no redesign required)

Optional customer 2FA, passkeys/WebAuthn, new-device email alerts, geo-IP on the
login history, connected accounts, active session listing, account deletion,
email-change verification.
