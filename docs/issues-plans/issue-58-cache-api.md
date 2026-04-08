---
issue: 58
title: "[Back-End] Cache API — study and practical exercise"
branch: feat/cache-api-58-cache-api-study-and-practical-exercise
status: in-progress
last_updated: 04-07-2026
---

# Issue #58 — [Back-End] Cache API — study and practical exercise

## Objective
Study and practice Drupal's Cache API as the foundation for performant, cache-aware development. Focus on cache tags, contexts, max-age, the low-level cache()->get/set interface, and the #cache render array property — covering Domain 4.4 of the Acquia certification.

## Scope
- Understand cache tags, contexts and max-age and how they compose
- Practice cache()->get() and cache()->set() for data caching
- Use #cache in render arrays to control tag/context/max-age at the render layer
- Invalidate cache by tag with Cache::invalidateTags()
- Build a practical exercise: cache an expensive entity load and invalidate it on node save
- Understand when to use cache()->get/set vs #cache vs hook_node_presave invalidation

## Status
> Atualizado em: 04-08-2026

- [x] Understand cache tags, contexts and max-age and how they compose
- [x] Practice cache()->get() and cache()->set() for data caching
- [x] Use #cache in render arrays to control tag/context/max-age at the render layer
- [x] Invalidate cache by tag with Cache::invalidateTags()
- [x] Build practical exercise: cache an expensive entity load and invalidate it on node save
- [x] Understand when to use cache()->get/set vs #cache vs hook_node_presave invalidation

## Notes
- Identified as a recurring gap in Acquia certification simulados 1 and 2 (Domain 4.4)
- Key references: `\Drupal::cache()`, `CacheBackendInterface`, `#cache` render array key, `Cache::invalidateTags()`
