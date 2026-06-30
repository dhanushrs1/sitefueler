# SiteFueler Design System v1.0

> This document is the single source of truth for SiteFueler's visual and
> interaction design. Every section is written as an engineering specification:
> **Purpose** (why the rule exists), **Rule** (what must be followed),
> **Examples** (where it applies), and **Exceptions** (if any).
>
> Implementation order: this doc → `variables.css` → `utilities.css` →
> `layout.css` → `components.css` → Homepage. Documentation and code must stay
> in sync. If a rule changes, update this file first.

---

## 1. Brand Identity

**Purpose:** Establish a consistent personality so every page feels like the
same product, and so design decisions can be judged against a shared standard.

**Rule:** SiteFueler is **Minimal, Professional, Modern, Developer Friendly,
Premium, Fast, and Clean**. When two design options compete, choose the one that
is simpler, uses more white space, and looks more trustworthy.

Brand keywords to design against:

- Simple
- White Space
- Trustworthy
- Premium
- Functional

**Examples:**
- A landing section with generous padding and one clear call to action → on brand.
- A page crowded with five banners and three popups → off brand.

**Exceptions:** None. The brand identity applies to every screen.

---

## 2. Color System

**Purpose:** A fixed palette guarantees visual consistency and accessible
contrast, and prevents an explosion of one-off color values across the codebase.

**Rule:** Use only the colors below. They will be defined as CSS variables in
`variables.css`. Never hard-code a hex value that is not in this table.

| Token            | Value     | Usage                                   |
| ---------------- | --------- | --------------------------------------- |
| Primary          | `#FF5E00` | Primary actions, key highlights         |
| Primary Hover    | `#E04F00` | Hover/active state of primary elements  |
| Primary Light    | `#FF8A47` | Subtle accents, light tints             |
| Dark             | `#0A0D14` | Footer background, dark surfaces         |
| Heading          | `#0F172A` | Headings (H1–H5)                        |
| Body             | `#334155` | Body / paragraph text                   |
| Muted            | `#64748B` | Secondary text, captions, placeholders  |
| Background       | `#FFFFFF` | Page background                         |
| Surface          | `#FFFFFF` | Cards, panels, raised surfaces          |
| Border           | `#E2E8F0` | Borders around inputs, cards            |
| Divider          | `#E2E8F0` | Horizontal/vertical separators          |
| White            | `#FFFFFF` | Text on dark backgrounds, reset color   |

**Semantic / feedback colors** (status only — do not use for branding or
decoration):

| Token   | Value     | Usage                          |
| ------- | --------- | ------------------------------ |
| Success | `#16A34A` | Success alerts/badges, valid   |
| Warning | `#D97706` | Warning alerts/badges          |
| Danger  | `#DC2626` | Error/destructive alerts, Danger buttons |
| Info    | `#2563EB` | Informational alerts/messages  |

**Examples:**
- "Buy Now" button background → Primary, hover → Primary Hover.
- Card border → Border. Section heading → Heading. Paragraph → Body.

**Exceptions:** The semantic colors above are the only colors allowed outside the
neutral/brand palette, and they are reserved exclusively for status feedback.

---

## 3. Typography

**Purpose:** A single typeface and a fixed type scale create rhythm and
hierarchy, and stop developers from inventing arbitrary font sizes.

**Rule:** Use **Be Vietnam Pro** as the only font family. Allowed weights:
**300, 400, 500, 600, 700, 800**. Use only the sizes in the scale below (px).

| Level   | Size | Typical Weight |
| ------- | ---- | -------------- |
| Hero    | 56   | 700 / 800      |
| H1      | 48   | 700            |
| H2      | 40   | 700            |
| H3      | 32   | 600            |
| H4      | 24   | 600            |
| H5      | 20   | 600            |
| Body    | 16   | 400            |
| Small   | 14   | 400 / 500      |
| Caption | 12   | 400 / 500      |

**Examples:**
- Homepage hero headline → Hero (56).
- Section title → H2 (40). Paragraph copy → Body (16). Form helper text → Small (14).

**Exceptions:** None. Any size not in the scale must be added here first before
being used.

---

## 4. Container

**Purpose:** Consistent maximum widths and spacing keep content readable and
aligned across every page.

**Rule:**

| Token         | Value    | Meaning                                  |
| ------------- | -------- | ---------------------------------------- |
| Desktop       | 1440px   | Reference design width                   |
| Content Width | 1320px   | Max width of the centered content area   |
| Section Gap   | 96px     | Vertical space between major sections    |
| Card Gap      | 24px     | Gap between cards in a grid              |

**Examples:**
- The main container caps at 1320px and centers within a 1440px viewport.
- Between the Hero section and the Features section → 96px gap.

**Exceptions:** Full-bleed backgrounds (e.g., a colored band) may span the full
viewport width, but their inner content still respects the 1320px content width.

---

## 5. Border Radius

**Purpose:** Uniform corner rounding is a strong, cheap signal of a premium,
cohesive product.

**Rule:**

| Element | Radius |
| ------- | ------ |
| Button  | 12px   |
| Input   | 12px   |
| Card    | 16px   |
| Image   | 16px   |
| Badge   | 999px  |

**Examples:**
- Product card corners → 16px. Primary button corners → 12px. "Sale" badge → 999px (pill).

**Exceptions:** Decorative elements such as avatars may be fully round (`50%`).

---

## 6. Shadow

**Purpose:** Limiting elevation to three levels keeps depth meaningful and the
UI calm.

**Rule:** Only three shadows exist — **Small, Medium, Large**. Nothing else.

| Shadow | Usage                                         |
| ------ | --------------------------------------------- |
| Small  | Subtle lift: inputs, low-emphasis cards       |
| Medium | Standard cards, dropdowns                     |
| Large  | Modals, popovers, prominent floating elements |

**Examples:**
- Default product card → Medium. Modal dialog → Large. Focused input → Small.

**Exceptions:** None. Do not invent a fourth shadow; pick the closest of the three.

---

## 7. Spacing Scale

**Purpose:** A single spacing scale produces consistent rhythm and makes layouts
predictable to build and review.

**Rule:** All margins, paddings, and gaps must use one of these values (px):

`4, 8, 12, 16, 20, 24, 32, 40, 48, 64, 80, 96, 120`

**Examples:**
- Padding inside a card → 24. Gap between form fields → 16. Section padding → 96.

**Exceptions:** `0` is always allowed. `1px` is allowed for borders/dividers only.

---

## 8. Grid

**Purpose:** A defined column system keeps content aligned and responsive without
ad-hoc layouts.

**Rule:** Column counts adapt to the device:

| Device  | Columns |
| ------- | ------- |
| Desktop | 4       |
| Laptop  | 3       |
| Tablet  | 2       |
| Mobile  | 1       |

**Examples:**
- A product grid shows 4 cards per row on desktop, collapsing to 1 per row on mobile.

**Exceptions:** Editorial layouts (e.g., a two-column article) may define their
own column split, but must still align to the container in Section 4.

---

## 9. Breakpoints

**Purpose:** Shared breakpoints guarantee that responsive behavior is consistent
across every stylesheet and component.

**Rule:** Use only these breakpoints (px):

`640, 768, 1024, 1280, 1536`

Mapping to the grid in Section 8:

| Breakpoint | Range target        | Grid columns |
| ---------- | ------------------- | ------------ |
| < 640      | Mobile              | 1            |
| 768        | Tablet              | 2            |
| 1024       | Laptop              | 3            |
| 1280       | Desktop             | 4            |
| 1536       | Large desktop       | 4            |

**Examples:**
- A media query at `768px` switches a 1-column stack into a 2-column grid.

**Exceptions:** None. Do not introduce custom breakpoints.

---

## 10. Icon System

**Purpose:** One icon library guarantees a consistent stroke weight, sizing, and
visual language.

**Rule:** Use **Lucide Icons** only. No other icon set, emoji as icons, or
custom one-off SVGs for standard UI actions.

**Examples:**
- Cart icon, search icon, menu icon → all from Lucide.

**Exceptions:** Brand logos (e.g., third-party payment or social logos) are not
icons and may use their official assets.

---

## 11. Buttons

**Purpose:** Provide a consistent, predictable action style throughout the
application so users instantly understand intent.

**Rule:** Use only **Primary, Secondary, Ghost, or Danger** buttons. All buttons
use 12px radius (Section 5) and the spacing scale (Section 7).

| Variant   | Meaning                                  |
| --------- | ---------------------------------------- |
| Primary   | The main action on a screen             |
| Secondary | An alternative, lower-emphasis action   |
| Ghost     | Tertiary / dismissive action            |
| Danger    | Destructive action                      |

**Examples:**
- Buy Now → Primary
- View Details → Secondary
- Cancel → Ghost
- Delete → Danger

**Exceptions:** None.

---

## 12. Forms

**Purpose:** A unified form design makes inputs feel like one family and keeps
validation and focus states predictable.

**Rule:** Inputs, Textarea, Select, Checkbox, Radio, and Switch all share the
same design language: 12px radius for text fields (Section 5), Border color for
resting borders, Small shadow on focus, and spacing from Section 7.

**Examples:**
- A text input and a select dropdown in the same form have identical height,
  border, radius, and focus treatment.
- A checkbox and a radio share the same accent (Primary) and sizing.

**Exceptions:** A Switch is visually a toggle rather than a box, but it must use
the same Primary accent and 200ms animation (Section 20).

---

## 13. Cards

**Purpose:** A single card foundation prevents divergent card styles and keeps
grids visually uniform.

**Rule:** There is **one base card** (Surface background, 16px radius, Medium
shadow, 24px internal padding). Product, Service, and Blog cards all inherit this
base and only add their own content layout.

**Examples:**
- Product card = base card + image + title + price + button.
- Blog card = base card + cover image + title + excerpt + date.

**Exceptions:** None. New card types must extend the base, not redefine it.

---

## 14. Tables

**Purpose:** One table style keeps admin and data views legible and consistent.

**Rule:** Admin tables use a single style: Divider lines between rows, Heading
color for column headers, Body color for cells, and spacing from Section 7. No
alternate table themes.

**Examples:**
- Orders table, Users table, and Products table in the admin panel look identical
  in structure and spacing.

**Exceptions:** None.

---

## 15. Badges

**Purpose:** Badges communicate product/item status at a glance with a fixed,
recognizable set.

**Rule:** Only these badges exist: **New, Sale, Best Seller, Featured, Out of
Stock**. All use the 999px pill radius (Section 5).

| Badge        | Typical use                          |
| ------------ | ------------------------------------ |
| New          | Recently added items                 |
| Sale         | Discounted items                     |
| Best Seller  | Top-selling items                    |
| Featured     | Editorially promoted items           |
| Out of Stock | Unavailable items                    |

**Examples:**
- A discounted template shows a "Sale" badge on its card.

**Exceptions:** None. Do not invent new badge labels without adding them here.

---

## 16. Alerts

**Purpose:** Consistent, color-coded feedback helps users immediately understand
the severity of a message.

**Rule:** Only four alert types: **Success, Warning, Danger, Info**, mapped to
the semantic colors defined in Section 2.

| Alert   | Color token        | Value     | Meaning                              |
| ------- | ------------------ | --------- | ------------------------------------ |
| Success | `--color-success`  | `#16A34A` | Operation completed successfully     |
| Warning | `--color-warning`  | `#D97706` | Caution; action may have consequences|
| Danger  | `--color-danger`   | `#DC2626` | Error or failed/destructive outcome  |
| Info    | `--color-info`     | `#2563EB` | Neutral, informational message       |

**Examples:**
- "Order placed" → Success. "Payment failed" → Danger. "Low stock" → Warning.

**Exceptions:** None.

---

## 17. Navbar

**Purpose:** A predictable, always-available navigation bar anchors the user
experience across the site.

**Rule:**

| Property      | Value |
| ------------- | ----- |
| Height        | 80px  |
| Sticky        | Yes   |
| Background    | White |
| Border Bottom | Yes (Border color) |

**Examples:**
- The top navigation stays pinned while scrolling and keeps a thin bottom border.

**Exceptions:** None.

---

## 18. Footer

**Purpose:** A consistent footer provides closure to every page and houses
secondary navigation and legal links.

**Rule:** The footer is **Dark** (Dark color background), uses **three columns**,
and stays **simple** (no heavy decoration).

**Examples:**
- Column 1: brand + short description. Column 2: links. Column 3: contact/social.

**Exceptions:** On mobile the three columns stack vertically (per Section 8 grid).

---

## 19. Images

**Purpose:** A single image format and ratio keep pages fast and visually
aligned.

**Rule:** Use **WebP** only, at a **4:3** aspect ratio, with 16px radius
(Section 5) where rounded images are shown.

**Examples:**
- Product thumbnails and blog cover images are exported as WebP at 4:3.

**Exceptions:** Logos and icons (Section 10) are exempt from the 4:3 rule.

---

## 20. Animation

**Purpose:** A single, short animation duration keeps the interface feeling fast
and avoids sluggish or distracting motion.

**Rule:** All transitions and animations use **200ms** only.

**Examples:**
- Button hover color change → 200ms. Switch toggle → 200ms. Card hover lift → 200ms.

**Exceptions:** None.

---

## 21. Design Philosophy

> Sections 1–20 define **what** the UI must look like. This section defines
> **how** design decisions should be made when creating new pages or components.
> When a situation isn't covered by an explicit rule, fall back to these
> principles.

### 21.1 Typography First

**Purpose:** Typography establishes the personality of the product before colors,
icons, or illustrations.

**Rule:** Choose typography before designing layouts. Use Be Vietnam Pro
consistently across the application (Section 3). Font size, weight, spacing, and
hierarchy should communicate importance more than color does.

**Examples:**
- The hero headline uses the largest size and a bold weight.
- Secondary information relies on a smaller size and muted color rather than a
  different font.

**Exceptions:** None.

### 21.2 Define the Primary Focus

**Purpose:** Every screen should have one obvious visual focus so the user knows
where to look first.

**Rule:** Each page must contain one primary element that attracts attention
first — a headline, product card, illustration, call-to-action, or featured
content. Never let multiple equally strong elements compete with the primary
focus.

**Examples:**
- Homepage → Hero section.
- Product page → Product preview.
- Checkout → Purchase confirmation.

**Exceptions:** None.

### 21.3 Visual Consistency

**Purpose:** Repetition creates familiarity and strengthens the brand.

**Rule:** Reuse consistent visual elements throughout the application: border
radius, shadows, icon style, button styles, card spacing, and color accents.
Consistency should come from the design system, not from decorative effects.

**Examples:**
- Every card across the site shares the same radius, shadow, and padding.
- Every primary action uses the same Primary color and button shape.

**Exceptions:** None.

### 21.4 Depth with Restraint

**Purpose:** Create depth without distracting the user.

**Rule:** Achieve depth only through white space, borders, shadows, layering, and
elevation. Avoid decorative textures and glass effects unless they serve a
specific, justified purpose.

**Examples:**
- A card lifts off the page using a Medium shadow and white space, not a textured
  or glassy background.

**Exceptions:** A texture or glass effect may be used only when it solves a real
problem (e.g., legibility over a busy image) and is approved as a deliberate
decision.

### 21.5 Content Hierarchy

**Purpose:** Guide the user's eye from the most important information to the
least important.

**Rule:** Build hierarchy from a combination of font size, font weight, spacing,
color, and — when appropriate — opacity. Do not rely on opacity alone to create
hierarchy.

**Examples:**
- A section title is larger and heavier; supporting text is smaller and muted.
- Disabled text may use reduced opacity, but importance is still primarily
  conveyed by size and weight.

**Exceptions:** None.

### 21.6 Explore Before Choosing

**Purpose:** Avoid selecting the first acceptable solution.

**Rule:** When designing a new major section or feature, create multiple layout
concepts, compare readability and usability, and choose the strongest solution
rather than the first one.

**Examples:**
- Key screens (homepage, dashboard, checkout) get multiple explored layouts.
- Small UI components do not require multiple versions.

**Exceptions:** Minor or low-risk components may skip exploration.

### 21.7 Function Before Decoration

**Purpose:** Every visual element should improve usability.

**Rule:** Do not add an element simply because it looks attractive. Every border,
icon, color, animation, and illustration must have a purpose. If removing an
element doesn't reduce usability or clarity, it probably shouldn't be there.

**Examples:**
- An icon next to a label earns its place only if it speeds recognition.
- A decorative divider with no organizing function should be removed.

**Exceptions:** None.

---

## Implementation Roadmap

- **Phase 2:** `variables.css` — translate Sections 2–7, 9, 20 into CSS variables.
- **Phase 3:** `utilities.css` — spacing, flex, grid, text helpers from Sections 7–9.
- **Phase 4:** `layout.css` — container, navbar, footer, sections from Sections 4, 17, 18.
- **Phase 5:** `components.css` — buttons, cards, forms, badges, alerts, tables (Sections 11–16).
- **Phase 6:** Homepage — composed entirely from the above building blocks.
