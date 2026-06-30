# Card Review

**Component:** Card (`card.md` v1.0)
**Branch:** `feature/card-system`
**Status:** PASS ✅

---

## Checklist

### Structure
- ✅ One base card (surface, `--radius-md`, `--shadow-md`, `--space-24` body padding)
- ✅ Media region (4:3 via `aspect-ratio`, `object-fit: cover`, badge overlay slot)
- ✅ Body (title / text / meta / price helper classes)
- ✅ Footer (pinned to bottom via `margin-top: auto` for equal-height rows)

### Variants (inherit the base)
- ✅ Product (media + badges + title + price + action)
- ✅ Service (title + text + action)
- ✅ Blog (cover + title + excerpt + meta)

### Sizes / layout
- ✅ No fixed size — fills its grid cell (`.grid`: 1 → 2 → 3 → 4 columns)
- ✅ Media keeps 4:3 while scaling

### States
- ✅ Default (`--shadow-md`)
- ✅ Hover lift to `--shadow-lg` when interactive
- ✅ Focus ring when the whole card is a link
- ✅ Disabled (reduced opacity, non-interactive)

### Accessibility
- ✅ Whole-card link renders as a single `<a>` (no nested-link ambiguity)
- ✅ Images require meaningful `alt` (consumer-provided)
- ✅ Visible focus on interactive cards
- ✅ Depth from shadow + white space only (no texture/glass — design-system §21.4)

### Technical
- ✅ Uses design tokens (surface, radius, shadow, spacing, type)
- ✅ No duplicated CSS (single base; variants are content-only)
- ✅ No hardcoded values
- ✅ Responsive (reflows via the layout grid)
- ✅ Reusable Blade component (`media`, `badges`, `footer` slots + body slot)

### Documentation
- ✅ Review document (this file)
- ✅ Changelog updated
- ⏳ Release note entry at Milestone 2 close (`v0.2.0`)

---

## Notes & decisions

- **Composition over per-type files:** a single `card/card.blade.php` exposes
  `media`, `badges`, and `footer` slots plus a body slot; `variant` adds a class
  hook. Product/Service/Blog are content compositions, matching "one base, many
  variants" and the Button/Form blueprint. Helper classes (`card__title`,
  `card__text`, `card__meta`, `card__price`) keep body markup consistent.
- **Whole-card link:** when `href` is set the card renders as `<a>` and becomes
  interactive (hover lift + focus ring), avoiding nested competing links.
- Composes cleanly with Badge (overlay) and Button (footer actions).

## Decision

**Approved.** Card meets its specification and the Definition of Done. Continue
with **Table**.
