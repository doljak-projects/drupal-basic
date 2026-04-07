---
issue: 54
title: "[Back-End] Entity Query API — study and practical exercise"
branch: feat/entity-query-54-entity-query-api-study-and-practical-exercise
status: in-progress
last_updated: 04-07-2026
---

# Issue #54 — [Back-End] Entity Query API — study and practical exercise

## Objective
Study and practice Drupal's Entity Query API as a replacement for raw SQL when fetching content entities. Focus on entityQuery(), condition chaining, sort, range and loadMultiple() — covering Domain 4.3 of the Acquia certification.

## Scope
- Study entityQuery() and understand how it abstracts database queries
- Practice condition() chaining: type, status, and field-level filters
- Implement sort() and range() for ordered and limited result sets
- Use loadMultiple() to hydrate full entity objects from IDs
- Build a practical exercise: fetch the 5 most recent published articles filtered by category
- Understand accessCheck(TRUE) and why skipping it is a security risk

## Status
> Atualizado em: 04-07-2026

- [ ] Study entityQuery() and understand how it abstracts database queries
- [ ] Practice condition() chaining: type, status, and field-level filters
- [ ] Implement sort() and range() for ordered and limited result sets
- [ ] Use loadMultiple() to hydrate full entity objects from IDs
- [ ] Build practical exercise: fetch 5 most recent published articles filtered by category
- [ ] Understand accessCheck(TRUE) and security implications

## Notes
- Identified as a gap in Acquia certification simulado 2 (Domain 4.3) — score 0/10
- Key reference: `\Drupal::entityQuery('node')` + `\Drupal::entityTypeManager()->getStorage('node')->loadMultiple()`
