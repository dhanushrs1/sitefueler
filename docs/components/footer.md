# Footer Component v1.0

> Component specification only. No HTML, CSS, Blade, or JavaScript.
> Defines the global site footer.
> All visual values reference tokens in `variables.css` (see `design-system.md`).
> Depends on: Button (`button.md`), Typography (design-system §3).

---

## 1. Purpose

Close every page with consistent secondary navigation, brand reinforcement, and
legal/contact information. The footer is the bottom anchor of the layout and the
home for links that don't belong in the primary header navigation.

---

## 2. Structure

A dark, three-column footer with a bottom bar, aligned within the standard
container.

| Region        | Required | Notes                                          |
| ------------- | -------- | ---------------------------------------------- |
| Column 1      | Yes      | Brand (text logo) + short description           |
| Column 2      | Yes      | Navigation links (Product / Company / etc.)     |
| Column 3      | Yes      | Contact and/or social links                     |
| Newsletter    | Optional | Email input (Form) + Primary button (Button)    |
| Bottom bar    | Yes      | Copyright + legal links (Privacy, Terms)        |

**Shared base tokens:**

| Property       | Value                                       |
| -------------- | ------------------------------------------- |
| Background     | `--color-dark`                               |
| Text color     | `--color-white` / muted white                |
| Container      | `--content-width` (1320px)                   |
| Vertical pad   | `--section-gap` (96px) top, smaller bottom    |
| Column gap     | `--space-48`                                  |
| Heading size   | `--text-h5`, `--font-weight-semibold`         |
| Link size      | `--text-body`                                 |
| Bottom bar text| `--text-small`                               |
| Divider        | 1px subtle line above the bottom bar          |
| Transition     | 200ms (`--duration-normal`, `--ease`)         |

Style is intentionally **simple** — no heavy decoration (design-system §18, §21.7).

---

## 3. Variants

Single standard footer in v1.0. Possible future variants (minimal footer for
auth/checkout, app/dashboard footer) are noted in §10 but out of scope now.

---

## 4. Sizes

Not applicable. The footer fills the page width; its height is content-driven via
the three columns and bottom bar.

---

## 5. States

The footer is largely static. Interactive elements have states:

| Element       | States                                          |
| ------------- | ----------------------------------------------- |
| Links         | Normal, Hover, Focus                            |
| Newsletter    | Form + Button states per their specs            |

No disabled/loading state for the footer container itself.

---

## 6. Behavior

- Links navigate; on a dark background, hover uses a lighter/white emphasis at 200ms.
- The optional newsletter reuses the Form input and a Primary Button — no bespoke
  styling.
- The footer is not sticky; it sits at the natural end of page content.
- Brand area shows the text logo "SiteFueler" (real SVG later, matching the header).

---

## 7. Accessibility

- **Landmark:** rendered as a `<footer>` (contentinfo) landmark.
- **Navigation:** grouped link lists use `<nav>` with accessible labels and real
  list markup.
- **Contrast:** light text on the dark background must meet WCAG AA (use white /
  sufficiently light muted tone, not low-contrast gray). (Full WCAG validation
  requires manual testing.)
- **Keyboard:** all links and the newsletter form are keyboard operable with
  visible focus (focus must remain visible against the dark background).
- **Headings:** column headings use appropriate heading levels for structure.

---

## 8. Responsive Behavior

- Desktop/laptop: three columns side by side.
- Tablet: columns may collapse to two.
- Mobile (<768px): columns **stack vertically** (design-system §18), full width;
  the bottom bar stacks copyright above legal links.
- Vertical padding may reduce on mobile while preserving rhythm from the spacing scale.

---

## 9. Usage Rules

- Keep it simple — secondary navigation and essentials only, not a sitemap dump.
- Use the dark background and light text consistently on every page that has a footer.
- Newsletter (if present) uses Form + Button components, never custom controls.
- Legal links (Privacy, Terms) always live in the bottom bar.
- Never hardcode colors, spacing, or radius — use tokens.

---

## 10. Future Enhancements

- **Minimal footer** variant for auth/checkout flows.
- **Dashboard/app footer** (condensed) for authenticated areas.
- **Real SVG logo** replacing the text logo.
- **Locale / currency switcher.**
- **Social icon row** using Lucide / official brand marks.
- **Back-to-top** control.
