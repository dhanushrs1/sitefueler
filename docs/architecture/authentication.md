# Identity & Authentication v1.0

**Status:** Accepted

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
- ⬜ GitHub / Microsoft / Apple (future — `social_accounts` schema already supports them)

## Pages (unified)

- `GET /login`, `POST /login` — one login page (marketing layout)
- `GET /register`, `POST /register` — public registration (always creates a **customer**)
- `POST /logout`
- `GET /auth/google/redirect`, `GET /auth/google/callback`

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

## Admin prefix

Configurable via `ADMIN_PREFIX` (`config('authentication.admin_prefix')`, default
`admin`). Routes are named `admin.*`, so views use `route('admin.*')` regardless
of the prefix.

## Security / audit

Each login records `last_login_at` and `last_login_ip` (extendable to full login
history). OAuth tokens are encrypted at rest. Cancelled consent and invalid
callbacks fail gracefully back to `/login`.

## Default admin (dev only)

`admin@sitefueler.test` / `password` (seeded). **Change before deployment.**

## Setup


```bash
php artisan migrate:fresh --seed
composer require laravel/socialite   # already installed
# add GOOGLE_CLIENT_ID / GOOGLE_CLIENT_SECRET to .env to enable Google
```

## Future (no redesign required)

2FA, passkeys, login history, connected accounts, active sessions, remember
devices, account deletion, email-change verification.
