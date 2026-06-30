# Contributing to SiteFueler

## Principles

- **Prefer stability over speed.** When choosing between shipping a feature
  quickly and implementing it in a way that's reusable, documented, and
  maintainable, choose the latter. (See `docs/meetings/0003-principles.md`.)
- **Every feature follows the full lifecycle:** Specification → Implementation →
  Review → Merge → Release Notes → Tag. No shortcuts.

## Branching model

We use a simple, single-developer-friendly flow:

```
main            Stable, release-ready.
  └── feature/*  One short-lived branch per feature, branched from main.
```

Examples: `feature/button-system`, `feature/form-system`, `feature/header`,
`feature/homepage`.

When a feature is finished, merge it into `main` and **delete the feature
branch**. (If SiteFueler ever grows to multiple developers, we can reintroduce a
permanent `develop` branch.)

## Workflow

1. Branch from `main`: `git checkout -b feature/my-feature main`
2. Commit using the convention below.
3. **Visual QA** — open the page in desktop / tablet / mobile and check
   alignment, spacing, overflow, focus states, typography, and zoom (125% / 150%).
   Most UI bugs surface here, not in code review.
4. Review against the spec + Definition of Done.
5. Merge into `main` when stable, then delete the feature branch.
6. Tag the version when a milestone completes.

Lifecycle: **Specification → Implementation → Visual QA → Review → Merge →
Release Notes → Tag.**

## Reusability gate

Before merging any feature branch into `main`, ask:

> "Can this feature be reused in at least three places without modification?"

If the answer is no, it's probably too page-specific and should be redesigned
before merging. This keeps the shared component library clean.

## Commit style (Conventional Commits)

Use a type prefix and an imperative summary:

- `feat:` a new feature
- `fix:` a bug fix
- `docs:` documentation only
- `refactor:` code change that neither fixes a bug nor adds a feature
- `style:` formatting / non-functional CSS
- `chore:` tooling, config, housekeeping
- `test:` adding or fixing tests

Examples:

```
feat: create design system foundation
feat: add button component specification
docs: add component documentation
refactor: reorganize CSS architecture
fix: correct spacing tokens
```

Avoid vague messages like "Updated files".

## Definition of Done (every component)

A component is complete only when it:

- ✅ Matches its specification document.
- ✅ Uses only design tokens from `variables.css`.
- ✅ Has no hardcoded colors, spacing, typography, radii, or shadows.
- ✅ Works on mobile, tablet, and desktop.
- ✅ Has visible keyboard focus and appropriate semantic HTML.
- ✅ Doesn't duplicate logic already present in another component.
- ✅ Has clean, reusable Blade markup.
- ✅ Is documented if the implementation differs from the specification.
