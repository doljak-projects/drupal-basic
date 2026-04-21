---
issue: 79
title: "[Theme + Form API] Contact page — Twig template, CSS layout and Drupal form integration"
branch: feat/contact-page-79-twig-template-css-layout-and-drupal-form-integration
status: in-progress
last_updated: 04-20-2026
---

# Issue #79 — [Theme + Form API] Contact page — Twig template, CSS layout and Drupal form integration

## Objective
Implement the Waggy Contact page at /contact by creating a custom Twig template for the contact form, applying CSS layout aligned with the Waggy Paper design, and wiring Drupal's core contact form fields into the styled markup.

## Scope
- Create contact-site-page.html.twig in doljak_theme overriding the /contact page
- Create contact-message-form.html.twig rendering individual form fields
- Apply CSS for the contact page layout (form card, fields, labels, submit button)
- Cover desktop, tablet and mobile breakpoints
- Register the contact library in doljak_theme.libraries.yml and attach via template
- Validate the form submits correctly and Mailpit captures the email

## Status
> Atualizado em: 04-20-2026

- [x] contact-site-page.html.twig criado
- [x] contact-message-form.html.twig criado
- [x] CSS do layout de contato aplicado (desktop, tablet, mobile)
- [x] Biblioteca registrada em libraries.yml e anexada via template
- [ ] Envio validado no Mailpit

## Notes
- Template suggestions: contact-site-page.html.twig > contact-message-form.html.twig
- Variáveis do form: form.name, form.mail, form.subject, form.message, form.actions
- form_id gerado: contact_message_waggy_contact_form
- Usar {{ attach_library('doljak_theme/contact') }} no template
- Os templates de auth (login/register/pass) já existem como HTML estático — hook_form_alter pendente para issue futura

## Progress log
- 04-20-2026: criados `templates/contact-site-page.html.twig`, `templates/contact-message-form.html.twig` e o fallback funcional `templates/form--contact-message-waggy-contact-form.html.twig`
- 04-20-2026: criada a library `contact` em `doljak_theme.libraries.yml` com `css/base/contact-styling.css`
- 04-20-2026: `doljak_theme.theme` atualizado com hook de tema/preprocess para o form de contato
- 04-20-2026: cache rebuild executado via DDEV com sucesso
- 04-20-2026: validação HTTP/Mailpit pendente porque o projeto DDEV ativo está ancorado na worktree `main`, não na `worktree-contact-page-79`
