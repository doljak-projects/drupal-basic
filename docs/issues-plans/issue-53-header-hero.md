---
issue: 53
title: [Theme] Refine header CSS and add responsive home hero layout
branch: feat/header-hero-53-refine-header-css-and-add-responsive-home-hero-layout
status: closed
last_updated: 04-09-2026
---

# Issue #53 — [Theme] Refine header CSS and add responsive home hero layout

## Objective
Refine the current header CSS in `doljak_theme` and implement responsive behavior for the home hero section, aligning both areas with the Waggy Paper reference across desktop, tablet, and mobile breakpoints.

## Scope
- Adjust the header CSS to improve spacing, alignment, and visual consistency
- Apply responsive CSS to the home hero layout for tablet and mobile
- Preserve the desktop visual direction while adapting smaller breakpoints
- Keep the implementation focused on theme-layer HTML/Twig and CSS

## Status
> Atualizado em: 04-07-2026

- [x] Adjust the header CSS to improve spacing, alignment, and visual consistency
- [x] Apply responsive CSS to the home hero layout for tablet and mobile
- [ ] Preserve the desktop visual direction while adapting smaller breakpoints
- [ ] Keep the implementation focused on theme-layer HTML/Twig and CSS

## Notes
- Header dropdown selectors were narrowed to the direct theme navigation structure so Gin contextual links keep their own styling.
- The third header icon was visually aligned to a shopping basket using Doljak theme CSS only.
- Hero layout now stacks and rescales across tablet/mobile while keeping the desktop composition intact.
