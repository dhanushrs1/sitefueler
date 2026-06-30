# Google Authentication Review

**Branch:** `feature/google-authentication`
**Status:** PASS ✅

Completes Google Sign-In on the v0.5.0 identity foundation: real credentials wired,
schema finalized to spec, account-linking via a dedicated service.

---

## Delivered / refined
- ✅ **Google credentials** added to `.env` (git-ignored) — `/auth/google/redirect`
  now redirects to `accounts.google.com` with `openid profile email` scopes.
- ✅ **Schema to spec**: `password` nullable (Google users → NULL); `roles.description`
  added (+ seeded); `social_accounts.provider_name` added.
- ✅ **`SocialAuthService`** encapsulates resolve/link/create:
  - provider exists → log in + refresh provider data
  - email exists → **link** to same user (no duplicate), role unchanged
  - no user → create **customer** (password NULL, avatar from provider)
- ✅ **Avatar priority** custom → Google → default (Google fills `users.avatar`
  only when empty; never overwrites a custom upload).
- ✅ **Scopes** limited to `openid`, `profile`, `email` (no contacts/drive/etc.).
- ✅ **Admin rule**: Google never creates/promotes an admin (always customer).
- ✅ **Graceful failures**: cancelled consent / invalid callback / no-email →
  back to `/login` with a message.
- ✅ **Login tracking** (`last_login_at`, `last_login_ip`) on every sign-in.

## Verified (runtime)
- `/auth/google/redirect` → 302 `accounts.google.com` with client_id + scopes
- Email/password login still works (admin → `/admin`)
- `migrate:fresh --seed` clean (nullable password change applied)
- No diagnostics on new PHP files

> Not verified end-to-end: the actual Google consent round-trip needs a real
> browser session against Google (interactive). The redirect, callback handler,
> linking logic, and graceful-failure paths are in place and unit-reviewable.

## Spec coverage (from the feature brief)
Phases 1–12 implemented. Phase 13 test matrix: email register/login/logout and
Google redirect verified here; the interactive Google scenarios (new account,
existing account, email↔Google link, cancel) should be exercised in a browser.

## Notes & decisions
- Kept the generic, multi-provider `SocialiteController` + `SocialAuthService`
  (scales to GitHub/Microsoft) rather than a Google-only controller — matches the
  brief's "future ready" goal.
- `provider_data` JSON stores the raw payload for forward-compatibility.

## Decision
**Approved.** Google Sign-In is wired and on-spec. Recommend a quick live browser
pass of the consent flow before relying on it.
