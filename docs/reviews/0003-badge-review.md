# Badge Review

**Component:** Badge (`badge.md` v1.0)
**Branch:** `feature/badge-system`
**Status:** PASS ✅

---

## Checklist

### Variants (fixed set)
- ✅ New (Info — soft tint)
- ✅ Sale (Danger — soft tint)
- ✅ Best Seller (Primary — solid)
- ✅ Featured (Primary — solid)
- ✅ Out of Stock (neutral/muted)

### Structure
- ✅ Pill shape (`--radius-full`)
- ✅ Caption text, semibold
- ✅ Optional leading icon (`icon` slot, `aria-hidden`)
- ✅ Default label per variant; override via slot

### Accessibility
- ✅ Meaning carried by text label, not color alone
- ✅ Decorative icon `aria-hidden`
- ✅ Non-interactive (`<span>`), no focus/keyboard needed

### Technical
- ✅ Uses design tokens (semantic colors + soft tints, spacing, radius, type)
- ✅ No duplicated CSS
- ✅ No hardcoded values
- ✅ Responsive (size constant; inline-flex)
- ✅ Reusable Blade component (single, parameter-driven)

### Documentation
- ✅ Review document (this file)
- ✅ Changelog updated
- ⏳ Release note entry at Milestone 2 close (`v0.2.0`)

---

## Notes & decisions

- **Best Seller vs Featured** both map to Primary intent per the spec and render
  as solid primary; they are distinguished by their label text. No
  `--color-primary-soft` token exists, so the Primary badges use a solid fill
  (the spec permits "a solid fill where emphasis is needed"). New/Sale use the
  semantic soft tints; Out of Stock uses the neutral gray scale.
- **Labels** default from the variant (e.g. `variant="new"` → "New") but accept a
  custom slot (e.g. "-50%" on a Sale badge).

## Decision

**Approved.** Badge meets its specification and the Definition of Done. Continue
with **Alert**.
