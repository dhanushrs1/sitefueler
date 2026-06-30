# Identity & Authentication Review

**Feature:** Identity system (Milestone 5)
**Branch:** `feature/identity`
**Status:** PASS ✅

Unified identity for everyone — one login/register page, roles instead of an
`is_admin` flag, `social_accounts` for OAuth, Google sign-in, configurable admin
prefix, login tracking. Replaces the standalone admin login.

---

## Delivered
- ✅ **Unified `/login`** on the marketing layout (header + footer), "Welcome Back",
  email/password, Forgot Password, **Continue with Google**, link to Register
- ✅ **`/register`** — public sign-up, always creates a **customer**
- ✅ **Roles** (`customer`, `admin`, `editor`, `support`, `super-admin`) replace
  `is_admin`; `role:<slugs>` middleware (`EnsureUserHasRole`)
- ✅ **social_accounts** table (provider, ids, `provider_data` JSON, encrypted
  tokens) — multi-provider ready
- ✅ **Google sign-in** (Socialite): existing-account login, email match, or new
  customer; stores social account + default avatar; degrades gracefully w/o creds
- ✅ **users** expanded: `uuid` (route key), `role_id`, `username`, `avatar`,
  `status`, `last_login_at`, `last_login_ip`
- ✅ **Configurable admin prefix** (`ADMIN_PREFIX`); routes named `admin.*`
- ✅ **One session**; role-based redirect (admin → `/admin`, customer → `/dashboard`)
- ✅ **Login tracking** (last login time + IP)
- ✅ Auth-aware header + drawer (guest: Login/Get Started; user: avatar menu with
  Go to Admin / Dashboard / Logout)
- ✅ Customer dashboard placeholder

## Verified (runtime)
- `/login` → 200, marketing layout, Google button present
- Admin login → redirect `/admin`; `/admin` (admin) → 200
- Register → customer → redirect `/dashboard` → 200
- Customer → `/admin` → **403**; guest → `/admin` → **302 /login**
- `/auth/google/redirect` without creds → **302 /login** (graceful)
- `migrate:fresh --seed` clean; `auth.css` serves 200

## Cleanup (removed unwanted files)
- `resources/views/admin/auth/login.blade.php`
- `app/Http/Controllers/Admin/AuthController.php`
- `app/Http/Middleware/EnsureUserIsAdmin.php`
- `add_is_admin_to_users_table` migration
- `.admin-auth*` styles in admin.css

## Notes & decisions
- Single `users` table + `roles` (not a separate guard) — one identity, one session.
- Google users get a random unusable password (column is NOT NULL); they sign in
  via Google. `provider_data` keeps the raw payload for forward-compat.
- Real Google login requires `GOOGLE_CLIENT_ID`/`SECRET` in `.env` (documented).
- Verified via served HTML/CSS + curl flows, not a live browser.

## Decision
**Approved.** Scalable identity foundation; providers, permissions, and account
features can be added later without redesign.
