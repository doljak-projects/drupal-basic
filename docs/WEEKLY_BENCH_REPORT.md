# Weekly Bench Report — Waggy Pet Shop

> Training project: Drupal 11 · doljak-projects/drupal-basic

---

## Week of Apr 06–09, 2026

> **Key learnings (tl;dr):** Paragraphs + custom Block plugin with `ContainerFactoryPluginInterface` bring real DI into theming. Cache API tags/contexts/max-age give granular cache control. GitHub Actions + PHPCS/PHPStan/SonarCloud enforce code quality before every merge.

---

### Apr 06 — Wishlist page (issue #35)

- Implemented static Wishlist layout in Twig and CSS across desktop, tablet and mobile following the Waggy Paper design
- Diagnosed missing Drupal route returning 404 — created `waggy_wishlist` module with custom controller, route and real header link

---

### Apr 07 — Theming, Paragraphs, and study infra (issues #28, #51, #53)

**Footer with Paragraphs (#28)**
- Created Paragraph types in admin (`footer_brand`, `footer_links`, `footer_newsletter`) and `footer` content type
- Built `FooterBlock` plugin with `ContainerFactoryPluginInterface` + `EntityTypeManagerInterface` — first real Dependency Injection implementation in the project
- Wrote preprocess hook for `footer` bundle, replacing static Twig arrays with real field values
- Debugged: config exported to wrong worktree, nested `ParseError`, field name typo, `drush cim` conflicts with existing entities

**Responsive header (#51, #53)**
- CSS-only dropdown menu for tablet and mobile — no JavaScript, desktop layout preserved
- Fixed CSS leak into Gin admin edit mode by scoping selectors to `doljak_theme` menu only
- Home hero made responsive: layout reflow, typography scaling, stacked CTAs on mobile

**Acquia mock exams and study planning**
- Gaps mapped: Cache API, Services/DI, Entity Query API, Exposed vs Contextual Filter
- Created 7 study issues (#54, #56, #57, #58, #59, #60, #61) with dedicated worktrees and spec docs

---

### Apr 08 — Cache API + CI/CD foundation (issues #58, #62)

**Cache API (#58)**
- Full study: cache tags, contexts, max-age, `cache()->get/set`, `#cache` in render arrays, `Cache::invalidateTags()`
- Built `waggy_cache` module from scratch: `WaggyCacheService` with DI via `services.yml`, `hook_node_presave` with custom cache tag
- Identified `accessCheck(FALSE)` bug blocking test on `main` — fix applied in worktree

**CI/CD architecture (#62)**
- Designed full CI/CD pipeline: snapshot/release/hotfix flow, basic and full pipelines, provider-agnostic deploy layer
- Configured branch protection on `main` (require approvals + dismiss stale approvals)
- First `ci-basic.yml` workflow running on GitHub Actions (25s)
- Waggy site provisioned on Pantheon (Sandbox)
- Fixed DDEV failure after moving `Sites` folder to external drive (Docker symlink)

---

### Apr 09 — Cache API validated + CI Full pipeline green (issues #58, #62)

**Cache API closed (#58)**
- Full validation on `main`: cache miss, hit and presave invalidation via UI — all working
- Fixed two bugs in `WaggyCacheService`: typo `accessChecked` → `accessCheck` and cache hit returning raw IDs instead of Node entities
- PRs #69 and #70 merged

**CI Full pipeline green (#62 → closed)**
- Fixed all PHPCS violations in custom modules (empty doc comments, missing `@file` descriptions, indentation, whitespace)
- Fixed `phpstan.neon`: added `mglaman/phpstan-drupal` extension, removed deprecated config, added `ignoreErrors` for Drupal false positives (`new static()`, `EntityInterface::get()`)
- Disabled Automatic Analysis on SonarCloud (conflicted with CI Analysis)
- CI Full passed all checks green: **Lint + Vulnerability scan + PHPCS + PHPStan + PHPUnit + SonarCloud**
- PR #71 merged, issue #62 closed

---

**Issues closed this week:** #35, #28, #51, #53, #58, #62 — **6 total**
