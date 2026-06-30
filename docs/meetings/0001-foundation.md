# 0001 — Foundation

**Status:** Accepted
**Milestone:** 1 (Foundation, v0.1.0)

Architectural decisions made while establishing the project foundation.

---

## 1.1 — No CSS framework (No Tailwind / Bootstrap)

- **Decision:** Hand-written vanilla CSS built on a design-token system.
- **Reason:** SiteFueler targets Laravel on Apache / shared hosting and a simple,
  fast, easy-to-deploy stack. A custom system keeps full control of the output and
  avoids framework weight and lock-in.
- **Alternatives:** Tailwind CSS, Bootstrap.

## 1.2 — No front-end build step (static assets)

- **Decision:** Serve CSS/JS directly from `public/assets/` via the `asset()`
  helper; no Vite/Tailwind build pipeline.
- **Reason:** Shared hosting deployment is simpler with static files; no Node build
  required on the server. Removed Vite + Tailwind tooling accordingly.
- **Alternatives:** Vite bundling, Laravel Mix.

## 1.3 — Vanilla JavaScript only

- **Decision:** Plain JS in a single `app.js` (split later if needed).
- **Reason:** Avoids SPA frameworks and jQuery; keeps the front end light and the
  mental model simple.
- **Alternatives:** React, Vue, Alpine, jQuery.

## 1.4 — MySQL database

- **Decision:** MySQL (`sitefueler_db`) via `pdo_mysql`.
- **Reason:** Standard, well-supported on Hostinger/shared hosting.
- **Alternatives:** SQLite (Laravel default), PostgreSQL.

## 1.5 — Tokens-first CSS architecture

- **Decision:** A frozen `variables.css` is the single source of truth; layers load
  in order variables → layout → utilities → components. No hardcoded design values.
- **Reason:** Changing one token updates the whole UI consistently and prevents a
  sprawling, unmaintainable stylesheet.
- **Alternatives:** Per-page CSS, inline styles, ad-hoc values.

## 1.6 — Documentation-first design system

- **Decision:** Write the design system and per-component specs before any code,
  stored in `docs/`.
- **Reason:** By the time we implement, no design decisions remain — implementation
  becomes pure execution and stays consistent.
- **Alternatives:** Design while coding.
