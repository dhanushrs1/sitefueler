# Authentication — Admin (v0.4.0)

**Status:** Accepted

How admin access works in SiteFueler today. This covers the **admin** area only;
customer/frontend auth is a later milestone.

## Approach

- Uses Laravel's default session auth (`web` guard) against the `users` table.
- An `is_admin` boolean column (migration) marks admin accounts.
- A custom middleware `EnsureUserIsAdmin` (alias `admin`) allows only authenticated
  users with `is_admin = true`; everyone else gets a 403.
- Unauthenticated requests to protected routes redirect to `admin.login`
  (`redirectGuestsTo` in `bootstrap/app.php`).

## Routes (named, grouped)

```
GET  /admin/login   admin.login          AuthController@showLogin
POST /admin/login   admin.login.attempt  AuthController@login
GET  /admin         admin.dashboard      DashboardController@index   [auth, admin]
GET  /admin/profile admin.profile        ProfileController@index     [auth, admin]
PUT  /admin/profile admin.profile.update ProfileController@update    [auth, admin]
POST /admin/logout  admin.logout         AuthController@logout       [auth, admin]
```

Future modules add `Route::resource(...)` inside the `[auth, admin]` group, so
`route('admin.templates.index')` etc. work without hardcoded URLs.

## Login flow

1. `showLogin` renders the form (and redirects already-signed-in admins to the
   dashboard).
2. `login` validates email/password, attempts auth, and **rejects non-admins**
   (logs them back out with an error). On success it regenerates the session and
   redirects to the intended URL or the dashboard.
3. `logout` invalidates the session and regenerates the CSRF token.

## Default admin (dev)

Seeded by `AdminUserSeeder`:

- Email: `admin@sitefueler.test`
- Password: `password`

> Change this before any non-local deployment.

## Future

- Google login (frontend customers only — not admin).
- Optional 2FA for admin.
- Separate `admin` guard if admin and customer auth need to diverge.
