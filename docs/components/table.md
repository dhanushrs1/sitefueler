# Table Component v1.0

> Component specification only. No HTML, CSS, Blade, or JavaScript.
> Defines the single admin/data table style used across SiteFueler.
> All visual values reference tokens in `variables.css` (see `design-system.md`).
> Depends on: Badge (`badge.md`), Button (`button.md`), Typography (design-system §3).

---

## 1. Purpose

Provide one consistent table style for displaying structured data in the admin
panel and data views (orders, users, products, templates, plugins). A single
style keeps dense data legible and predictable, so every table reads the same way.

---

## 2. Structure

A table consists of a header row, body rows, and optional surrounding controls.

| Region        | Required | Notes                                            |
| ------------- | -------- | ------------------------------------------------ |
| Toolbar       | Optional | Search/filter/actions above the table            |
| Header (thead)| Yes      | Column labels                                    |
| Body (tbody)  | Yes      | Data rows                                        |
| Cell          | Yes      | Text, Badge (status), or Button (row action)     |
| Footer/Pager  | Optional | Pagination / summary below the table             |

**Shared base tokens:**

| Property        | Value                                       |
| --------------- | ------------------------------------------- |
| Header text     | `--text-small`, `--font-weight-semibold`, `--color-heading` |
| Cell text       | `--text-body` / `--text-small`, `--color-body` |
| Row divider     | 1px solid `--color-divider`                  |
| Cell padding    | `--space-12` block / `--space-16` inline      |
| Surface         | `--color-surface`                             |
| Outer radius    | `--radius-md` (when wrapped in a card/panel)  |
| Transition      | 200ms (`--duration-normal`, `--ease`)         |

No alternate table themes. One style only.

---

## 3. Variants

Structural options, not visual themes — all share the base.

| Option         | Notes                                                       |
| -------------- | ----------------------------------------------------------- |
| Default        | Header + divided rows                                       |
| With selection | Leading checkbox column (uses Form checkbox)                |
| With actions   | Trailing actions column (uses Button system, often Ghost)   |
| Status column  | Uses Badge for state (e.g. Active, Out of Stock)            |

---

## 4. Sizes

Single default row density in v1.0 (cell padding `--space-12` / `--space-16`). A
compact density is a future enhancement (§10).

---

## 5. States

| State        | Behavior                                                    |
| ------------ | ----------------------------------------------------------- |
| Default row  | Resting appearance, divider between rows                    |
| Hover row    | Subtle background emphasis to aid scanning                  |
| Selected row | Highlighted when its checkbox is checked                    |
| Focus        | Interactive cells (links/buttons/checkbox) show visible focus|
| Empty        | Empty-state message when there are no rows                  |
| Loading      | Loading indication while data is fetched                    |

All transitions animate at **200ms**.

---

## 6. Behavior

- Tables are built from semantic `<table>` markup (thead/tbody/th/td).
- Row hover highlights for readability; rows are not buttons unless explicitly linked.
- Status cells use Badges; action cells use the Button system (commonly Ghost/Small).
- Sorting, filtering, and pagination controls live in the toolbar/footer and reuse
  Form and Button components.
- On data fetch, show the Loading state; when no results, show the Empty state.

---

## 7. Accessibility

- **Semantic table:** use `<table>`, `<thead>`, `<tbody>`, `<th>` with appropriate
  `scope`, and `<caption>` (visible or visually hidden) describing the table.
- **Headers association:** column headers programmatically associated with cells.
- **Keyboard:** all interactive cell content (links, buttons, checkboxes) is
  keyboard operable with visible focus.
- **Selection:** "select all" and per-row checkboxes have accessible names.
- **Not color alone:** status conveyed by Badge text, not color only.
- **Contrast:** text and dividers target WCAG AA. (Full WCAG validation requires
  manual testing.)

---

## 8. Responsive Behavior

- Tables can exceed mobile width; on small screens the table scrolls horizontally
  within its container (no breaking of the layout).
- Alternatively, low-priority columns may be hidden on mobile (consuming view's
  decision), keeping key columns visible.
- The toolbar stacks vertically on mobile.
- A future "stacked card" presentation for mobile is noted in §10.

---

## 9. Usage Rules

- Use tables for structured, comparable data — not for layout.
- Keep column counts reasonable; prioritize the most important columns on mobile.
- Use Badges for status and Ghost/Small buttons for row actions.
- Always provide an Empty state.
- Never hardcode colors, spacing, or radius — use tokens.

---

## 10. Future Enhancements

- **Compact density** option for data-heavy admin views.
- **Sortable columns** with sort indicators.
- **Sticky header** on scroll.
- **Row expansion** / detail rows.
- **Bulk actions** bar tied to selection.
- **Stacked card layout** for mobile instead of horizontal scroll.
- **Pagination** component (see roadmap) integrated in the footer.
