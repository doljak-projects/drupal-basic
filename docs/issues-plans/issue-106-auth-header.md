---
issue: 106
title: [Feature] Add auth-aware header action
branch: feat/auth-header-106-add-auth-aware-header-action
status: closed
last_updated: 05-19-2026
---

# Issue #106 - [Feature] Add auth-aware header action

## Objective
Add an authentication-aware header action to the Waggy navigation so anonymous users see a Login action beside the existing header icons, while authenticated users see Logout in the same position.

## Scope
- Add a Login action beside the search, wishlist, and cart header icons.
- Swap the header action to Logout when the customer is authenticated.
- Keep the header spacing and visual style consistent across the Waggy desktop layouts.
- Document the authenticated Logout state in the Paper design.

## Status
> Atualizado em: 05-19-2026

- [x] Add a Login action beside the search, wishlist, and cart header icons.
- [x] Swap the header action to Logout when the customer is authenticated.
- [x] Keep the header spacing and visual style consistent across the Waggy desktop layouts.
- [x] Document the authenticated Logout state in the Paper design.

## Notes
Paper design updated first: public desktop headers show Login, authenticated state shows Logout, and the Waggy Logout artboard documents the state transition.
Drupal implementation uses the existing `logged_in` page variable in `page.html.twig`, linking anonymous users to `user.login` and authenticated users to `user.logout`.
