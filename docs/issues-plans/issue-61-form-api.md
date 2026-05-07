---
issue: 61
title: "[Back-End] Form API — study and practical exercise"
branch: feat/form-api-61-form-api-study-and-practical-exercise
status: in-progress
last_updated: 04-07-2026
---

# Issue #61 — [Back-End] Form API — study and practical exercise

## Objective
Study and practice Drupal's Form API for building custom forms with validation and submission handling. Focus on FormBase/ConfigFormBase, form element types, validateForm(), submitForm(), and AJAX form responses — covering Domain 4.1 of the Acquia certification.

## Scope
- Understand FormBase vs ConfigFormBase and when to use each
- Build a custom form with text, select, checkboxes and submit elements
- Implement validateForm() with form_error and setError()
- Implement submitForm() with messenger service and redirect
- Save form values to config using ConfigFormBase
- Add an AJAX callback to a form element using #ajax

## Status
> Atualizado em: 04-07-2026

- [ ] Understand FormBase vs ConfigFormBase and when to use each
- [ ] Build a custom form with text, select, checkboxes and submit elements
- [ ] Implement validateForm() with form_error and setError()
- [ ] Implement submitForm() with messenger service and redirect
- [ ] Save form values to config using ConfigFormBase
- [ ] Add an AJAX callback to a form element using #ajax

## Notes
- Identified as unstudied topic — not yet covered in any session
- Key classes: `FormBase`, `ConfigFormBase`, `FormStateInterface`
- AJAX forms use `#ajax` array key with `callback`, `wrapper` and `effect` keys
