# Card Component v1.0

> Component specification only. No HTML, CSS, Blade, or JavaScript.
> Defines one base card that Product, Service, and Blog cards all inherit.
> All visual values reference tokens in `variables.css` (see `design-system.md`).
> Depends on: Button (`button.md`), Badge (`badge.md`), Typography (design-system §3).

---

## 1. Purpose

Provide one consistent container for grouped content so every card across
SiteFueler shares the same shape, elevation, and spacing. A single base prevents
divergent card styles and keeps grids visually uniform, while content-specific
cards (Product, Service, Blog) only add their own inner layout.

---

## 2. Structure

A card is a surface containing optional media, a body, and an optional footer.

| Region | Required | Notes                                               |
| ------ | -------- | --------------------------------------------------- |
| Media  | Optional | Image (WebP, 4:3), may host a Badge overlay         |
| Body   | Yes      | Title, supporting text/meta, and content            |
| Footer | Optional | Actions (Button system) and/or meta (price, date)   |

**Base card tokens (inherited by all card types):**

| Property      | Value                                  |
| ------------- | -------------------------------------- |
| Background    | `--color-surface`                       |
| Corner radius | 10px (`--radius-md`)                     |
| Shadow        | `--shadow-md` (resting)                  |
| Padding       | `--space-24`                             |
| Inner gap     | `--space-16` between body elements       |
| Image radius  | `--image-radius` (10px), 4:3 ratio       |
| Title         | `--text-h5` / `--text-h4`, `--color-heading` |
| Body text     | `--text-body`, `--color-body`            |
| Meta text     | `--text-small`, `--color-muted`          |
| Transition    | 200ms (`--duration-normal`, `--ease`)    |

---

## 3. Variants

All variants inherit the base; they differ only in inner content.

| Variant      | Adds                                                          |
| ------------ | ------------------------------------------------------------- |
| Product card | Media + Badge(s) + title + price + Primary action (e.g. Buy)  |
| Service card | Icon/media + title + description + Secondary/Ghost action     |
| Blog card    | Cover image + title + excerpt + meta (date/author)            |

No card type redefines the base shape, radius, shadow, or padding. New card types
must extend the base, not replace it.

---

## 4. Sizes

Cards have **no fixed size**; they fill their grid cell. Width is controlled by
the layout grid (`layout.css` `.grid`: 1 → 2 → 3 → 4 columns across breakpoints).
Card height is content-driven; cards in the same row should align to equal height.

---

## 5. States

| State    | Behavior                                                       |
| -------- | -------------------------------------------------------------- |
| Default  | Resting: surface background, `--shadow-md`                     |
| Hover    | Subtle lift (e.g. `--shadow-lg`) when the card is interactive  |
| Focus    | If the whole card is a link, a visible focus ring on the card  |
| Active   | Pressed feedback for interactive cards                          |
| Disabled | Reduced emphasis for unavailable items (e.g. out-of-stock)      |

Inner buttons follow their own states from `button.md`. Non-interactive cards
have only the Default state.

---

## 6. Behavior

- Depth comes from shadow + white space only (no texture/glass — design-system §21.4).
- Interactive cards (linked) elevate on hover at 200ms; non-interactive cards do not.
- Badges position over the media or beside the title; the card owns placement.
- Actions live in the footer and use the Button system; cards never define button styles.
- A card should have a single primary tap target where possible; avoid nested
  competing links.

---

## 7. Accessibility

- **Semantic structure:** title uses a real heading element appropriate to context;
  media uses meaningful `alt` text (empty `alt` if purely decorative).
- **Whole-card link:** if the entire card is clickable, ensure one clear focusable
  link and avoid trapping multiple nested interactive elements ambiguously.
- **Focus:** interactive cards show a visible focus ring.
- **Contrast:** text over media must remain readable (overlay/scrim if needed);
  targets WCAG AA. (Full WCAG validation requires manual testing.)
- **Meaning not by color:** status (e.g. out of stock) conveyed in text, not color alone.

---

## 8. Responsive Behavior

- Cards reflow via the layout grid: 1 col (mobile) → 2 (tablet) → 3 (laptop) →
  4 (desktop), gap `--card-gap`.
- Media keeps its 4:3 ratio while scaling with the card width.
- Padding stays `--space-24` across breakpoints; on very small screens this keeps
  content comfortable without shrinking.

---

## 9. Usage Rules

- Always extend the base card; never create a one-off card style.
- One primary action per card; keep footers simple.
- Keep titles short; let the grid control width.
- Use Badges sparingly (max two — see `badge.md`).
- Never hardcode radius, shadow, spacing, or color — use tokens.

---

## 10. Future Enhancements

- **Horizontal card** layout (media left, content right) for list views.
- **Skeleton/loading** card state for async content.
- **Selectable card** (checkbox/radio) for pickers.
- **Compact card** density option for dashboards.
- **Card with footer divider** option when stronger separation is needed.
