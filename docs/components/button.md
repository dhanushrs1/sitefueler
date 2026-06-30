# Button Component v1.0

> Component specification only. No HTML, CSS, Blade, or JavaScript.
> Buttons are the most-used interactive element in SiteFueler; this spec is the
> single source of truth for every button across the product.
> All visual values reference tokens in `variables.css` (see `design-system.md`).

---

## 1. Purpose

Provide a single, consistent action system for the entire application. Buttons
communicate that an element is interactive and signal the relative importance of
each action. A unified button system keeps the UI predictable across the
homepage, marketing pages, auth flows, dashboard, admin panel, checkout, and
inside other components (modals, forms, cards, header).

---

## 2. Structure

A button is a single interactive element containing an optional leading icon, a
label, and an optional trailing icon — all centered on one line.

| Region      | Required | Notes                                        |
| ----------- | -------- | -------------------------------------------- |
| Left icon   | Optional | Lucide icon before the label                 |
| Label       | Usually  | Text; optional only for the Icon-Only form   |
| Right icon  | Optional | Lucide icon after the label                  |

**Shared base tokens (all variants and sizes):**

| Property       | Value                                  |
| -------------- | -------------------------------------- |
| Corner radius  | 6px (`--radius-sm`) — no exceptions    |
| Font family    | `--font-family-base`                   |
| Font weight    | `--font-weight-semibold` (600)         |
| Transition     | 200ms (`--duration-normal`, `--ease`)  |
| Icon source    | Lucide only                            |
| Icon gap       | `--space-8` between icon and label     |

Icon layouts allowed: **Left Icon**, **Right Icon**, **Icon Only**. Nothing more.
An Icon-Only button must still carry an accessible name (see §7).

---

## 3. Variants

Only four. Nothing else.

| Variant   | Emphasis | Purpose                                  | Token mapping (resting)                         |
| --------- | -------- | ---------------------------------------- | ----------------------------------------------- |
| Primary   | Highest  | The main action on a screen              | Background `--color-primary`, text `--color-white` |
| Secondary | Medium   | Alternative, lower-emphasis action       | Surface/white fill, `--color-border` border, heading text |
| Ghost     | Low      | Tertiary / dismissive action             | Transparent fill, no border, body/heading text  |
| Danger    | High     | Destructive action                       | Solid danger fill, white text                   |

Notes:
- **Primary** hover uses `--color-primary-hover`.
- **Danger** uses the semantic danger color defined for Alerts (`design-system.md`
  §16). The exact danger hex is pending the Alert spec and will be referenced as a
  token, never hardcoded.
- No outline-primary, gradient, link-button, or other variants in v1.0.

---

## 4. Sizes

Only three. No extra-small, no extra-large.

| Size   | Height            | Horizontal padding | Font size        | Use                          |
| ------ | ----------------- | ------------------ | ---------------- | ---------------------------- |
| Small  | 32px (`--space-32`) | `--space-12`     | `--text-small`   | Compact UI, table rows       |
| Medium | 40px (`--button-height`) | `--space-16` | `--text-small`   | Default for most actions     |
| Large  | 48px (`--space-48`) | `--space-20`      | `--text-body`    | Hero / primary CTAs          |

- Medium is the default. The scale is intentionally compact and minimal.
- Icon-Only buttons are square at the same height as their size (e.g. 40×40 at
  Medium) and keep the 6px (`--radius-sm`) radius.

---

## 5. States

Every button supports these states and no custom ones:

| State    | Behavior                                                            |
| -------- | ------------------------------------------------------------------- |
| Normal   | Resting appearance per variant                                      |
| Hover    | Slight emphasis shift (e.g. Primary → `--color-primary-hover`)      |
| Active   | Pressed feedback (subtle darken / no movement beyond 200ms)         |
| Focus    | Visible focus ring; never removed without a visible replacement     |
| Disabled | Reduced emphasis, `cursor: not-allowed`, non-interactive, not focusable as an action |
| Loading  | Shows a spinner, hides/!replaces label, button is non-interactive while pending |

- All state transitions animate at **200ms**.
- Loading and Disabled both block activation; Loading communicates an in-progress
  request, Disabled communicates an unavailable action.

---

## 6. Behavior

- A button renders as a semantic `<button>` when it performs an in-page action and
  as an `<a>` when it navigates to a URL (see §7).
- Default `type="button"` unless explicitly a form submit/reset.
- Hover and focus feedback are immediate and consistent across variants.
- In the **Loading** state the button width should remain stable (no layout shift)
  while the spinner replaces the label.
- Icon-Only buttons behave identically but rely on an accessible label rather than
  visible text.

---

## 7. Accessibility

- **Semantic element:** use `<button>` for actions, `<a>` for navigation. Do not
  fake buttons with non-interactive elements.
- **Keyboard:** fully operable — `Enter`/`Space` activate `<button>`, `Enter`
  activates links; logical tab order; disabled buttons are skipped.
- **Visible focus:** every button shows a clear focus ring meeting visibility
  expectations.
- **Contrast:** label/background combinations must meet WCAG AA contrast. (Note:
  full WCAG validation requires manual testing; this spec targets AA by design.)
- **Icon-Only:** must provide an accessible name via `aria-label` (or visually
  hidden text); the icon itself is `aria-hidden`.
- **Loading:** expose busy state to assistive tech (e.g. `aria-busy="true"`); the
  control communicates that activation is temporarily unavailable.
- **Motion:** 200ms transitions respect reduced-motion preferences.

---

## 8. Responsive Behavior

- Buttons keep the same sizes across breakpoints; the type scale already accounts
  for readability.
- On mobile, primary CTAs may render **full width** (100%) within their container
  when used as the dominant action of a section or form; this is a layout choice,
  not a new size.
- Touch targets at all sizes meet a comfortable minimum (Medium/Large already
  exceed 44px; Small is reserved for dense desktop UI).
- Icon and label spacing (`--space-8`) is constant across breakpoints.

---

## 9. Usage Rules

- Every screen (or major section) should have **one** clear Primary action.
- Avoid multiple Primary buttons competing in the same section.
- **Destructive** actions always use the **Danger** variant.
- **Ghost** buttons are for secondary or dismissive actions (e.g. Cancel, Close).
- **Secondary** is for alternative actions that sit alongside a Primary (e.g. View
  Details next to Buy Now).
- Use sentence-case, action-first labels ("Get started", "Add to cart"), kept
  short.
- Never hardcode color, spacing, or radius — always use tokens.
- Do not introduce new variants or sizes to solve a one-off; compose with what
  exists or revisit this spec.

Quick mapping:

| Action      | Variant   |
| ----------- | --------- |
| Buy Now     | Primary   |
| View Details| Secondary |
| Cancel      | Ghost     |
| Delete      | Danger    |

---

## 10. Future Enhancements

- **Button groups / segmented controls.**
- **Split buttons** (action + dropdown) once dropdowns exist.
- **Toggle / pressed** buttons (`aria-pressed`) for on/off actions.
- **Icon-only tooltips** for clarity on hover/focus.
- Link-style button treatment, if a genuine need appears (currently excluded).
- Theming hooks for a future dark surface context.
