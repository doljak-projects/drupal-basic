---
issue: 37
title: "[Infra] Install and configure Paragraphs module"
branch: chore/paragraphs-module-37-install-and-configure
status: in-progress
last_updated: 04-02-2026
---

# Issue #37 — [Infra] Install and configure Paragraphs module

## Objective
Install and configure the Paragraphs module (drupal/paragraphs) as a prerequisite
for the footer implementation (#17). Validate the setup by creating a basic Paragraph
type to confirm the module is working correctly before building footer components.

## Scope
- Install drupal/paragraphs via Composer
- Enable the module via Drush
- Create a basic Paragraph type to validate the setup
- Export config with drush cex

## Status
> Atualizado em: 04-02-2026

- [ ] Install drupal/paragraphs via Composer
- [ ] Enable the module via Drush
- [ ] Create a basic Paragraph type to validate the setup
- [ ] Export config with drush cex

## Notes
- Pré-requisito direto da issue #17 (footer global layout)
- README learning item coberto: "Paragraphs and layouts with Layout Builder"
- Decisão arquitetural: Paragraphs foi escolhido como padrão de componentes do projeto em vez de entity reference entre block types
