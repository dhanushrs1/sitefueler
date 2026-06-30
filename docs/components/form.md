# Form Component v1.0

> Component specification only. No HTML, CSS, Blade, or JavaScript.
> Defines a single, unified form system shared by login, register, contact,
> search, checkout, and the admin panel.
> All visual values reference tokens in `variables.css` (see `design-system.md`).
> Depends on: Button system (`button.md`).

---

## 1. Purpose

Provide one consistent form system so every input across SiteFueler looks and
behaves identically. Unifying fields, labels, validation, and focus states means
a user learns the pattern once and recognizes it everywhere, and developers never
re-style inputs per page.

---

## 2. Structure

A form is composed of field groups, each built from the same regions.

| Region        | Required | Notes                                            |
| ------------- | -------- | ------------------------------------------------ |
| Label         | Yes      | Sits above the control; always present (visible or visually hidden) |
| Control       | Yes      | Input, Textarea, Select, Checkbox, Radio, or Switch |
| Helper text   | Optional | Small, muted, below the control                  |
| Error message | Optional | Replaces helper text in the error state          |
| Required mark | Optional | Indicates a required field                       |

**Shared base tokens (all text-style controls):**

| Property        | Value                                       |
| --------------- | ------------------------------------------- |
| Height          | 48px (`--input-height`)                      |
| Corner radius   | 12px (`--radius-sm`)                          |
| Border          | 1px solid `--color-border`                    |
| Background      | `--color-surface`                             |
| Text color      | `--color-body`                                |
| Placeholder     | `--color-muted`                               |
| Label color     | `--color-heading`                             |
| Label size      | `--text-small`, weight `--font-weight-medium` |
| Inner padding   | `--space-12` / `--space-16`                   |
| Field gap       | `--space-16` between field groups             |
| Focus accent    | `--color-primary`                             |
| Transition      | 200ms (`--duration-normal`, `--ease`)         |

Controls covered by this system: **Input, Textarea, Select, Checkbox, Radio,
Switch**. All share the same design language; Checkbox/Radio/Switch use the
Primary accent and the same focus treatment even though their shape differs.

---

## 3. Variants

Form controls, not stylistic variants. Each shares the base above.

| Control  | Notes                                                          |
| -------- | -------------------------------------------------------------- |
| Input    | Single-line text, email, password, number, etc. 48px height.   |
| Textarea | Multi-line; same border/radius/padding; vertically resizable.  |
| Select   | Same height/border as Input; trailing chevron (Lucide).        |
| Checkbox | Square control, Primary accent when checked.                   |
| Radio    | Circular control, Primary accent when selected.                |
| Switch   | Toggle; track + thumb, Primary when on, 200ms slide.           |

No filled/underline/floating-label variants in v1.0.

---

## 4. Sizes

v1.0 ships a **single default size** (48px height) for all text controls to keep
forms uniform. A compact size may arrive later (see §10). Checkbox, Radio, and
Switch use their own fixed control dimensions sized to align with body text.

---

## 5. States

Every control supports these states:

| State    | Behavior                                                          |
| -------- | ----------------------------------------------------------------- |
| Normal   | Resting: border `--color-border`, surface background              |
| Hover    | Subtle border emphasis                                             |
| Focus    | Visible focus ring using `--color-primary`; never removed silently |
| Filled   | Valid value present; appearance same as Normal                    |
| Disabled | Reduced emphasis, `cursor: not-allowed`, non-interactive          |
| Readonly | Value visible, not editable, still focusable for copy             |
| Error    | Border + message use `--color-danger`; error text replaces helper |
| Success  | Optional valid confirmation using `--color-success`               |

All transitions animate at **200ms**.

---

## 6. Behavior

- Clicking a label focuses its associated control (`for` / `id` pairing).
- Validation messages appear below the control; the error state swaps helper text
  for the error message and applies the danger border.
- Required fields are marked consistently (visual mark + `required` attribute).
- Submit actions use the **Button** system (Primary for submit, Ghost for cancel);
  forms never define their own button styles.
- Switch toggles on click/Space; Select opens the native option list in v1.0.
- A form should prevent double submission while a request is pending (the submit
  button enters its Loading state per `button.md`).

---

## 7. Accessibility

- **Labels:** every control has a programmatically associated `<label>`. Hidden
  labels use visually-hidden text, never a missing label.
- **Keyboard:** all controls reachable and operable by keyboard; logical tab order.
- **Focus:** visible focus state on every control (`--color-primary` ring).
- **Errors:** associate messages with their field via `aria-describedby`; mark
  invalid fields with `aria-invalid="true"`.
- **Required:** convey via the `required` attribute, not color alone.
- **Groups:** related radios/checkboxes use `<fieldset>` + `<legend>`.
- **Contrast:** text, borders, and placeholders target WCAG AA. (Full WCAG
  validation requires manual testing with assistive tech.)
- **Color independence:** error/success never rely on color alone — always pair
  with text and/or icon.

---

## 8. Responsive Behavior

- Forms are single-column by default at all breakpoints for readability.
- On wider screens, short related fields (e.g. First/Last name) may sit in a
  2-column row using the layout grid; they collapse to one column below 768px.
- Controls are full width of their container; height stays constant across
  breakpoints.
- Touch targets (48px height) are comfortable on mobile.

---

## 9. Usage Rules

- Always pair a label with every control; placeholders are not labels.
- Use helper text for guidance, error text only for problems.
- One primary submit action per form (Button: Primary); secondary actions use
  Ghost or Secondary.
- Keep field order logical and grouped; avoid unnecessary fields.
- Never hardcode colors, spacing, radius, or height — use tokens.
- Do not invent new control styles; extend this system if a genuine need appears.

---

## 10. Future Enhancements

- **Compact (small) field size** for dense admin tables.
- **Input add-ons** (leading/trailing icons, prefixes like `$`, unit suffixes).
- **Floating labels** as an optional variant.
- **Custom styled Select** with searchable options.
- **Inline / real-time validation** as the user types.
- **File upload** control and **date/time pickers**.
- **Input masking** (phone, card number) tied to checkout.
