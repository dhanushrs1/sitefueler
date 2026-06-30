# Badge Component v1.0

> Component specification only. No HTML, CSS, Blade, or JavaScript.
> Defines the small status/label pills used on product and content cards.
> All visual values reference tokens in `variables.css` (see `design-system.md`).

---

## 1. Purpose

Communicate the status or category of an item at a glance with a small, fixed set
of labels. Badges add quick context (new, discounted, unavailable) without
competing with primary content. A fixed set keeps meaning consistent and
recognizable across the catalog.

---

## 2. Structure

A badge is a single compact inline element: an optional leading icon plus a short
text label, on one line.

| Region     | Required | Notes                                  |
| ---------- | -------- | -------------------------------------- |
| Left icon  | Optional | Small Lucide icon                      |
| Label      | Yes      | Short text (1–2 words)                 |

**Shared base tokens:**

| Property      | Value                                          |
| ------------- | ---------------------------------------------- |
| Corner radius | 999px (`--radius-full`) — pill                 |
| Font size     | `--text-caption` (12px)                         |
| Font weight   | `--font-weight-semibold` (600)                  |
| Padding       | `--space-4` block / `--space-12` inline         |
| Text transform| Uppercase or sentence case (consistent per set) |
| Transition    | 200ms (`--duration-normal`, `--ease`)           |

---

## 3. Variants

Only these labels exist. Do not invent new ones without updating this spec and
the design system (§15).

| Badge        | Meaning                  | Color intent                              |
| ------------ | ------------------------ | ----------------------------------------- |
| New          | Recently added           | Info (`--color-info`)                     |
| Sale         | Discounted               | Danger/attention (`--color-danger`)       |
| Best Seller  | Top-selling              | Primary (`--color-primary`)               |
| Featured     | Editorially promoted     | Primary (`--color-primary`)               |
| Out of Stock | Unavailable              | Muted/neutral (`--color-muted`)           |

Style treatment: each badge is a soft/tinted fill with readable text, or a solid
fill where emphasis is needed — applied consistently across the set. (Exact
fill-vs-tint approach finalized at implementation, but the color intent above is
fixed.)

---

## 4. Sizes

Single default size in v1.0 (caption text, pill padding). Badges are intentionally
small and uniform. A larger size is not planned.

---

## 5. States

Badges are primarily **static/display** elements.

| State   | Behavior                                                       |
| ------- | -------------------------------------------------------------- |
| Default | Resting appearance per variant                                 |
| Hover   | No interaction by default (badges are not buttons)             |
| Focus   | Only if a badge is also a link/filter (then visible focus ring)|

Badges have no disabled or loading state.

---

## 6. Behavior

- Badges are non-interactive labels by default.
- A badge may sit on a card image (e.g. "Sale" on a product) or inline beside a
  title; placement is the consuming component's decision, not the badge's.
- If a badge is ever used as a clickable filter/tag (future), it must become a
  proper interactive element with focus and keyboard support.
- Animation, when present (e.g. fade-in), is 200ms.

---

## 7. Accessibility

- **Meaning not by color alone:** the text label carries the meaning; color is
  reinforcement only.
- **Contrast:** label/background combinations target WCAG AA.
- **Decorative icons:** leading icons are `aria-hidden`; the label is the
  accessible text.
- **Out of Stock** and similar status should be conveyed in text, not implied
  solely by a color or strike-through.
- If interactive (future filter), it must be keyboard operable with visible focus.

---

## 8. Responsive Behavior

- Badge size and padding stay constant across breakpoints.
- On small cards, only the most important badge should show to avoid clutter;
  the consuming component controls how many badges appear.

---

## 9. Usage Rules

- Use only the five defined labels.
- Limit to **one** badge per item where possible; two is the maximum on a card.
- "Out of Stock" takes priority over promotional badges when both could apply.
- Never use badges for long text or as buttons.
- Never hardcode colors or radius — use tokens.

---

## 10. Future Enhancements

- **Count / numeric badges** (e.g. cart item count) — distinct from status badges.
- **Dot badge** (small indicator without text).
- **Interactive filter tags** with full keyboard support.
- **Custom category badges** driven by data, within a controlled color set.
