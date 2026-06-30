# Modal Review

**Component:** Modal (`modal.md` v1.0)
**Branch:** `feature/modal-system`
**Status:** PASS ✅

---

## Checklist

### Structure
- ✅ Backdrop (`::backdrop` scrim) + dialog
- ✅ Header (title + close X), body, optional footer (actions)
- ✅ `--radius-md`, `--shadow-lg`, `--space-24` padding, `--text-h4` title

### Variants
- ✅ Standard (title + body + footer)
- ✅ Confirmation (short message + confirm/cancel; Danger for destructive)
- ✅ Form modal (hosts `x-form.*` controls)

### Sizes
- ✅ Small (~420), Medium (~600, default), Large (~840); height capped to 90vh,
  body scrolls on overflow

### States
- ✅ Closed / Opening / Open / Closing (200ms enter & exit transitions)
- ✅ Background scroll locked while open (`body.modal-open`)

### Behavior
- ✅ Close via X, Cancel, Escape, and backdrop click
- ✅ Backdrop dismissal disabled for critical modals (`:closeOnBackdrop="false"`)
- ✅ One modal at a time (native top layer)
- ✅ Reduced-motion: instant open/close, transitions disabled

### Accessibility
- ✅ Native `<dialog>` + `showModal()` → modal semantics, **focus trap**, and an
  **inert background** for free
- ✅ `aria-labelledby` points to the title
- ✅ Focus returns to the trigger on close (native behavior)
- ✅ Escape closes (native `cancel`, intercepted to animate + unlock scroll)
- ✅ Close is a real `<button>` with `aria-label="Close"` and visible focus

### Technical
- ✅ Uses design tokens (surface, radius, shadow, spacing, type, duration)
- ✅ No duplicated CSS
- ✅ Responsive (near-full width + stacked footer < 768px)
- ✅ Reusable Blade component (`title`, `size`, `closeOnBackdrop`, body + `footer`)
- ✅ Vanilla JS controller in `app.js` (delegated open/close, backdrop, Escape)

### Documentation
- ✅ Review document (this file)
- ✅ Changelog updated
- ⏳ Release note entry at Milestone 2 close (`v0.2.0`)

---

## Notes & decisions

- **Native `<dialog>`** was chosen over a hand-rolled overlay because it provides
  focus trapping, Escape handling, and background inertness natively — far more
  robust and accessible than a custom implementation, and it keeps the JS small.
- **Backdrop scrim** uses `rgba(10, 13, 20, 0.5)` (a scrim over `--color-dark`).
  This is the one intentional literal: `::backdrop` can't take a tokenized
  translucent color cleanly, and a scrim isn't a palette color. Documented here.
- **Stacking** is handled by the dialog top layer; `--z-overlay`/`--z-modal`
  remain available for any non-native overlays.

## Decision

**Approved.** Modal meets its specification and the Definition of Done. This is
the final Milestone 2 component — proceed to close the milestone and tag `v0.2.0`.
