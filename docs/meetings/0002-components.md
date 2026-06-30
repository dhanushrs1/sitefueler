# 0002 — Core UI Components

**Status:** Accepted
**Milestone:** 2 (Core UI Components, v0.2.0)

Decisions guiding the component library.

---

## 2.1 — Build order driven by dependencies

- **Decision:** Implement in dependency order: Button → Form → Badge → Alert →
  Card → Table → Modal, then Header → Footer.
- **Reason:** Higher-level components compose lower-level ones (e.g. Header uses
  Buttons). Building dependencies first avoids redesigning the Header repeatedly.
- **Alternatives:** Build the Header (or Homepage) first.

## 2.2 — Button is the blueprint

- **Decision:** The Button is reviewed and validated first; once it passes its
  spec, it becomes the standard pattern (Blade structure, CSS naming, states,
  accessibility) for every other component.
- **Reason:** A consistent reference keeps the whole library coherent.
- **Alternatives:** Let each component define its own conventions.

## 2.3 — One base, many variants

- **Decision:** Each component family has a single base (e.g. one base Card) that
  variants inherit; per-variant Blade files are thin wrappers over a base.
- **Reason:** Prevents divergent styles and duplicated logic.
- **Alternatives:** Independent implementations per variant.

## 2.4 — Semantic color tokens + soft tints

- **Decision:** Added `--color-success/-warning/-danger/-info` and matching
  `*-soft` background tints, plus a neutral gray scale and a frozen z-index scale.
  Components reference these instead of computing rgba() or using magic numbers.
- **Reason:** Consistent feedback colors and elevation across alerts, badges,
  forms, and the admin panel.
- **Alternatives:** Per-component opacity math and ad-hoc z-index values.

## 2.5 — Split component CSS + per-component Blade folders

- **Decision:** `components.css` only `@import`s `components/<name>.css`; Blade
  components live in `resources/views/components/<name>/`.
- **Reason:** Easier to maintain than one large file as the library grows.
- **Alternatives:** Single monolithic `components.css` and a flat Blade folder.

## 2.6 — Definition of Done + reusability gate

- **Decision:** Every component must satisfy the DoD (matches spec, tokens only,
  responsive, accessible, no duplication, clean Blade) and the reusability gate
  ("reusable in 3+ places without modification") before merging.
- **Reason:** Keeps shared components generic and prevents page-specific creep.
- **Alternatives:** Merge components case-by-case without a standard.
