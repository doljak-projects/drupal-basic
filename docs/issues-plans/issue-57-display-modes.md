---
issue: 57
title: "[Site Building] Display Modes — creation, configuration and use with Views"
branch: feat/display-modes-57-display-modes-creation-configuration-and-use-with-views
status: in-progress
last_updated: 04-07-2026
---

# Issue #57 — [Site Building] Display Modes — creation, configuration and use with Views

## Objective
Study and practice Drupal Display Modes for nodes and other entities. Learn how to create custom view modes, configure which fields appear in each mode, and wire them into Views for reusable card-style displays — covering Domain 2.2 of the Acquia certification.

## Scope
- Understand the difference between View Modes and Form Modes
- Create a custom view mode 'card' for the Article content type
- Configure which fields appear in the card mode (title, image, category — no tags)
- Use the card view mode in a Views display (Show: Content > card)
- Compare Display Modes vs manually selecting fields in Views Fields
- Export config with drush cex

## Status
> Atualizado em: 04-07-2026

- [ ] Understand difference between View Modes and Form Modes
- [ ] Create custom view mode 'card' for Article content type
- [ ] Configure fields for card mode (title, image, category only)
- [ ] Wire card view mode into a Views display
- [ ] Compare Display Modes vs Views field selection
- [ ] Export config with drush cex

## Notes
- Identified as a gap in Acquia certification simulado 2 (Domain 2.2) — score 3/10
- Path to manage: /admin/structure/types/manage/article/display
- Enable custom display settings first, then configure per-mode field visibility
