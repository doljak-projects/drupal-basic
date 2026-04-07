---
issue: 56
title: "[Theme] Twig automatic variables — logged_in, user, is_front"
branch: feat/twig-variables-56-twig-automatic-variables-logged-in-user-is-front
status: in-progress
last_updated: 04-07-2026
---

# Issue #56 — [Theme] Twig automatic variables — logged_in, user, is_front

## Objective
Study and practice the automatic variables that Drupal injects into all Twig templates without requiring PHP preprocessors. Focus on logged_in, user, is_front and other context variables available by default — covering Domain 3.3/3.4 of the Acquia certification.

## Scope
- Map all automatic variables available in node, page and block templates
- Practice using logged_in to conditionally render content for authenticated vs anonymous users
- Use user.roles to render role-specific content in Twig
- Use is_front to apply homepage-specific markup
- Build a practical exercise: render different article content based on login state using only Twig

## Status
> Atualizado em: 04-07-2026

- [ ] Map all automatic Twig variables (logged_in, user, is_front, base_path, etc.)
- [ ] Practice logged_in for authenticated vs anonymous conditional rendering
- [ ] Use user.roles for role-specific content
- [ ] Use is_front for homepage-specific markup
- [ ] Build practical exercise in node--article.html.twig

## Notes
- Identified as a gap in Acquia certification simulado 2 (Domain 3.3) — score 4/10
- Variable `logged_in` is always available in Drupal Twig templates — no preprocess needed
