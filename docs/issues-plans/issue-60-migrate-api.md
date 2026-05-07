---
issue: 60
title: "[Back-End] Migrate API — study and practical exercise"
branch: feat/migrate-api-60-migrate-api-study-and-practical-exercise
status: in-progress
last_updated: 04-07-2026
---

# Issue #60 — [Back-End] Migrate API — study and practical exercise

## Objective
Study and practice Drupal's Migrate API as the standard framework for importing and transforming data. Focus on the ETL pipeline (source, process, destination), built-in plugins, custom process plugins, and running migrations via Drush — covering Domain 4.5 of the Acquia certification.

## Scope
- Understand the ETL pipeline: source → process → destination
- Study built-in source plugins (CSV, SQL, JSON) and destination plugins (node, user, taxonomy)
- Write a migration YAML definition file from scratch
- Use built-in process plugins: get, default_value, callback, explode
- Write a custom process plugin class extending ProcessPluginBase
- Run, rollback and check status of migrations via Drush (migrate:import, migrate:rollback, migrate:status)

## Status
> Atualizado em: 04-07-2026

- [ ] Understand the ETL pipeline: source → process → destination
- [ ] Study built-in source plugins (CSV, SQL, JSON) and destination plugins (node, user, taxonomy)
- [ ] Write a migration YAML definition file from scratch
- [ ] Use built-in process plugins: get, default_value, callback, explode
- [ ] Write a custom process plugin class extending ProcessPluginBase
- [ ] Run, rollback and check status of migrations via Drush

## Notes
- Identified as unstudied topic — not yet covered in any session
- Key modules: migrate, migrate_plus, migrate_tools
- Key reference: `\Drupal\migrate\ProcessPluginBase`, migration YAML in `config/install/`
