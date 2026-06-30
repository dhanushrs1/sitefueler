# Header & Footer Polish Review

**Feature:** Header/Footer visual polish
**Branch:** `feature/header-footer-polish`
**Status:** PASS ✅

A clean-up pass on the shell to a minimal, professional, Laravel-style header and
a lighter footer.

---

## Changes

### Header
- ✅ **SVG logo** (reusable `x-logo`, two-tone — wordmark in text color, mark in
  brand orange) replaces the text logo.
- ✅ **Slimmer height:** `--navbar-height` 80 → **64px**.
- ✅ **No search** in the header (removed icon + mobile search bar). The Form-based
  Search Bar component remains for `/search` pages.
- ✅ **Left-aligned nav** next to the logo (was centered), actions pushed right.
- ✅ **Lighter nav text** — `--text-small`, medium weight, color change on hover
  only (removed the hover background pill). Not bold.
- ✅ Actions: Login (Ghost, sm) + Get Started (Primary, sm) — clean and compact.
- ✅ White background, single subtle 1px bottom border (no shadow/texture).

### Footer
- ✅ White **logo** (`tone="light"`) replaces the bold text brand name.
- ✅ **Lighter headings** — small, uppercase, letter-spaced, muted (not bold white).
- ✅ Links reduced to `--text-small`; overall lighter, cleaner.

## Accessibility
- ✅ Logo link has `aria-label`; SVG has `role="img"` + `aria-label="SiteFueler"`.
- ✅ Nav landmarks and active-route highlighting preserved.
- ✅ Hamburger keeps `aria-expanded` / `aria-controls`; focus states intact.
- ✅ Footer light text on dark uses `--color-gray-300`/white for contrast.

## Visual QA
Verified on the running server (markup + served CSS):
- Desktop: logo + left nav + right actions, 64px bar, no search.
- < 1024px: hamburger + centered logo; nav + actions collapse into the panel
  (no search bar).
- Footer: three columns ≥768px, white logo, lighter headings.

> Limitation: verified via rendered HTML/CSS, not a live browser or device.

## Technical
- ✅ Token-based; `--navbar-height` updated; logo two-tone via `currentColor`.
- ✅ New `components/logo.css`; docs synced (`design-system.md` §17, `header.md`).
- ✅ Composes Button; no bold-heavy typography.

## Decision

**Approved.** Header and footer are clean, slim, and professional.
