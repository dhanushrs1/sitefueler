# Shell v2 Review — Font, Mobile Drawer, Cart, Footer CTA

**Branch:** `feature/shell-v2`
**Status:** PASS ✅

Four changes: site-wide font → Instrument Sans, right-side off-canvas mobile
drawer, header cart icon, and a redesigned footer with an overlapping CTA card
(brand colors, referencing the supplied layout).

---

## 1. Font — Instrument Sans (site-wide)
- ✅ `--font-family-base` → `'Instrument Sans', …` (single token, applies everywhere)
- ✅ Loaded via Bunny Fonts (privacy-friendly, no JS) with `preconnect` in `app.blade.php`
  — weights 400/500/600/700 (verified CSS returns 200)
- ✅ Weight tokens clamped to Instrument Sans range (light→400, extrabold→700) to
  avoid faux weights
- ✅ Docs synced: `design-system.md` §3 + §21.1
- Note: line-heights/spacing tokens unchanged — Instrument Sans metrics sit well
  with the existing scale; no layout breakage observed.

## 2. Mobile off-canvas drawer
- ✅ Below 1024px, nav + CTAs move into a **right-side drawer** that slides in/out
- ✅ Opens from hamburger; closes via X, backdrop click, or **Escape**
- ✅ Background scroll locked (`body.nav-open`); focus moves to close button and
  returns to the opener on close
- ✅ `role="dialog"` + `aria-modal`; opener keeps `aria-expanded` in sync
- ✅ 200ms slide; reduced-motion respected
- ✅ Drawer is `display:none` at ≥1024 (never interferes with desktop)

## 3. Cart icon
- ✅ Stroked Lucide `shopping-cart` (no filled icons), visible at all breakpoints
- ✅ Renders as an `<a href="/cart">` with `aria-label="Cart"` and visible focus
- ✅ Placeholder for future cart functionality

## 4. Footer — CTA card + dark columns
- ✅ Overlapping **CTA card** (brand orange gradient) straddling the page/footer
  seam via a split-background band (white top / dark bottom)
- ✅ CTA form built on the **Form System** (Name / Email / Mobile in a 3-col row,
  details textarea, Submit button) — no custom inputs; aria-labels for a11y
- ✅ Dark three-column footer: brand + **Best Selling** + **Useful Links**
  (config-driven), plus copyright + legal bottom bar
- ✅ Our color/design tokens used throughout (not the reference's teal)
- ✅ White logo; lighter uppercase headings

---

## Visual QA
Verified via running server (markup + served CSS):
- Desktop ≥1024: logo + left nav + cart + Login + Get Started; drawer hidden.
- < 1024: logo + cart + hamburger; drawer slides from the right with nav + CTAs.
- Footer: CTA card overlaps the seam; 3-up form ≥768px (stacks below); columns
  3-up ≥768px; bottom bar stacks < 640px.

> Limitation: verified through rendered HTML + served CSS and the font CSS
> endpoint (HTTP 200), not a live browser/device. A real-browser pass (and zoom
> 125%/150%) is recommended.

## Notes
- Backdrop/scrim uses an `rgba` literal (same documented exception as the modal).
- CTA card gradient uses `--color-primary` → `--color-primary-hover`.

## Decision
**Approved.** Header and footer are cleaner, on-brand, and mobile-friendly.
