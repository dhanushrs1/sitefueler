# Alert Review

**Component:** Alert (`alert.md` v1.0)
**Branch:** `feature/alert-system`
**Status:** PASS ✅

---

## Checklist

### Variants
- ✅ Success, Warning, Danger, Info (semantic soft tints + matching accent/border)

### Structure
- ✅ Leading icon (default Lucide icon per variant; overridable via `icon` slot)
- ✅ Optional title
- ✅ Message (default slot)
- ✅ Optional actions (`actions` slot; composes with `x-button`)
- ✅ Optional dismiss (X button)

### Behavior
- ✅ Inline alert; dismiss removes it with a 200ms fade (vanilla JS, delegated)
- ✅ Reduced-motion: removes instantly, transition disabled

### Accessibility
- ✅ `role="alert"` (assertive) for Danger/Warning; `role="status"` (polite) for
  Success/Info
- ✅ Status conveyed by icon + text, not color alone
- ✅ Decorative icon `aria-hidden`
- ✅ Dismiss is a real `<button>` with `aria-label="Dismiss"` and visible focus

### Technical
- ✅ Uses design tokens (semantic colors + soft tints, spacing, radius, type)
- ✅ No duplicated CSS
- ✅ No hardcoded values
- ✅ Responsive (full-width, content wraps, icon stays top-aligned)
- ✅ Reusable Blade component

### Documentation
- ✅ Review document (this file)
- ✅ Changelog updated
- ⏳ Release note entry at Milestone 2 close (`v0.2.0`)

---

## Notes & decisions

- **Dismiss JS** lives in `public/assets/js/app.js` as a single delegated handler
  for `[data-dismiss="alert"]` — no per-alert script, no framework.
- **Border** uses the full semantic color at 1px around the soft-tint background;
  the icon and title also take the semantic color, while the message uses
  `--color-body` for readability.

## Decision

**Approved.** Alert meets its specification and the Definition of Done. Continue
with **Card**.
