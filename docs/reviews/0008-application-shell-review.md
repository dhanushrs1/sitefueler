# Application Shell Review

**Feature:** Application Shell (Milestone 3)
**Branch:** `feature/application-shell`
**Status:** PASS ✅

Covers: layout templates, Header, Navigation, Search bar, Footer, Breadcrumb,
Page Title, Empty State, and the 404 layout. Every piece **composes existing
components** (Button, Form) rather than reinventing them.

---

## Checklist

### Application shell / layouts
- ✅ `layouts/app.blade.php` — base document (head, asset links, `@yield('body')`,
  `@stack` for styles/scripts)
- ✅ `layouts/marketing.blade.php` — Header → `main` → Footer (implemented)
- ✅ `layouts/auth`, `layouts/dashboard`, `layouts/error` — placeholders
  (error layout is functional for 404)
- ✅ All marketing pages re-pointed to `layouts.marketing`

### Header (composes Button + Form)
- ✅ Logo, Navigation (centered), Search, Login (Ghost), Get Started (Primary)
- ✅ Sticky, 80px, white, bottom border (`header.md`)
- ✅ Login/Get Started use `x-button`; search bar uses `x-search-bar` (Form System)
- ✅ Mobile: hamburger + logo + search icon; nav + CTAs collapse into a panel
  with `aria-expanded` / `aria-controls` (toggled in `app.js`)

### Navigation (config-driven)
- ✅ Reads `config/navigation.php` (`primary`) — no hardcoded items
- ✅ Active item via `request()->is()` → `is-active` + `aria-current="page"`
- ✅ `children` key reserved for future dropdowns/mega-menus (no redesign needed)

### Footer (composes Button + config)
- ✅ Dark, three columns (brand + Product + Company), simple
- ✅ Link columns + legal bar read from `config/navigation.php`
- ✅ Get Started uses `x-button`

### Layout components
- ✅ Breadcrumb (ordered list, separators, `aria-current` on last)
- ✅ Page Title (heading + subtitle + breadcrumb slot + actions slot)
- ✅ Empty State (icon + title + message + actions; used by 404)
- ✅ Search Bar (built on `x-form.input type="search"`, `role="search"`)

### 404
- ✅ `errors/404.blade.php` uses `layouts.error` + Empty State + Button
- ✅ Returns HTTP 404 with the styled page

### Accessibility
- ✅ Landmarks: `<header>`, `<nav aria-label>`, `<main id="main">`, `<footer>`
- ✅ Hamburger exposes `aria-expanded`/`aria-controls`; closes on link click
- ✅ Visible focus on nav links, burger, buttons
- ✅ Footer light text on dark uses `--color-gray-300` for adequate contrast

### Technical
- ✅ Token-based (no hardcoded colors/spacing/radii); composes prior components
- ✅ Navigation/footer data externalized to config
- ✅ Split CSS under `components/` (header, footer, breadcrumb, page-title,
  empty-state) aggregated by `components.css`
- ✅ Reusable, no page-specific assumptions

### Documentation
- ✅ Review document (this file)
- ✅ Changelog + release notes (`v0.3.0`)

---

## Visual QA

Per the new workflow step. Verified via the running server (rendered markup +
served CSS) at the design-system breakpoints:

- **Desktop (≥1024):** logo left, centered nav, right actions (search/login/CTA);
  hamburger hidden.
- **< 1024 (tablet/mobile):** nav + CTAs hidden, hamburger shown; panel reveals
  search bar, nav links, and full-width Login / Get Started.
- **Footer:** three columns ≥768px, stacked below; bottom bar stacks < 640px.
- Focus states present on interactive elements; 200ms transitions; reduced-motion
  respected by the shared rules.

> Limitation: this was verified through rendered HTML and the served stylesheet,
> not a live browser session or real-device testing. A visual pass in actual
> browsers (and at 125%/150% zoom) is recommended before public launch.

## Notes & decisions

- **Desktop search** keeps the icon trigger from `header.md` (expandable search is
  a future enhancement); the reusable **Search Bar** (Form-based) is used in the
  mobile panel and is ready for `/search` results pages.
- **Layout templates** are split now (`auth`/`dashboard`/`error` as placeholders)
  to avoid a major refactor later, per the milestone plan.

## Decision

**Approved.** The Application Shell meets the milestone scope and the Definition
of Done, and gives every future page a consistent home. Proceed to close
Milestone 3 and tag `v0.3.0`.
