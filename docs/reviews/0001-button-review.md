# Button Review

**Component:** Button (`button.md` v1.0)
**Branch:** `feature/button-system`
**Status:** PASS ✅

The Button was reviewed against its specification and the Definition of Done.
Two issues were found during self-review and fixed on the branch before approval.

---

## Checklist

### Functionality
- ✅ Primary
- ✅ Secondary
- ✅ Ghost
- ✅ Danger

### Sizes
- ✅ Small (40px)
- ✅ Medium (48px, from `--button-height`)
- ✅ Large (56px)

### States
- ✅ Normal
- ✅ Hover
- ✅ Active
- ✅ Focus (`:focus-visible` ring)
- ✅ Disabled (`disabled` + `aria-disabled`, `pointer-events: none`)
- ✅ Loading (spinner, label hidden, width stable, `aria-busy`)

### Icon support
- ✅ Left icon (`iconLeft` slot)
- ✅ Right icon (`iconRight` slot)
- ✅ Icon only (`iconOnly` → square, tracks size)

### Accessibility
- ✅ Keyboard accessible (native `<button>` / `<a>`)
- ✅ Visible focus state (`:focus-visible`, 2px ring + offset)
- ✅ Semantic HTML (`<button>` for actions, `<a>` for `href`)
- ✅ Correct ARIA — `aria-busy` on loading; icon SVGs `aria-hidden`
- ⚠️ Icon-only requires the consumer to pass `aria-label` (the component cannot
  enforce a name). Documented in the Blade `@props` and usage notes.

### Technical
- ✅ Uses design tokens (colors, spacing, radius, typography, animation)
- ✅ No duplicated CSS (icon-only size duplication removed via `--btn-height`)
- ✅ No hardcoded design-system values (see notes on component sizes below)
- ✅ Responsive (sizes constant across breakpoints; `btn--block` for mobile CTAs)
- ✅ Reusable Blade component (single, parameter-driven)

### Documentation
- ✅ Review document (this file)
- ✅ Changelog updated (under `[Unreleased]`)
- ⏳ Release note entry — captured at Milestone 2 close (`v0.2.0`), per roadmap

---

## Issues Found & Fixes Applied

1. **Loading spinner rotated at `--duration-normal` (200ms).**
   A 200ms rotation period is frantic (~5 rotations/sec). Design-system §20's
   "200ms" governs brand state transitions (hover, toggle), not a continuous
   progress indicator's rotation speed.
   **Fix:** spinner now rotates at a conventional `0.6s`, documented in the CSS as
   a functional loop (not a §20 transition). Reduced-motion fallback (1.2s) kept.

2. **Icon-only width was duplicated per size** (`.btn--icon.btn--sm/.btn--lg`).
   **Fix:** introduced a component-local `--btn-height` custom property; sm/lg
   override it, and `.btn--icon { width: var(--btn-height) }` now tracks any size,
   removing the two duplicate rules.

---

## Notes

- **Component size scale (40 / 48 / 56px):** Medium derives from the global
  `--button-height` token; Small and Large are the component's own documented
  sizes from `button.md` §4, centralized in one place via `--btn-height`. These
  are component dimensions, not global design tokens, and are intentionally local.
- **Blade strategy change:** per the Milestone 2 directive, the per-variant Blade
  files (`button/primary.blade.php`, etc.) were replaced by a single
  `components/button.blade.php` driven by `variant`, `size`, `href`, `block`,
  `iconOnly`, `loading`, `disabled`, and `iconLeft`/`iconRight` slots. This
  supersedes the wrapper approach noted in ADR 0002 and will be the pattern for
  Badge, Alert, and Card.
- **New token from prior implementation:** `--color-danger-hover` was added (and
  is part of the frozen v0.1.0 set) so Danger hover/active are token-based.

## Decision

**Approved.** The Button satisfies its specification and the Definition of Done.
It becomes the blueprint pattern (single parameter-driven Blade component, BEM-ish
`btn`/`btn--*` classes, token-driven CSS, `:focus-visible`, ARIA for loading and
icon-only) for the remaining Milestone 2 components.
