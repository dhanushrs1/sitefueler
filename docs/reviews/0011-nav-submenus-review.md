# Navigation Submenus Review

**Branch:** `feature/nav-submenus`
**Status:** PASS ✅

Added dropdown submenus (desktop), accordion submenus + social links in the
off-canvas drawer (with a fuller menu set), and a smoother drawer slide.

---

## Desktop dropdowns
- ✅ Items with `children` render a dropdown (Templates, Plugins, Services)
- ✅ Open on **hover** and **focus-within** (keyboard accessible, no JS)
- ✅ `aria-haspopup="true"`; chevron rotates when open; 200ms fade/slide
- ✅ Minimal card: surface bg, 1px border, `--radius-md`, `--shadow-md`
- ✅ Hover bridge (padding) prevents flicker between trigger and panel
- ✅ Parent stays `is-active` on child routes

## Off-canvas drawer
- ✅ **Fuller menu** from `config/navigation.drawer` (adds Pricing, Documentation,
  About) — more than the header
- ✅ **Accordion submenus** via native `<details>`/`<summary>` (accessible, no JS),
  chevron rotates on `[open]`, includes an "All <section>" link to the parent
- ✅ Restructured drawer: scrollable body + pinned footer (CTAs + social)
- ✅ **Social follow** row (X, GitHub, LinkedIn, YouTube) — reusable `x-social-links`
- ✅ Smoother slide: `transform 0.34s cubic-bezier(0.16, 1, 0.3, 1)`

## Icons
- ✅ All social + chevron icons are **stroked** (no filled icons)

## Accessibility
- ✅ Dropdowns reachable by keyboard (focus-within); links in logical order
- ✅ Drawer is `role="dialog"`/`aria-modal`; Escape + scroll lock + focus return
- ✅ Social links have `aria-label`, `rel="noopener noreferrer"`, decorative SVGs
- ✅ Visible focus on triggers, summaries, and social buttons

## Technical
- ✅ Token-based; config-driven (primary / drawer / social)
- ✅ No JS for dropdowns or accordion (CSS + native `<details>`)
- ✅ Reusable `social-links` component (footer can adopt it later)

## Visual QA
Verified via running server (markup + served CSS): 3 desktop dropdowns, 3 drawer
accordion groups, extra drawer items, social row, improved easing present.

> Limitation: verified through rendered HTML + served CSS, not a live browser.
> Recommend a real-browser pass for hover/animation feel.

## Notes & decisions
- Drawer slide uses a slightly longer 0.34s easing (a large off-canvas movement
  reads better than a 200ms micro-transition) — documented exception, like the
  spinner.
- Drawer scrim uses the documented `rgba` scrim literal.

## Decision
**Approved.** Submenus are clean and minimal across desktop and mobile.
