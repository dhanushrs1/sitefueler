# Modal Component v1.0

> Component specification only. No HTML, CSS, Blade, or JavaScript.
> Defines the overlay dialog used for focused tasks and confirmations.
> All visual values reference tokens in `variables.css` (see `design-system.md`).
> Depends on: Button (`button.md`), Form (`form.md`).

---

## 1. Purpose

Present focused content or a required decision on top of the current page without
navigating away. Modals interrupt deliberately — for confirmations, short forms,
and details — while keeping the user's place in context.

---

## 2. Structure

A modal is a centered dialog over a dimmed backdrop.

| Region   | Required | Notes                                              |
| -------- | -------- | -------------------------------------------------- |
| Backdrop | Yes      | Dimmed overlay behind the dialog                   |
| Dialog   | Yes      | The surface panel containing the content           |
| Header   | Usually  | Title + close (X) button                           |
| Body     | Yes      | Message, form, or arbitrary content                |
| Footer   | Optional | Actions (Button system): primary + cancel          |

**Shared base tokens:**

| Property       | Value                                       |
| -------------- | ------------------------------------------- |
| Dialog surface | `--color-surface`                            |
| Corner radius  | 16px (`--radius-md`)                          |
| Shadow         | `--shadow-lg`                                 |
| Padding        | `--space-24`                                  |
| Section gap    | `--space-16`                                  |
| Title          | `--text-h4`, `--color-heading`                |
| Body text      | `--text-body`, `--color-body`                 |
| Backdrop       | Dark translucent scrim over the page          |
| Stacking       | `--z-modal` (backdrop + dialog)               |
| Transition     | 200ms (`--duration-normal`, `--ease`)         |

Footer actions use the Button system: a Primary (confirm) and a Ghost (cancel);
destructive confirmations use Danger.

---

## 3. Variants

| Variant      | Use                                                       |
| ------------ | --------------------------------------------------------- |
| Standard     | Title + body content + footer actions                     |
| Confirmation | Short message + confirm/cancel (Danger for destructive)   |
| Form modal   | Hosts a Form (`form.md`) for a quick create/edit task      |

No fullscreen or drawer variants in v1.0 (see §10).

---

## 4. Sizes

Three width sizes; height is content-driven and capped to the viewport (body
scrolls if content overflows).

| Size   | Max width | Use                                 |
| ------ | --------- | ----------------------------------- |
| Small  | ~420px    | Confirmations, short messages       |
| Medium | ~600px    | Default; standard content / forms   |
| Large  | ~840px    | Richer content, larger forms        |

Widths are capped by the viewport with side margins on small screens.

---

## 5. States

| State   | Behavior                                                       |
| ------- | -------------------------------------------------------------- |
| Closed  | Not rendered / not visible                                     |
| Opening | Backdrop fades in, dialog transitions in (200ms)               |
| Open    | Visible; focus moved into the dialog; page scroll locked       |
| Closing | Backdrop fades out, dialog transitions out (200ms)             |

Inner buttons/forms follow their own component states.

---

## 6. Behavior

- Opening a modal locks background scroll and dims the page with the backdrop.
- **Close triggers:** the X button, a Cancel/Ghost action, pressing `Escape`, and
  (for non-critical modals) clicking the backdrop.
- **Critical/confirmation modals** may disable backdrop-click dismissal so a
  decision is explicit.
- Only one modal is open at a time in v1.0 (no stacking).
- All open/close motion is 200ms and respects reduced-motion.

---

## 7. Accessibility

- **Dialog semantics:** `role="dialog"` with `aria-modal="true"` and an
  `aria-labelledby` pointing to the title (and `aria-describedby` for the body
  where helpful).
- **Focus management:** on open, focus moves into the dialog; focus is **trapped**
  within it while open; on close, focus returns to the triggering element.
- **Keyboard:** `Escape` closes (unless explicitly disabled for critical dialogs);
  `Tab`/`Shift+Tab` cycle within the dialog.
- **Close control:** the X is a real `<button>` with an accessible name.
- **Backdrop:** background content is inert/non-focusable while the modal is open.
- **Contrast & motion:** target WCAG AA; respect reduced-motion. (Full WCAG
  validation requires manual testing.)

---

## 8. Responsive Behavior

- On desktop/tablet, the dialog is centered at its size's max width.
- On mobile (<768px), the dialog uses near-full width with side margins
  (`--space-16`) and a capped height; the body scrolls if needed.
- Footer actions may stack vertically on narrow screens (Primary on top or per
  platform convention), full width.

---

## 9. Usage Rules

- Use modals sparingly — only for focused tasks or decisions that warrant
  interrupting the user.
- Keep content concise; long flows belong on a page, not a modal.
- Always provide an explicit close (X and/or Cancel).
- Destructive confirmations use the Danger button and clear wording.
- One primary action per modal.
- Never hardcode colors, spacing, radius, shadow, or z-index — use tokens.

---

## 10. Future Enhancements

- **Drawer / side-sheet** variant (slides from edge).
- **Fullscreen modal** for complex mobile flows.
- **Multi-step (wizard)** modal.
- **Non-blocking** lightweight popovers (distinct from modals).
- **Stacked modals** management, if a real need appears.
