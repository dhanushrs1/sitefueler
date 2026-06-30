# Changelog

All notable changes to SiteFueler are documented here.
This project follows [Semantic Versioning](https://semver.org/).

## [Unreleased]

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
