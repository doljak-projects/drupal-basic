---
issue: 97
title: "[Refactor] Auth journey UI and logout screen"
branch: refactor/auth-ui-97-auth-journey-ui-and-logout-screen
status: in-progress
last_updated: 05-18-2026
---

# Issue #97 — [Refactor] Auth journey UI and logout screen

## Objective
Refactor the authentication journey UI starting from the current main branch. Use the real Drupal screens for login, register, forgot password, and logout as the source of truth, refine the visual direction in Paper, create the missing logout screen in Paper, and then bring the approved UI adjustments back into Drupal through updated CSS while preserving the existing Drupal form behavior.

## Scope
- Start the implementation branch/worktree from main, not from the issue #86 worktree
- Capture or inspect the real Drupal login, register, forgot password, and logout screens as they render today
- Use Paper to refine only the UI layer for login, register, and forgot password based on the current Drupal output
- Create the logout screen design in Paper so the auth journey has a complete visual reference
- Update Drupal CSS to match the refined Paper direction without changing Form API integration or auth behavior
- Validate the updated login, register, forgot password, and logout screens across desktop, tablet, and mobile breakpoints

## Status
> Atualizado em: 05-18-2026

- [x] Start the implementation branch/worktree from main, not from the issue #86 worktree
- [x] Capture or inspect the real Drupal login, register, forgot password, and logout screens as they render today
- [ ] Use Paper to refine only the UI layer for login, register, and forgot password based on the current Drupal output
- [ ] Create the logout screen design in Paper so the auth journey has a complete visual reference
- [x] Update Drupal CSS to match the refined Paper direction without changing Form API integration or auth behavior
- [ ] Validate the updated login, register, forgot password, and logout screens across desktop, tablet, and mobile breakpoints

## Notes
- Initial UI pass used the screenshots provided by the user for login, register and password reset because DDEV/Docker access was not available inside the sandbox.
- Added Drupal logout confirm support through `form--user-logout-confirm.html.twig` and `user_logout_confirm` form suggestion/classes.
- Paper artboard `Waggy — Logout` was created, but content insertion was cancelled while the Paper MCP call was running slowly; needs a follow-up Paper pass.
- Styled Drupal auth error/status messages so validation feedback is contained above the auth layout instead of rendering as loose text at the top of the page.
