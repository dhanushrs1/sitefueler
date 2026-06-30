# 0003 — Project Principles

**Status:** Accepted
**Applies to:** All milestones

Guiding principles for how SiteFueler is built. These outrank convenience.

---

## 3.1 — Prefer stability over speed

- **Decision:** When choosing between shipping a feature quickly and implementing
  it in a way that is reusable, documented, and maintainable, choose the latter.
- **Reason:** SiteFueler is a commercial product, not a throwaway project. Over its
  lifetime, maintainable foundations save far more time than rushing individual
  features. Rushed, page-specific code becomes long-term debt.
- **Alternatives:** Optimize for shipping speed per feature (rejected — accrues
  debt and erodes the component library).

## 3.2 — Every feature follows the full lifecycle

- **Decision:** Specification → Implementation → Review → Merge → Release Notes →
  Tag → Next feature. No shortcuts.
- **Reason:** A predictable rhythm keeps quality consistent and the history
  auditable, and ensures documentation keeps pace with code.
- **Alternatives:** Code-first, document-later (rejected — documentation rots).

## 3.3 — Close milestones deliberately

- **Decision:** A milestone is closed with a release (tag + release notes) before
  the next one opens. Closed milestones are frozen.
- **Reason:** Clear checkpoints make the product easy to reason about and roll back
  to, and prevent endless redesign.
- **Alternatives:** Continuous, unversioned development (rejected).
