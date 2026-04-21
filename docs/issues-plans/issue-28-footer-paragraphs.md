---
issue: 28
title: "feat: footer — Paragraphs content modeling and block wiring"
branch: feat/footer-paragraphs-28-content-modeling-and-block-wiring
status: closed
last_updated: 04-09-2026
---

# Issue #28 — feat: footer — Paragraphs content modeling and block wiring

## Objective
Wire the static footer template into live Drupal data using Paragraphs as the component system.
The visual layer (node--footer.html.twig + footer-styling.css) is already merged into main from issue #17.
Each footer column (brand, Quick Links, Help Centre, Newsletter) will be modeled as a Paragraph type
and referenced from a `footer` node, rendered via a custom block plugin.

## Scope
- Create Paragraph types: `footer_brand`, `footer_links`, `footer_newsletter`
- Create `footer` content type with an entity reference (Paragraphs) field for each column
- Create a custom Block plugin that loads the footer node and renders it via `node--footer.html.twig`
- Replace static Twig arrays in `node--footer.html.twig` with real Paragraph field values
- Place the block in the `footer` region via Structure → Block layout

## Status
> Atualizado em: 04-02-2026

- [ ] Create Paragraph type `footer_brand` (logo, tagline, social links)
- [ ] Create Paragraph type `footer_links` (label + link list — reused for Quick Links and Help Centre)
- [ ] Create Paragraph type `footer_newsletter` (CTA text + email field)
- [ ] Create `footer` content type with Paragraphs reference fields for each column
- [ ] Create custom Block plugin that loads the footer node via `EntityTypeManager`
- [ ] Update `node--footer.html.twig` to render real Paragraph field values
- [ ] Place block in `footer` region via Block layout
- [ ] Export config with `ddev drush cex` and commit

## Notes
- Paragraphs module already installed and configured (issue #37)
- Static footer layout already in place — this issue only wires data, no visual changes expected
- User will create the actual content (blocks, links, form) manually in the Drupal admin
