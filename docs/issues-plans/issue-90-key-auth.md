---
issue: 90
title: "[Back-End] Key Auth — API key authentication for JSON:API endpoints"
branch: feat/key-auth-90-api-key-authentication-jsonapi
status: closed
last_updated: 05-19-2026
---

# Issue #90 — [Back-End] Key Auth — API key authentication for JSON:API endpoints

## Objective
Install and configure `drupal/key_auth` to protect JSON:API endpoints with API key authentication. Covers the simplest machine-to-machine auth pattern in Drupal — no token expiration, no OAuth handshake — suitable for trusted integrations such as inventory sync or external product feeds for Waggy's e-commerce backend.

## Scope
- Install `drupal/key_auth` via Composer and enable the module
- Understand how key_auth plugs into Drupal's authentication provider system
- Create a dedicated API user, assign an appropriate role with minimal JSON:API permissions
- Generate and assign an API key to that user
- Configure JSON:API to accept (or require) the `X-API-Key` header
- Test authenticated requests via curl / REST client:
  - GET with valid `X-API-Key` → 200 with data
  - GET without header → 401 / 403
  - GET with invalid key → 401 / 403
- Export config after setup (`ddev drush cex`)
- Document: API key auth vs OAuth Client Credentials — when to use each

## Status
> Atualizado em: 05-18-2026

- [ ] Install `drupal/key_auth` and enable module
- [ ] Understand key_auth authentication provider plugin
- [ ] Create API user + role with minimal JSON:API read permissions
- [ ] Generate and assign API key to user
- [ ] Configure JSON:API endpoint protection
- [ ] Test: valid key → 200
- [ ] Test: missing key → 401/403
- [ ] Test: invalid key → 401/403
- [ ] Export config
- [ ] Document: API key vs OAuth Client Credentials

## Notes
- Module: `drupal/key_auth` — implements `AuthenticationProviderInterface`, reads `X-API-Key` request header
- API keys are stored as a field on the Drupal user entity — each user gets one key
- JSON:API is already enabled in the project (used for product listing in issue #5)
- Waggy context: relevant for an inventory sync integration between Waggy's storefront and a warehouse system
- Key reference: `web/modules/contrib/key_auth/src/Authentication/Provider/KeyAuth.php`
- After this issue, JWT (#87) covers the same machine-to-machine use case with token expiration and claims — good comparison point
