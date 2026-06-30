# SiteFueler

Modern Laravel platform for WordPress templates, plugins, services, and digital
resources.

## Status

- **Milestone 1 — Foundation:** ✅ Complete (`v0.1.0`)
- **Milestone 2 — Core UI Components:** ✅ Complete (`v0.2.0`, refined in `v0.2.1`)
- **Milestone 3 — Layout Components:** ✅ Complete (`v0.3.0`, polished in `v0.3.1`)
- **Milestone 4 — Admin Foundation:** ✅ Complete (`v0.4.0`)
- **Milestone 5 — Identity & Authentication:** ✅ Complete (`v0.5.0`; Google + auth polish in `v0.5.1`; OAuth SSL fix in `v0.5.2`; **2FA & account security in `v0.6.0`**)
- **Next:** Template Management (first business module)

## Technology

- Laravel 13
- PHP 8.4
- MySQL
- Blade
- Vanilla CSS
- Vanilla JavaScript

No Tailwind, Bootstrap, jQuery, React, Vue, Alpine, or Sass — by design, for a
simple, fast, and easy-to-deploy stack (Apache / shared hosting).

## License

Proprietary — © 2026 SiteFueler, all rights reserved. This is commercial software;
see [`LICENSE`](LICENSE). The repository is private during active development.

## Documentation

- [`docs/design-system.md`](docs/design-system.md) — global visual rules and tokens
- [`docs/components/`](docs/components) — per-component specifications
- [`docs/architecture/`](docs/architecture) — how the system works
- [`docs/meetings/`](docs/meetings) — Architecture Decision Records (ADRs)
- [`docs/reviews/`](docs/reviews) — component review records
- [`docs/releases/`](docs/releases) — release notes
- [`CHANGELOG.md`](CHANGELOG.md) — release history
- [`ROADMAP.md`](ROADMAP.md) — milestones and planned versions
- [`CONTRIBUTING.md`](CONTRIBUTING.md) — principles, branching, commits, workflow

## Project structure

```
app/            Application code (Http, Models, Services, Repositories, ...)
docs/           Design system, component specs, architecture
public/assets/  Static CSS, JS, images, icons, fonts (served directly)
resources/views Blade layouts, partials, pages, components
routes/         Route definitions
```

## Getting started (local)

```bash
# 1. Configure environment
cp .env.example .env   # then set DB_* values (MySQL: sitefueler_db)

# 2. App key (if needed)
php artisan key:generate

# 3. Migrate
php artisan migrate

# 4. Run
php artisan serve
```

Open http://127.0.0.1:8000.
