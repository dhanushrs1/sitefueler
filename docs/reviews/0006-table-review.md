# Table Review

**Component:** Table (`table.md` v1.0)
**Branch:** `feature/table-system`
**Status:** PASS ✅

---

## Checklist

### Structure
- ✅ Semantic `<table>` with `<caption>`, `<thead>`, `<tbody>`, `<th>`, `<td>`
- ✅ Scroll wrapper (`.table-wrap`) with border + `--radius-md`
- ✅ Toolbar/footer live outside the component (consumer-composed)

### Options (one shared style)
- ✅ Default (header + divided rows)
- ✅ Selection column (`.table__select` + Form checkbox)
- ✅ Actions column (`.table__actions` + Buttons, right-alignable)
- ✅ Status column (Badge)

### States
- ✅ Default row + row dividers
- ✅ Hover row (subtle `--color-gray-50`)
- ✅ Selected row (`.is-selected`)
- ✅ Focus on interactive cell content (links/buttons/checkbox)
- ✅ Empty state (`.table__empty` / `empty` usage)
- ✅ Loading (`.is-loading` on the wrapper)

### Accessibility
- ✅ Semantic table markup; `<caption>` describes the table
- ✅ `<th>` headers with default left scope; keyboard-operable cell content
- ✅ Status by Badge text, not color alone
- ✅ Visible focus on interactive elements

### Technical
- ✅ Uses design tokens (divider, heading/body text, spacing, radius)
- ✅ No duplicated CSS (single style)
- ✅ No hardcoded values
- ✅ Responsive (horizontal scroll within `.table-wrap` on small screens)
- ✅ Reusable Blade component (`head` slot + body slot + caption)

### Documentation
- ✅ Review document (this file)
- ✅ Changelog updated
- ⏳ Release note entry at Milestone 2 close (`v0.2.0`)

---

## Notes & decisions

- **Composition:** `table/table.blade.php` renders the scroll wrapper + `<table>`
  with a `head` slot (thead rows) and body slot (tbody rows). Rows stay as plain
  semantic markup so consumers drop in `x-badge` for status and `x-button` for
  actions — no bespoke table styles per page.
- **Selected-row tint** uses the neutral `--color-gray-100` (no primary-soft token
  exists), keeping it token-based.
- **Sticky headers, sortable columns, and mobile stacked layout** remain future
  enhancements per the spec; v1.0 uses horizontal scroll on small screens.

## Decision

**Approved.** Table meets its specification and the Definition of Done. Continue
with **Modal** — the final Milestone 2 component.
