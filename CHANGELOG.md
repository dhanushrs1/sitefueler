# Changelog

All notable changes to SiteFueler are documented here.
This project follows [Semantic Versioning](https://semver.org/).

## [Unreleased]

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
