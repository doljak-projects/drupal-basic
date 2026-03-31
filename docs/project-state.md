# Project State

> Last updated: 2026-03-31
> Updated at the end of each work session. Any agent or developer should be able to pick up from here without prior context.

---

## Environment

- **Project:** Waggy Pet Shop — Drupal 11 PoC
- **Local URL:** http://drupal-treino-b.ddev.site
- **Stack:** Drupal 11.x, PHP 8.4, MariaDB 11.8, nginx-fpm, DDEV
- **Repo:** https://github.com/doljak-projects/drupal-basic
- **Design reference:** Paper (MCP connected) — 24 artboards across 8 screens × 3 breakpoints (desktop 1440, tablet 768, mobile 390)

---

## Current branch

`docs/readme-login-security-deploy` (PR #18 open → main)

Active working branches:
- `feat/shop-css-6` — product detail template + shop card CSS (merged into views-shop-5, pushed)
- `feat/views-shop-5-pagina-listagem-produtos-filtros` — shop listing (PR #9 merged into main ✅)
- `docs/readme-login-security-deploy` — README Login & Security + Deploy sections (PR #18 open)

---

## What is done (merged to main)

| Feature | PR | Notes |
|---------|----|-------|
| Environment + content types + taxonomies | — | waggy_product, pet_type vocabulary |
| Roles and permissions | — | Content Editor, Customer |
| Hero block + Shop by Pet block | #4 | JSON:API + Guzzle, taxonomy images via media→file→uri |
| Shop listing page `/shop/<slug>` | #9 | Views + TaxonomySlug plugin + Pathauto |
| Product detail page | #9 | node--waggy-product.html.twig + product-styling.css |
| Shop card CSS grid | #9 | 4-column grid, badge, pet-type color variants |

---

## What is in progress

| Item | Status | Notes |
|------|--------|-------|
| README Login & Security + Deploy sections | PR #18 open | docs only, no code |
| Codex working in parallel on Paper/CSS | unknown | user mentioned Codex adjusting Paper artboards |

---

## Open issues (backlog priority order)

| # | Title | Key learning checkpoints |
|---|-------|--------------------------|
| #6 | Shop listing header block | hook_preprocess_block, Block Content vs Block Plugin, drupal_block() |
| #7 | Blog listing page with Views and friendly URLs | Views (blog), reuse TaxonomySlug spec |
| #8 | Product badges — HOT/NEW + discount % | Custom formatter, Custom field, Cache API |
| #10 | Wishlist — controller, JS fetch, DI | Controller, Services/DI, JavaScript fetch |
| #11 | Article detail page | hook_preprocess_node, Cache API, Responsiveness |
| #12 | Login / Cadastro / Esqueci a Senha | Form API, Event Subscribers, Responsiveness |
| #13 | Responsiveness — Home | Media queries, breakpoints |
| #14 | Responsiveness — Shop | Media queries on Views grid |
| #15 | Responsiveness — Product | Media queries on node template |
| #16 | Migrate API standalone | Basic + Advanced migrations, CSV source |
| #17 | Footer | Regions, Block Layout, Responsiveness |

---

## Key technical decisions made

### TaxonomySlug Views argument plugin
- **Why custom:** `taxonomy_term_name` validator has a runtime bug (converts argument but query uses original string). `entity_target_id` plugin does not convert slugs.
- **Why `hook_views_data_alter`:** Views resolves handler plugins from `views_data()` at runtime, NOT from the `plugin_id` stored in View config. The alter hook is the only way to swap the runtime plugin for a field.
- **Plugin location:** `web/modules/custom/shop_by_pet_block/src/Plugin/views/argument/PetTypeSlug.php`
- **Drupal 11 note:** Must use `#[ViewsArgument(...)]` PHP 8 Attribute — docblock `@ViewsArgument` is silently ignored.
- **Full spec:** `docs/views-friendly-url-slug-argument.md`

### Pathauto
- **Pattern:** `shop/[node:field_pet_type:entity:name]/[node:title]`
- **Bulk generate via Drush** (UI is unreliable — easy to miss the "Content" checkbox):
  ```bash
  ddev drush php:eval "
  \$pathauto = \Drupal::service('pathauto.generator');
  \$storage = \Drupal::entityTypeManager()->getStorage('node');
  \$nids = \$storage->getQuery()->condition('type', 'waggy_product')->accessCheck(FALSE)->execute();
  foreach (\$nids as \$nid) {
    \$node = \$storage->load(\$nid);
    \$pathauto->updateEntityAlias(\$node, 'bulkupdate');
  }
  "
  ```

### row.url empty in Views field templates
- `row.url` is always empty in field-based Views displays.
- Use `path('entity.node.canonical', {'node': row._entity.id})` in Twig — resolves Pathauto aliases automatically.

### Git workflow
- `main` is protected — no direct push, always PR
- Never use `git reset` — non-destructive alternatives only
- Pattern: feature branch → commit → push → PR → merge

---

## Custom modules

| Module | Purpose |
|--------|---------|
| `block_hero` | Hero block plugin |
| `shop_by_pet_block` | Shop by Pet block + TaxonomySlug Views argument plugin + hook_views_data_alter |
| `waggy_wishlist` | Wishlist block scaffold (issue #10 pending) |
| `search_filter_animated` | Animated search filter (status unknown) |

---

## Custom theme

`web/themes/custom/doljak_theme`

| File | Purpose |
|------|---------|
| `css/base/hero-styling.css` | Hero section |
| `css/base/shop-styling.css` | Shop listing cards + grid |
| `css/base/product-styling.css` | Product detail page |
| `css/layout/global.css` | Global layout |
| `templates/views-view--shop.html.twig` | Shop View wrapper |
| `templates/views-view-unformatted--shop.html.twig` | Shop grid wrapper |
| `templates/views-view-fields--shop.html.twig` | Shop card |
| `templates/node--waggy-product.html.twig` | Product detail |

---

## Next session suggested starting point

1. Merge PR #18 (README docs)
2. Pick issue #6 (shop header block) or #7 (blog listing) — both are 1-day scope
3. If Codex finished Paper adjustments, review artboards before starting CSS work
