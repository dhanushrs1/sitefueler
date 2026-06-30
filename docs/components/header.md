# Header Component v1.0

> Component specification only. No HTML, CSS, Blade, or JavaScript.
> Every design decision is made here so implementation is pure execution.
> All visual values reference tokens in `variables.css` (see `design-system.md`).

---

## 1. Purpose

Provide global, persistent navigation across SiteFueler so users can reach the
primary areas of the product from any page. The header is the top-level wayfinding
element and the home of the primary "Get Started" conversion action.

---

## 2. Structure

The header is a single sticky bar divided into three regions, aligned within the
standard container.

| Region | Position | Contents                                        |
| ------ | -------- | ----------------------------------------------- |
| Logo   | Left     | SVG wordmark logo                               |
| Nav    | Left     | Primary navigation links (next to the logo)     |
| Actions| Right    | Login, Get Started                              |

**Layout tokens:**

| Property      | Value                          |
| ------------- | ------------------------------ |
| Height        | 64px (`--navbar-height`)       |
| Container     | 1320px (`--content-width`)     |
| Background    | White (`--color-background`)   |
| Bottom border | 1px solid `--color-border`     |
| Position      | Sticky (`--z-sticky`)          |

**Navigation items (initial):**

- Home
- Templates
- Plugins
- Services
- Blog
- Contact

Nothing more for v1.0. Nav links use a light weight (medium), not bold.

**Right-side actions:**

- **Login** — Ghost button (small).
- **Get Started** — Primary button (small).

No search in the header (a reusable, Form-based Search Bar exists separately for
search/results pages).

**Logo:** SVG wordmark (two-tone — wordmark in text color, mark in brand orange).

---

## 3. Behavior

| Behavior      | v1.0  | Notes                                            |
| ------------- | ----- | ------------------------------------------------ |
| Sticky        | Yes   | Stays pinned to the top while scrolling          |
| Shrink        | No    | Height stays fixed at 64px                       |
| Transparent   | No    | Always solid white background                    |
| Shadow        | No    | Depth comes from the bottom border only          |
| Border        | Yes   | 1px bottom border, `--color-border`              |
| Dropdowns     | None  | Reserved for a later version                     |

- **Search:** a simple icon button in v1.0. Clicking it will later open an
  expandable search; for now it is a placeholder trigger.
- **Login:** Ghost button, navigates to the login page.
- **Get Started:** Primary button, the header's main call to action.
- All transitions (hover, focus) use **200ms** (`--duration-normal`).

---

## 4. Responsive Behavior

| Breakpoint        | Header layout                                            |
| ----------------- | -------------------------------------------------------- |
| Desktop (≥1280)   | Full navigation visible; logo left, nav center, actions right |
| Tablet (≥768)     | Navigation collapsed; condensed actions                  |
| Mobile (<768)     | Hamburger (left), Logo (center), Search (right)          |

- On mobile, the primary links move behind a hamburger menu.
- The mobile bar shows three elements only: **Hamburger · Logo · Search**.
- Login / Get Started move into the opened mobile menu.
- Breakpoints follow `design-system.md` §9 (640, 768, 1024, 1280, 1536).

---

## 5. Accessibility

- **Semantic HTML:** rendered as a `<header>` with a `<nav>` landmark for the
  primary links.
- **Keyboard:** every link and action is reachable and operable by keyboard in a
  logical tab order.
- **Visible focus:** all interactive elements show a clear focus state (never
  remove the outline without a visible replacement).
- **ARIA:** the navigation has an accessible label; the hamburger toggle exposes
  `aria-expanded` and controls the mobile menu via `aria-controls`. The search
  trigger has an accessible name.
- **Animation:** motion limited to 200ms; respects reduced-motion preferences.

**Interactive states (all interactive elements):**

- Normal
- Hover
- Active
- Focus

---

## 6. Variants

v1.0 ships a single header variant: the **standard marketing header** described
above. No alternate headers yet.

Anticipated future variants (not designed yet):

- Dashboard header (authenticated app shell)
- Minimal header (auth/checkout flows, reduced actions)
- No-header layouts (full-bleed landing pages)

These are noted only so the component stays flexible; they are out of scope for
v1.0.

---

## 7. Future Enhancements

- Replace the text logo with the official **SVG logo**.
- **Expandable search** instead of a simple icon trigger.
- **Dropdown menus** for navigation items (e.g., Templates, Services categories).
- Mega-menu support for large category sets.
- Optional sticky-shrink behavior (currently explicitly disabled).
- Active-route highlighting for the current page.
