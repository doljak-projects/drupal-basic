# Drupal PoC — Hands-On Learning

This repository is a **proof of concept (PoC)** for studying Drupal 11, focused on progressive exercises covering everything from the most basic concepts to advanced framework features.

The goal is not to build a final product, but to explore and document each layer of Drupal in practice, building a real understanding of how the CMS works under the hood.

## Environment

- **Drupal**: 11.x
- **PHP**: 8.4
- **Database**: MariaDB 11.8
- **Server**: nginx-fpm via DDEV
- **Local URL**: http://drupal-treino-b.ddev.site

## Business Scope

The project simulates a **fictional pet shop** website, used as a practical context for the exercises. The public-facing scope includes:

- **Home**: hero section, Shop by Pet category buttons, New Arrivals, blog listing
- **Shop**: product listing page filtered by pet type
- **Product page**: detailed product description
- **Blog**: article listing and detail pages

The scope expands as new topics are covered in the exercises.

## Exercise Scope

### Basic

- [X] Environment setup and configuration with DDEV
- [X] Drupal directory structure and essential files
- [X] Content Types and Fields
- [X] Taxonomies and vocabularies
  - [X] `Pet Type` vocabulary with image field — used to drive Shop by Pet category buttons
- [X] Menus and navigation links
- [X] Blocks: creation, placement and visibility
  - [X] Custom Block plugins (`@Block` annotation) — Hero block, Shop by Pet block
  - [X] Block rendering a Node entity via `EntityTypeManager` + view builder
- [X] Users, roles and permissions
  - [X] `Content Editor` role — can create/edit/delete products, hero, articles and media
  - [X] `Customer` role — authenticated read-only access
- [X] Admin theme with Gin

### Intermediate

- [ ] Views: listing pages, filters and displays — applied in the Blog section (article listing)
- [X] Config API: export and import configuration with `cex` / `cim`
- [X] Custom module creation (hook_theme, routing, controller)
  - [X] `hook_theme` — custom template registration with `template` and `path` keys
  - [X] routing — via plugin system (Block)
  - [ ] controller — page route with render array
- [ ] Form API
- [X] Custom theme with Starterkit
- [X] Twig: templates, variables, filters and functions
- [ ] Preprocessors (`hook_preprocess_*`)
- [X] Asset libraries (`libraries.yml`, `#attached`)
- [ ] Responsiveness: media queries in custom theme CSS, mobile/tablet/desktop breakpoints
- [ ] Basic migrations with Migrate API

### Advanced

- [ ] Services and Dependency Injection (Service Container)
- [X] Plugins: custom block, field and formatter types
  - [X] Block plugin — `@Block` annotation, `build()` returning render array
  - [ ] Custom field — FieldType plugin
  - [ ] Custom formatter — FieldFormatter plugin
- [ ] Event Subscribers and hooks via classes
- [ ] Queue API and background processing
- [ ] Cache API: cache tags, contexts and invalidation
- [X] REST API and JSON:API
  - [X] Native JSON:API — products stored in Drupal, consumed via `/jsonapi/node/waggy_product` in the Shop by Pet block; includes taxonomy term images resolved through `media → file → uri` relationship chain
  - [X] Guzzle HTTP client (server-side) — used internally to query Drupal's own JSON:API from a Block plugin via `\Drupal::httpClient()`
  - [ ] Guzzle consuming external API — fetch from an external backend; API key protected server-side, URL never exposed to the browser
  - [ ] JavaScript fetch (client-side) — filter products without page reload; URL exposed to the browser
- [ ] Paragraphs and layouts with Layout Builder
- [ ] Advanced Migrate API: migrations with complex transformations
- [ ] Automated testing with PHPUnit and Nightwatch

### Login & Security

- [ ] Core auth forms — override via `hook_form_alter()` (login, register, password reset)
- [ ] OAuth 2.0 — `simple_oauth` module; authorization code flow for third-party clients
- [ ] JWT — JSON Web Tokens for headless/decoupled authentication
- [ ] SSO — Single Sign-On via SAML 2.0 (`simplesamlphp_auth`) or OpenID Connect
- [ ] Two-factor authentication — TOTP via `tfa` module
- [ ] Rate limiting and brute force protection — `flood` API, `captcha` module
- [ ] HTTPS, CSRF protection, Content Security Policy headers
- [ ] Password policies — `password_policy` module; complexity rules per role

### Deploy & CI/CD

- [ ] Environment config split — `config_split` module for dev/staging/prod differences
- [ ] `settings.php` per environment — database, trusted hosts, reverse proxy config
- [ ] Drush deploy script — `updatedb`, `cim`, `cr`, `deploy` hook
- [ ] GitHub Actions pipeline — PHP lint, PHPStan static analysis, Drupal tests, deploy on merge
- [ ] Staging deployment — DDEV → Pantheon / Platform.sh / Acquia / VPS with SSH
- [ ] Production hardening — file permissions, `settings.php` write-protect, error reporting off
- [ ] Composer in production — `--no-dev`, lockfile pinned, patches applied
- [ ] Rollback strategy — config revert, database snapshot before deploy

## How to run

```bash
ddev start
ddev drush si --existing-config   # install with existing config
ddev drush cr                     # clear cache
```

Access: http://drupal-treino-b.ddev.site

## Scripts and helper hooks

See [scripts/SCRIPTS.md](scripts/SCRIPTS.md) for the full reference of Drush automation scripts and git hooks — including preconditions, side effects, risk levels and AI agent guidance.
