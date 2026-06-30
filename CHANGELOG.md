# Changelog

All notable changes to SiteFueler are documented here.
This project follows [Semantic Versioning](https://semver.org/).

## [Unreleased]

### Changed
- **Site font → Instrument Sans** (site-wide) via Bunny Fonts; `--font-family-base`
  updated and weight tokens clamped to 400–700. Docs synced.
- **Header cart icon** — stroked Lucide `shopping-cart` link, visible at all sizes.
- **Mobile navigation → right-side off-canvas drawer** — slides in/out, closes via
  X / backdrop / Escape, scroll-locked, focus-managed (replaces the dropdown panel).
- **Footer redesign** — overlapping brand-gradient **CTA card** (quote form built
  on the Form System) + dark three-column footer (Best Selling / Useful Links) +
  copyright/legal bar; footer link config updated.
- Shell v2 review (`docs/reviews/0010-shell-v2-review.md`).

### Changed (earlier, same cycle)
- Header redesign — clean, slim, Laravel-style: SVG wordmark logo (`x-logo`),
  navbar height 80 → 64px, left-aligned light-weight nav (no bold), no search,
  Login + Get Started (small) on the right.
- **Footer polish** — white SVG logo, lighter uppercase headings, smaller links.
- Added reusable `x-logo` component + `components/logo.css`.
- Synced docs: `design-system.md` §17, `header.md` (height + structure).
- Header/Footer polish review (`docs/reviews/0009-header-footer-polish-review.md`).

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
