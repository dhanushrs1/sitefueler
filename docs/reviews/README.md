# Component Reviews

Every component is **reviewed against its specification** before it merges into
`main`. The review is documentation, not a fix list — it records whether the
implementation meets the standard and why.

Files are numbered to match the build order: `0001-button-review.md`,
`0002-form-review.md`, `0003-card-review.md`, ...

A review must result in one of two statuses:

- **PASS** → the component is approved and may be merged.
- **CHANGES REQUIRED** → issues are listed; the component is fixed and re-reviewed.

## Template

```markdown
# <Component> Review

Status
PASS | CHANGES REQUIRED

Checklist
✅ / ❌ Uses design tokens only
✅ / ❌ Accessible (keyboard, focus, semantic HTML)
✅ / ❌ Responsive (mobile / tablet / desktop)
✅ / ❌ No duplicated CSS
✅ / ❌ No hardcoded values
✅ / ❌ Blade reusable
✅ / ❌ Reusable in 3+ places without modification

Issues Found
- ... (or "None")

Decision
Approved | Changes required
```
