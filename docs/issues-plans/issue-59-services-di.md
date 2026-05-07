---
issue: 59
title: "[Back-End] Services and Dependency Injection — study and practical exercise"
branch: feat/services-di-59-services-and-dependency-injection-study-and-practical-exercise
status: in-progress
last_updated: 04-07-2026
---

# Issue #59 — [Back-End] Services and Dependency Injection — study and practical exercise

## Objective
Study and practice Drupal's Service Container and Dependency Injection pattern as the standard way to decouple and test backend code. Focus on services.yml declaration, ContainerFactoryPluginInterface, the create() method, and how to inject services into controllers, blocks and custom services — covering Domain 4.2 of the Acquia certification.

## Scope
- Understand the Service Container and how services are registered in services.yml
- Study ContainerFactoryPluginInterface and the create() static method pattern
- Inject a custom service into a Block plugin using DI (no static \Drupal:: calls)
- Create a custom service class and register it in services.yml
- Consume the custom service from a controller via constructor injection
- Compare \Drupal::service() (static) vs injected service (DI) — when to use each

## Status
> Atualizado em: 04-07-2026

- [ ] Understand the Service Container and how services are registered in services.yml
- [ ] Study ContainerFactoryPluginInterface and the create() static method pattern
- [ ] Inject a custom service into a Block plugin using DI (no static \Drupal:: calls)
- [ ] Create a custom service class and register it in services.yml
- [ ] Consume the custom service from a controller via constructor injection
- [ ] Compare \Drupal::service() (static) vs injected service (DI) — when to use each

## Notes
- Identified as a recurring gap in Acquia certification simulados 1 and 2 (Domain 4.2)
- First real DI example already exists in the project: FooterBlock + EntityTypeManagerInterface (issue #28)
- Use FooterBlock as reference when studying the create() pattern
- Key files: `<module>.services.yml`, `ContainerFactoryPluginInterface`, `ContainerInterface`
