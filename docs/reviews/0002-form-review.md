# Form Review

**Component:** Form System (`form.md` v1.0)
**Branch:** `feature/form-system`
**Status:** PASS ✅

The Form System was reviewed against its specification and the Definition of Done.
Built as a system (not a single field): a shared field wrapper plus six controls
and three layout modes.

---

## Checklist

### Controls / inputs
- ✅ Input types: text, email, password, number, search, url, tel (via `type`)
- ✅ Textarea (vertical resize, multi-line)
- ✅ Select (native, custom chevron, `[value => label]` or slot options)
- ✅ Checkbox (custom checkmark)
- ✅ Radio (custom dot)
- ✅ Toggle Switch (`role="switch"`, 200ms slide)

### Validation states
- ✅ Default
- ✅ Success (border + focus ring)
- ✅ Warning (border + focus ring)
- ✅ Error (border, `aria-invalid`, error message via `aria-describedby`)
- ✅ Disabled
- ✅ Read-only

### Extras
- ✅ Label (with required marker)
- ✅ Helper text (`field__hint`)
- ✅ Error message (`field__error`, replaces hint)
- ✅ Prefix icon (`prefix` slot)
- ✅ Suffix icon (`suffix` slot; also used for select chevron)

### Layout
- ✅ Single field (default)
- ✅ Two-column group (`group layout="row-2"`, collapses < 768px)
- ✅ Inline group (`group layout="inline"`)

### Accessibility
- ✅ Every control has an associated `<label>` (`for` / `id`)
- ✅ Keyboard operable (native controls)
- ✅ Visible focus (`:focus-visible` 2px ring, state-colored)
- ✅ `aria-invalid` on error; messages linked via `aria-describedby`
- ✅ `required` attribute (not color alone); required marker is `aria-hidden`
- ✅ Switch exposes `role="switch"`
- ✅ Error/success not by color alone (border + text message + icon support)

### Technical
- ✅ Uses design tokens (colors, spacing, radius, typography, animation)
- ✅ No duplicated CSS (shared `.form-control` base; field wrapper reused)
- ✅ No hardcoded design-system values (see notes on component sizes)
- ✅ Responsive (full-width controls; two-column collapses < 768px)
- ✅ Reusable Blade components (parameter-driven, compose with `x-button`)

### Documentation
- ✅ Review document (this file)
- ✅ Changelog updated (under `[Unreleased]`)
- ⏳ Release note entry — captured at Milestone 2 close (`v0.2.0`)

---

## Notes & decisions

- **Focus indicator:** uses a `:focus-visible` outline ring in the field's state
  color (primary by default, danger/success/warning on validation) rather than a
  box-shadow tint, to stay strictly token-based (no primary-soft token exists).
  This satisfies the spec's "visible focus using `--color-primary`".
- **Checkbox/radio size:** `var(--space-20)` (20px); checkbox corner uses
  `--radius-sm`. The checkmark/dot are drawn with CSS (no SVG data URIs).
- **Switch dimensions:** track `44px × var(--space-24)`, thumb `var(--space-20)`.
  The 44px width and 20px thumb travel are component constants (no global token
  fits a 2:1 toggle), consistent with how Button sizes are handled.
- **Select chevron:** native arrow hidden (`appearance: none`); a decorative
  Lucide `chevron-down` SVG is rendered as a suffix affix with `pointer-events:
  none` so clicks still open the native list.
- **Blade pattern:** follows the Button blueprint — parameter-driven components,
  a shared `field` wrapper (label + control + message), and composition over
  duplication. `input`/`textarea`/`select` render through `x-form.field`.

## Decision

**Approved.** The Form System meets its specification and the Definition of Done,
and composes cleanly with the Button. It is ready to power login, register,
contact, search, settings, and checkout. Continue with **Badge**.
