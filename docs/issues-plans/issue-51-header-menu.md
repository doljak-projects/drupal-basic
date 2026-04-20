---
issue: 51
title: [Theme] Responsive header dropdown menu for tablet and mobile
branch: feat/header-menu-51-responsive-header-dropdown-menu-for-tablet-and-mobile
status: closed
last_updated: 04-09-2026
---

# Issue #51 — [Theme] Responsive header dropdown menu for tablet and mobile

## Objective
Implement the static responsive behavior of the Waggy header for tablet and mobile, introducing a dropdown-style navigation menu in `doljak_theme` using HTML and CSS only, without adding JavaScript logic at this stage.

## Scope
- Adapt the header markup for tablet and mobile navigation states
- Create the static dropdown menu layout for smaller breakpoints
- Apply responsive CSS for tablet and mobile header behavior
- Preserve the existing desktop header layout
- Keep the implementation limited to HTML and CSS in the theme layer

## Status
> Atualizado em: 04-07-2026

- [x] Adapt the header markup for tablet and mobile navigation states
- [x] Create the static dropdown menu layout for smaller breakpoints
- [x] Apply responsive CSS for tablet and mobile header behavior
- [x] Preserve the existing desktop header layout
- [x] Keep the implementation limited to HTML and CSS in the theme layer

## Notes
- CSS-only toggle implemented with a hidden checkbox and label button in `page.html.twig`.
- Desktop header remains unchanged; dropdown navigation activates only at tablet/mobile breakpoints.
- Tablet uses a 2-column dropdown panel and mobile collapses it to 1 column, matching the theme's soft card language.
