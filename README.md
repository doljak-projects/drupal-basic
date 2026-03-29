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

## How to run

```bash
ddev start
ddev drush si --existing-config   # install with existing config
ddev drush cr                     # clear cache
```

Access: http://drupal-treino-b.ddev.site
