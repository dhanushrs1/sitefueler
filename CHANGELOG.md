# Changelog

All notable changes to SiteFueler are documented here.
This project follows [Semantic Versioning](https://semver.org/).

## [Unreleased] — Milestone 2: Core UI Components

### Added
- **Button component** — single parameter-driven Blade component
  (`components/button.blade.php`) with four variants, three sizes, all six states,
  icon support (left / right / icon-only), and `components/button.css`.
- Button review record (`docs/reviews/0001-button-review.md`).
- **Form System** — shared `field` wrapper plus `input`, `textarea`, `select`,
  `checkbox`, `radio`, and `switch` components, with validation states
  (success/warning/error/disabled/readonly), label/hint/error, prefix/suffix
  icons, and `group` layouts (single / two-column / inline); `components/form.css`.
- Form review record (`docs/reviews/0002-form-review.md`).
- **Badge component** — single parameter-driven component with five fixed
  variants (New, Sale, Best Seller, Featured, Out of Stock), pill shape, optional
  icon slot, default labels; `components/badge.css`.
- Badge review record (`docs/reviews/0003-badge-review.md`).

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
