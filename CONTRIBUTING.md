# Contributing to SiteFueler

## Branching model

```
main          Stable, release-ready. Never commit directly.
  └── develop  Daily integration branch. Features merge here first.
        └── feature/*  One branch per feature.
```

Examples: `feature/button-system`, `feature/auth`, `feature/homepage`,
`feature/admin-panel`, `feature/download-manager`.

Delete a feature branch after it is merged.

## Workflow

1. Branch from `develop`: `git checkout -b feature/my-feature develop`
2. Commit using the convention below.
3. Open a PR into `develop`.
4. Promote `develop` → `main` only when stable, then tag the version.

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
