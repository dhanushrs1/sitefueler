# Changelog

All notable changes to SiteFueler are documented here.
This project follows [Semantic Versioning](https://semver.org/).

## [Unreleased]

## [0.6.0] — Account Security & 2FA

### Added
- **Two-factor authentication (TOTP)** — mandatory for staff roles (`admin`,
  `super-admin`, `editor`, `support`). Works with any standard authenticator app
  (Google / Microsoft Authenticator, Authy, 1Password, Bitwarden). New users in
  these roles are forced through a **setup wizard** (QR + first-code verify) and
  cannot reach the admin panel until `two_factor_confirmed_at` is set.
- **Recovery codes** — 10 single-use, hashed codes shown once at setup and
  regenerable from the admin **Security** page.
- **Trusted devices** — "remember this device for 30 days" (signed, expiring,
  http-only cookie; SHA-256 hash stored) lets a known device skip the challenge.
  Listed and revocable from the Security page.
- **Login history** — append-only audit trail of every attempt (success/failure)
  with IP, browser, and device, surfaced on the Security page.
- **Admin Security page** (`/{admin}/security`) — 2FA status, recovery-code
  regeneration, trusted-device management, recent sign-in activity.
- New middleware: `2fa.enrolled`, `2fa.verified`, `admin.timeout`.
- Services `TwoFactorService` / `TrustedDeviceService`; helpers `PasswordRules`,
  `DeviceInfo`, `LoginAudit`. Deps `pragmarx/google2fa`, `bacon/bacon-qr-code`.

### Changed
- **Login flow** now validates credentials without logging in when 2FA is
  required, completing authentication only after the second factor passes. Google
  sign-in funnels staff through the same challenge/enrollment (no OAuth bypass).
- **Login throttling** — failed attempts rate-limited per email+IP (customers
  5/15 min, admins 5/30 min); the 2FA challenge is limited to 5/15 min.
- **Role-aware password policy** — customers min 8; admins min 12 with mixed
  case, number, symbol, and a compromised-password check.
- **Shorter admin idle session** (`ADMIN_SESSION_LIFETIME`, default 30 min).
- `docs/architecture/authentication.md` updated to **v1.1**.

### Fixed
- **Login `RuntimeException`** ("This password does not use the Bcrypt algorithm")
  caused by a stale `$2a$` bcrypt hash on the seeded admin that this PHP build's
  `password_get_info()` reports as `unknown`. Re-seeding regenerates with `$2y$`
  so Laravel's `BcryptHasher::check()` accepts it.

## [0.5.2] — Google OAuth Fix

### Fixed
- **Google sign-in failing with "Could not sign in"** — root cause was cURL error
  60 (SSL: unable to get local issuer certificate) during the server-side token
  exchange, because PHP had no CA bundle. Added `composer/ca-bundle` and pointed
  Socialite's HTTP client at it (SSL is still verified, no php.ini changes).
- The OAuth callback now **logs the real exception** for future diagnosis.

### Changed
- **Google sign-in opens in a popup window** (not the full tab/page); falls back
  to a full-page redirect if the popup is blocked. Success/errors post back to the
  opener via `postMessage`.

## [0.5.1] — Auth Polish & Google Sign-In

### Added
- **Google Sign-In** fully wired (Socialite): `openid/profile/email` scopes,
  `SocialAuthService` for resolve/link/create, account linking by email (no
  duplicates), customer-only role, graceful cancel/invalid handling.
- **Forgot password** page (`/forgot-password`) — UI (email + send reset link).
- `roles.description`, `social_accounts.provider_name`; nullable `users.password`
  for Google users.

### Changed
- **Auth UI overhaul** — floating-label fields, premium multicolor Google button,
  refined typography/copy across login / register / forgot; full marketing footer
  retained; fields/buttons sized to 48px.
- Reviews `docs/reviews/0014`–`0015`; `docs/architecture/authentication.md` frozen
  as the identity source of truth.

## [0.5.0] — Identity & Authentication

Milestone 5. One identity system (frontend + customer + admin), roles, OAuth, and
a unified login page. Replaces the standalone admin login and the `is_admin` flag.

### Added
- **Unified `/login`** (marketing layout) and **`/register`** — email/password +
  **Continue with Google** (Socialite).
- **Roles** (`customer`, `admin`, `editor`, `support`, `super-admin`) + `role:`
  middleware (`EnsureUserHasRole`); role-based post-login redirect.
- **`social_accounts`** table (provider data JSON, encrypted tokens) — multi-provider.
- **users** expanded: `uuid` (route key), `role_id`, `username`, `avatar`,
  `status`, `last_login_at`, `last_login_ip`.
- **Configurable admin prefix** (`ADMIN_PREFIX`); `config/authentication.php`.
- Auth-aware header/drawer; customer `/dashboard` placeholder.
- `RoleSeeder`; `docs/architecture/authentication.md`; review
  `docs/reviews/0013-identity-review.md`.

### Removed
- Standalone admin login view, admin `AuthController`, `EnsureUserIsAdmin`
  middleware, `is_admin` migration, and unused `.admin-auth` styles.

## [0.4.0] — Admin Foundation

Milestone 4. The admin shell — authentication, layout, and navigation framework
that future business modules plug into. No business modules yet.

### Added
- **Admin authentication** — email/password login, admin-only (`is_admin`),
  logout, route protection via `auth` + `admin` (`EnsureUserIsAdmin`) middleware;
  guests redirect to `admin.login`.
- **Admin shell** — layout, config-driven sidebar (off-canvas on mobile), topbar
  with notifications + profile dropdowns, breadcrumb, and a six-card dashboard.
- **Profile** page (update name/email).
- Grouped, **named** admin routes (`admin.`) ready for `Route::resource` modules.
- `is_admin` migration, `AdminUserSeeder`, `config/admin.php`, `x-admin.icon`.
- Admin assets under `public/assets/admin/` (admin.css, admin.js).
- Architecture doc `docs/architecture/authentication.md`; review
  `docs/reviews/0012-admin-foundation-review.md`.

### Fixed
- Assets behind a proxy/tunnel (ngrok): trust forwarded headers so `asset()`/`url()`
  generate correct `https://<host>/…` URLs (no more unstyled tunnelled pages).

## [0.3.1] — Shell & Button Polish

### Added
- **Navigation submenus** — desktop dropdowns for Templates / Plugins / Services
  (hover + focus, CSS-only); accordion submenus in the off-canvas drawer (native
  `<details>`); reusable `x-social-links` component.
- **Drawer enhancements** — fuller menu set (`config/navigation.drawer`, adds
  Pricing/Documentation/About), pinned footer with CTAs + **social follow** row,
  and a smoother slide easing.
- **Header cart icon** — stroked Lucide `shopping-cart` link, visible at all sizes.
- Reusable `x-logo` component + `components/logo.css`.

### Changed
- **Site font → Instrument Sans** (site-wide) via Bunny Fonts; weight tokens
  clamped to 400–700.
- **Header redesign** — clean, slim (navbar 80 → 64px), SVG wordmark logo,
  left-aligned light-weight nav, no search.
- **Mobile navigation → right-side off-canvas drawer** (slide in/out, X / backdrop /
  Escape, scroll-locked, focus-managed).
- **Footer redesign** — overlapping brand-gradient CTA card (quote form on the
  Form System) + dark three-column footer (Best Selling / Useful Links) + bottom bar.
- **Button polish** — subtle **top-only inset shadow** on all buttons; filled
  variants (Primary/Danger) gain a darker **border** for a defined edge on light
  backgrounds; filled buttons keep **white** text on hover (fixed the orange
  Get Started hover).
- Reviews `docs/reviews/0009`–`0011`; release notes `docs/releases/v0.3.1.md`.

## [0.3.0] — Layout Components (Application Shell)

Milestone 3. The application shell and layout components, composed from the
Milestone 2 components.

### Added
- **Application shell** — `layouts/app` (base) + `layouts/marketing` (Header →
  Main → Footer); `auth`/`dashboard`/`error` layout placeholders.
- **Header** — sticky, config-driven navigation, search, Login/Get Started
  buttons, mobile hamburger panel (`components/header/*`, `header.css`).
- **Navigation config** — `config/navigation.php` (primary, footer, legal).
- **Search Bar** — reusable component built on the Form System.
- **Footer** — dark three-column footer composing config links + Button.
- **Breadcrumb**, **Page Title**, **Empty State** layout components.
- **404 page** (`errors/404.blade.php`) on the error layout.
- Split CSS: `breadcrumb.css`, `page-title.css`, `empty-state.css`, plus
  `header.css`/`footer.css`.
- Application Shell review (`docs/reviews/0008-application-shell-review.md`).

### Changed
- Marketing pages now extend `layouts.marketing`.
- Removed the old `partials/header` and `partials/footer` (replaced by components).
- Added the **Visual QA** step to the workflow (`CONTRIBUTING.md`).

## [0.2.1] — UI Refinements

### Changed
- **Reduced corner radius** for a more professional, less pill-like look:
  `--radius-sm` 12 → 6px, `--radius-md` 16 → 10px, `--radius-lg` 24 → 14px.
  Propagates to buttons, inputs, alerts, cards, tables, and modals via tokens.
- **Tighter, minimalist button scale:** default `--button-height` 48 → 40px;
  sizes are now Small 32 / Medium 40 / Large 48 with reduced padding and 14px
  text on Small/Medium (16px on Large).
- Synced specs: `design-system.md` §5, `button.md` §4, and the radius rows in
  form/alert/card/modal specs.

## [0.2.0] — Core UI Components

Milestone 2. Seven token-based, accessible, reusable components built via the
Specification → Implementation → Review → Merge lifecycle.

### Added
- **Button** — single parameter-driven component (`components/button.blade.php`):
  four variants, three sizes, six states, icon support (left / right / icon-only).
- **Form System** — shared `field` wrapper plus `input`, `textarea`, `select`,
  `checkbox`, `radio`, `switch`; validation states, label/hint/error, prefix/suffix
  icons, and `group` layouts (single / two-column / inline).
- **Badge** — five fixed variants (New, Sale, Best Seller, Featured, Out of Stock),
  pill shape, optional icon, default labels.
- **Alert** — four semantic variants with soft tints, default icons, optional
  title/actions/dismiss; assertive/polite `role` by severity; dismiss via app.js.
- **Card** — one base card (media 4:3 + badge overlay, body, footer) with
  Product/Service/Blog variants and interactive whole-card link.
- **Table** — single admin/data table style with selection/actions/status,
  hover & selected rows, empty and loading states.
- **Modal** — native `<dialog>` based; sizes, confirmation/form variants, focus
  trap, Escape, backdrop click, scroll lock, 200ms transitions.
- Component review records `docs/reviews/0001`–`0007`.
- Split component CSS under `public/assets/css/components/` aggregated by
  `components.css`.

### Changed
- Button Blade strategy: per-variant files replaced by one parameter-driven
  component (the blueprint reused by Badge, Alert, Card).

### Changed
- Button Blade strategy: replaced per-variant files with one reusable, parameter-
  driven component (variant/size/href/block/iconOnly/loading/disabled + icon slots).

## [0.1.0] — Foundation Release

- Laravel project setup, project architecture, folder structure
- Design system (`docs/design-system.md`) incl. semantic colors + soft tints
- Component specifications (nine specs in `docs/components/`)
- CSS foundation (variables, layout, utilities; tokens-first architecture)
- Milestone-based roadmap; proprietary license
- Git workflow (`main` + `feature/*`), Conventional Commits, Definition of Done
- Architecture Decision Records (`docs/meetings/`) and release notes (`docs/releases/`)
