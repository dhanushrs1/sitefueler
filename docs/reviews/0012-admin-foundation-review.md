# Admin Foundation Review

**Feature:** Admin Foundation (Milestone 4)
**Branch:** `feature/admin-foundation`
**Status:** PASS ✅

The admin shell — auth, layout, sidebar, topbar, dashboard, profile, breadcrumb,
logout, route protection. No business modules yet.

---

## Deliverables
- ✅ **Admin Login** — email/password, CSRF, validation, rejects non-admins
- ✅ **Admin Layout** — `admin/layouts/app.blade.php` (loads app.css + admin.css)
- ✅ **Sidebar** — config-driven (`config/admin.php`), active state, disabled
  placeholders for unbuilt modules, off-canvas on mobile
- ✅ **Topbar** — mobile burger, page title, notifications + profile dropdowns
- ✅ **Dashboard** — six stat cards (Templates/Plugins/Services/Users/Orders/Revenue)
- ✅ **Breadcrumb** — default Admin / page, overridable per page
- ✅ **Profile dropdown** — Profile / Settings / Logout; profile page (update name/email)
- ✅ **Logout** — POST, session invalidation
- ✅ **Route protection** — `auth` + `admin` (EnsureUserIsAdmin) middleware;
  guests redirect to `admin.login`

## Verified (runtime)
- `/admin/login` → 200, form renders, CSRF token present
- `/admin` as guest → **302 → /admin/login**
- Login POST (`admin@sitefueler.test`) → redirect to `/admin`
- `/admin` authenticated → 200 with sidebar, stat cards, profile name
- `admin.css` / `admin.js` serve 200
- Migration (`is_admin`) + seeder ran successfully

## Architecture
- ✅ Module isolation: `Http/Controllers/Admin/*`, `resources/views/admin/*`,
  `public/assets/admin/*`
- ✅ Grouped, **named** routes (`admin.`) — future `Route::resource` plugs in cleanly
- ✅ Reuses the design system (tokens, Button, Form, Alert components)
- ✅ Config-driven sidebar + dashboard cards
- ✅ Stroked icons only (`x-admin.icon`)

## Accessibility
- ✅ Landmarks (`<aside>`, `<header>`, `<main>`, `<nav aria-label>`)
- ✅ Dropdowns: `aria-haspopup`/`aria-expanded`, Escape + outside-click close
- ✅ Sidebar off-canvas: `aria-expanded`, Escape, backdrop, scroll lock
- ✅ Visible focus throughout

## Visual QA
Sidebar + topbar + dashboard verified via rendered markup + served CSS at desktop
and mobile (off-canvas) breakpoints.
> Limitation: not a live-browser/device pass.

## Notes & decisions
- Single `users` table + `is_admin` flag (not a separate guard) — simplest now;
  a dedicated `admin` guard remains an option later.
- Default admin credentials are dev-only and must change before deployment.

## Decision
**Approved.** The admin foundation is in place; modules (Templates first) can now
plug into `/admin/*` and the frontend simultaneously.
