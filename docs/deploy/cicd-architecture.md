---
doc: cicd-architecture
status: draft
last_updated: 04-08-2026
---

# CI/CD Architecture — Waggy Pet Shop

## Human Summary

This document describes the CI/CD pipeline design and the decisions behind it.
The goal is a workflow that is safe, auditable and provider-agnostic — meaning
the pipeline logic should not be coupled to Pantheon (or any specific host).
If the project migrates to a VPS or cloud provider, only the deploy job and
secrets change, not the pipeline structure.

There are two deployment paths:

- **Snapshot** — triggered automatically on push to `feat/*`, `refactor/*` or
  `chore/*` branches. Runs a basic pipeline (lint + build) and deploys to a
  staging environment for validation. Not allowed to merge into `main`.
- **Release** — triggered after a snapshot is validated and a PR is opened.
  Runs the full pipeline (tests, vulnerability scan, static analysis, quality
  gates) plus a required human approval before merging into `main` and
  deploying to production.

Hotfixes (`hotfix/*`) follow the release path by default but can optionally
pass through staging first via a manual dispatch.

The `main` branch is immutable — no direct pushes, only merges via approved PRs
that passed the full pipeline.

Sensitive credentials (API keys, deploy tokens, env-specific settings) are
managed via `.env` files and GitHub Secrets in this first phase.

Infrastructure services (Redis/Memcached, CDN) are fully decoupled from the
pipeline — the application connects to them via environment variables. The
pipeline does not know they exist.

---

## Pipeline Flow

```
push feat/*
push refactor/*  ────  basic pipeline (lint + build) ────  homolog (snapshot)
push chore/*                                                       │
                                                            manual approval
                                                                   │
                                                                   ▼
                                                                  PR
                                                                   │
                                                   ┌───────────────┴───────────────┐
                                                   │                               │
                                            full pipeline                   human approval
                                         (test + vuln + sonar + ...)
                                                   │                               │
                                                   └───────────────┬───────────────┘
                                                                   │ both required
                                                                   ▼
                                                             merge main ──── deploy prod (release)


push hotfix/* ────  optional manual dispatch
                          │               │
                       homolog         direct PR
                      (snapshot)           │
                          │                │
                          └────────┬───────┘
                                   ▼
                                   PR
                                   │
                   ┌───────────────┴───────────────┐
                   │                               │
            full pipeline                   human approval
         (test + vuln + sonar + ...)
                   │                               │
                   └───────────────┬───────────────┘
                                   │ both required
                                   ▼
                             merge main ──── deploy prod (release)
```

---

## Architectural Decisions

### 1. Snapshot ≠ Release — two separate paths
Snapshots exist to enable fast iteration and staging validation without the
overhead of the full pipeline. They are branch-scoped and never reach `main`.
This keeps the main branch clean and the full pipeline reserved for code that
is actually going to production.

### 2. `main` is immutable
No direct pushes to `main`. Every change arrives via PR. This enforces
auditability — every line in `main` was reviewed, passed the full pipeline and
had a human approval. Branch protection rules enforce this at the repository
level.

### 3. Provider-agnostic deploy layer
The deploy step is isolated in its own job and receives only what it needs:
the artifact (or commit ref), the target environment and the credentials.
No Pantheon-specific CLI calls (`terminus`) in the pipeline logic — they live
inside the deploy job script, which is the only part that changes if the
provider changes.

### 4. Full pipeline as a PR status check
The full pipeline (tests, vulnerability scan, static analysis) runs as a
required status check on the PR, not after the merge. This means broken code
never reaches `main` — the PR is blocked until all checks pass.

### 5. Infrastructure services are decoupled
Redis/Memcached and CDN are not part of the pipeline. They are external
services the application connects to via environment variables. The pipeline
does not provision, configure or validate them. This keeps the pipeline scope
tight and makes the architecture portable.

### 6. Secrets via `.env` and GitHub Secrets (phase 1)
In this first phase, sensitive values are managed via `.env` files for local
development and GitHub Secrets for the pipeline. A secrets manager (Vault,
AWS Secrets Manager, etc.) is a natural next step but out of scope here.

### 7. Pantheon integration via SSH git push (not Terminus in the pipeline)
Deployment to Pantheon Dev uses a direct `git push` to Pantheon's git remote
over SSH, rather than Terminus CLI calls in the pipeline logic. This keeps the
deploy step provider-agnostic: if the project migrates to a different host, only
the remote URL and SSH secret change — the pipeline structure stays the same.

Terminus is reserved for post-deploy operations (cache clear, config import,
database updates) that cannot be expressed as a git push. Those calls live
exclusively inside the deploy job, not in the pipeline orchestration.

### 8. `--force-with-lease` instead of `--force` on the Pantheon push
The deploy step uses `git push --force-with-lease` rather than `--force`.
`--force-with-lease` fails if the remote has commits that the runner has not
seen — preventing silent overwrites of manual hotfixes or emergency patches
applied directly on Pantheon Dev. `--force` would overwrite unconditionally,
which is a footgun in shared environments even when the intent is for GitHub to
be the source of truth.

### 9. SSH key scope and the machine-user gap
The SSH key stored in `PANTHEON_SSH_PRIVATE_KEY` grants write access to all
Pantheon sites under the account, not just this one. This is acceptable for a
sandbox project but would be a security gap in a production setup.

The correct production pattern is a **machine user** (a dedicated Pantheon
account with access scoped to a single site), whose SSH key is used in CI
instead of the owner's personal key. This limits blast radius if the GitHub
secret is ever exposed.

This gap is intentional and documented here rather than silently accepted.
Machine user setup requires a paid Pantheon plan and is out of scope for this
training project.

### 10. `pantheon.upstream.yml` handling
Pantheon's git remote includes a `pantheon.upstream.yml` file managed
exclusively by the upstream (Drupal Composer Managed). Pushing a history that
modifies or omits this file is rejected by Pantheon's pre-receive hook.

The deploy step resolves this by fetching the file directly from Pantheon's
remote before pushing, and committing it to the deploy HEAD if not already
present. This preserves the exact content Pantheon expects without coupling
our repository to Pantheon's upstream history or requiring a full
`--allow-unrelated-histories` merge (which introduced `settings.php` conflicts
from divergent upstream histories).

---

## AI Spec

```yaml
context: cicd-architecture
project: drupal-basic (Waggy Pet Shop)
last_updated: 04-08-2026

branches:
  main:
    protection: immutable — no direct push, merge only via approved PR
    triggers: full pipeline as required status check + human approval
    result: deploy to production (release)
  feat/*, refactor/*, chore/*:
    triggers: push → basic pipeline (lint + build) → homolog (snapshot)
    promotion: manual approval → PR → main
  hotfix/*:
    triggers: push → PR (direct) or optional manual dispatch → homolog → PR
    pipeline: full (same as main path)

pipelines:
  basic:
    steps: [lint, build]
    target: homolog
    tag: snapshot
  full:
    steps: [lint, build, test, vulnerability-scan, static-analysis, quality-gates]
    target: production
    tag: release
    gate: human approval required (PR review)

deploy:
  layer: isolated job — provider-agnostic
  current_provider: Pantheon
  portability: only deploy job + secrets change on provider migration
  credentials: GitHub Secrets (phase 1), .env for local

infrastructure:
  redis_memcached: external microservice — connected via env var, not in pipeline
  cdn: third-party (Akamai/CloudFront/etc.) — points to origin, fully decoupled

secrets_strategy:
  phase_1: .env files (local) + GitHub Secrets (pipeline)
  phase_2: secrets manager (out of scope)

constraints:
  - snapshots must never merge into main
  - full pipeline must pass before merge is allowed
  - human approval is always required for production deploys
  - no provider-specific CLI in pipeline logic (only in deploy job)
```
