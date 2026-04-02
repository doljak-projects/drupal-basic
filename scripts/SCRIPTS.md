# Scripts & Hooks

Reference for all automation scripts and git hooks in this repository.
Intended for developers and AI agents working in this codebase.

---

## AI Agent Spec

When an AI agent (e.g. Claude Code) is acting in this repository, this file is the
primary context for decisions about automations. Before suggesting or executing any
script, the agent must verify:

1. **DDEV is running** — all scripts execute inside the container via `ddev drush php:script`
2. **Risk level** — check the `Risk` field below; never run a `destructive` script without explicit user confirmation
3. **Preconditions** — check the `Requires` field; some scripts depend on existing database content
4. **Side effects** — check `Side effects`; scripts may create, modify or delete nodes, media entities and files in `public://`
5. **Idempotency** — non-idempotent scripts should not be run twice without cleanup

---

## Drush Scripts

### `create-products.php`

| Field | Value |
|---|---|
| **Purpose** | Seeds the database with 30 `waggy_product` nodes (one per product), each linked to a pet taxonomy term, a price, a badge label and a product image |
| **Risk** | Low — additive only; does not delete existing content |
| **Idempotent** | No — running twice creates duplicate products |
| **Requires** | DDEV running · `waggy_product` content type · `pet_type` taxonomy with terms dogs/cats/birds/fish/small-pets · product images present in `imagens exportadas/produtos/` |
| **Side effects** | Creates File entities, Media (image bundle) entities and Node entities in the database; copies image files to `public://produtos/` |
| **Run** | `ddev drush php:script scripts/create-products.php` |

---

### `delete-products.php`

| Field | Value |
|---|---|
| **Purpose** | Deletes all `waggy_product` nodes and their associated media and file entities from the database |
| **Risk** | **Destructive** — permanently removes nodes, media and managed files; cannot be undone without a database snapshot |
| **Idempotent** | Yes — safe to run on an empty database |
| **Requires** | DDEV running |
| **Side effects** | Deletes all `waggy_product` nodes · deletes linked Media entities · deletes linked File entities (managed files only; `public://` files may remain on disk) |
| **Run** | `ddev drush php:script scripts/delete-products.php` |

---

### `create-article-test.php`

| Field | Value |
|---|---|
| **Purpose** | Creates a single `article` node with realistic content matching the Waggy Journal design mock — used for manual testing of the article detail page template |
| **Risk** | Low — additive only |
| **Idempotent** | No — running twice creates duplicate articles |
| **Requires** | DDEV running · `article` content type with fields `field_category`, `field_reading_time`, `field_image` · at least one file entity with `labrador` in the URI (optional; hero image will be skipped if absent) |
| **Side effects** | Creates one `article` Node entity in the database |
| **Run** | `ddev drush php:script scripts/create-article-test.php` |

---

### `migrate-pet-type-field.php`

| Field | Value |
|---|---|
| **Purpose** | One-time migration script that converts `field_pet_type` on `waggy_product` from `list_string` to `entity_reference` (taxonomy term). Preserves all existing product → pet-type relationships |
| **Risk** | **Destructive** — drops and recreates the field storage; data loss is possible if the slug-to-TID mapping is incomplete |
| **Idempotent** | No — intended to run exactly once; running again on an already-migrated site will break field configuration |
| **Requires** | DDEV running · `pet_type` taxonomy terms with TIDs 1–5 in order: dogs, cats, birds, fish, small-pets |
| **Side effects** | Deletes `FieldConfig` and `FieldStorageConfig` for `field_pet_type` · recreates them as `entity_reference` · re-saves all `waggy_product` nodes with the new term reference |
| **Run** | `ddev drush php:script scripts/migrate-pet-type-field.php` |

---

## Git Hooks

### `scripts/hooks/pre-commit`

| Field | Value |
|---|---|
| **Purpose** | Blocks direct commits on the `main` branch to enforce the feature-branch + PR workflow |
| **Trigger** | Runs automatically before every `git commit` |
| **Effect** | Exits with error code 1 and prints a message when the current branch is `main`; commits on any other branch proceed normally |
| **Risk** | None — read-only check, no side effects |

#### Setup

This hook was designed for a **worktrees + bare repo** structure (`.bare/`).
In that model, hooks live in `.bare/hooks/` and apply to all worktrees automatically —
no per-worktree configuration needed.

```
.bare/
  hooks/
    pre-commit   ← applies to every worktree
main/            ← worktree
worktree-*/      ← other worktrees
```

**For developers cloning the repository normally** (without bare repo), activate the
hook manually after cloning:

```bash
git config core.hooksPath scripts/hooks
```

This tells git to look for hooks in `scripts/hooks/` instead of `.git/hooks/`.
