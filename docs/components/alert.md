# Alert Component v1.0

> Component specification only. No HTML, CSS, Blade, or JavaScript.
> Defines inline feedback messages for the four semantic states.
> All visual values reference tokens in `variables.css` (see `design-system.md`).

---

## 1. Purpose

Give users clear, color-coded feedback about the outcome of an action or the
state of the system. Alerts make success, warnings, errors, and information
immediately recognizable using the shared semantic colors, so feedback feels
consistent everywhere (forms, checkout, admin, page-level notices).

---

## 2. Structure

An alert is a horizontal block with an icon, message, and optional dismiss.

| Region       | Required | Notes                                        |
| ------------ | -------- | -------------------------------------------- |
| Leading icon | Yes      | Lucide icon matching the alert type          |
| Title        | Optional | Short bold heading                            |
| Message      | Yes      | Body text                                     |
| Action       | Optional | Link or Ghost button (uses Button system)     |
| Dismiss      | Optional | Close (X) icon button, top-right              |

**Shared base tokens:**

| Property      | Value                                       |
| ------------- | ------------------------------------------- |
| Corner radius | 12px (`--radius-sm`)                         |
| Padding       | `--space-16`                                 |
| Icon gap      | `--space-12`                                 |
| Title         | `--text-body`, weight `--font-weight-semibold` |
| Message       | `--text-small` / `--text-body`               |
| Transition    | 200ms (`--duration-normal`, `--ease`)        |

Each alert uses a soft tinted background derived from its semantic color, with a
matching border/accent and readable text.

---

## 3. Variants

Exactly four, mapped to the semantic tokens (design-system §16).

| Variant | Token             | Value     | Meaning                              |
| ------- | ----------------- | --------- | ------------------------------------ |
| Success | `--color-success` | `#16A34A` | Operation completed successfully     |
| Warning | `--color-warning` | `#D97706` | Caution; may have consequences       |
| Danger  | `--color-danger`  | `#DC2626` | Error or failed/destructive outcome  |
| Info    | `--color-info`    | `#2563EB` | Neutral, informational message       |

Each variant pairs with a conventional Lucide icon (e.g. check-circle, alert-
triangle, x-circle, info). No additional variants.

---

## 4. Sizes

Single default size in v1.0. A compact/toast size is a future enhancement (§10).

---

## 5. States

| State     | Behavior                                                     |
| --------- | ------------------------------------------------------------ |
| Visible   | Resting display per variant                                  |
| Dismissed | Removed from view (fade/collapse at 200ms) when closed       |
| Focus     | If dismissible or actionable, controls show visible focus    |

Alerts have no hover/disabled/loading states themselves; their inner action
button follows `button.md`.

---

## 6. Behavior

- Alerts are typically **inline** (within page/section flow) in v1.0.
- A dismissible alert can be closed via its X button; dismissal animates at 200ms.
- Optional actions (e.g. "Retry", "Undo") use the Button system (Ghost or link).
- Auto-dismiss is **not** default in v1.0 (reserved for future toasts).
- Page-level alerts (e.g. flash messages) render at the top of the content area.

---

## 7. Accessibility

- **Roles:** Danger/Warning use `role="alert"` (assertive); Success/Info use
  `role="status"` (polite) so screen readers announce appropriately.
- **Not color alone:** the icon + text convey meaning, never color by itself.
- **Dismiss control:** the X is a real `<button>` with an accessible name
  ("Dismiss"/"Close") and visible focus.
- **Contrast:** tinted background + text target WCAG AA. (Full WCAG validation
  requires manual testing.)
- **Decorative icon:** the leading status icon is `aria-hidden` since the text
  already states the meaning.
- **Motion:** dismiss animation respects reduced-motion.

---

## 8. Responsive Behavior

- Alerts are full width of their container at all breakpoints.
- Text wraps naturally; the icon stays top-aligned with multi-line messages.
- On mobile, an optional action button may move below the message.

---

## 9. Usage Rules

- Use the variant that matches the true severity (don't use Danger for warnings).
- Keep messages short and specific; state what happened and what to do next.
- One alert per message; don't stack many simultaneous alerts.
- Use **Danger** for errors/destructive results, **Warning** for cautions,
  **Success** for confirmations, **Info** for neutral notices.
- Never hardcode semantic colors — reference the tokens.

---

## 10. Future Enhancements

- **Toast notifications** (transient, auto-dismiss, positioned, `--z-toast`).
- **Compact/inline-field alerts** for tight spaces.
- **Stacked toast queue** management.
- **Action-rich alerts** with multiple buttons.
- **Banner variant** for site-wide announcements.
