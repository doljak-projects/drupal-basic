---
issue: 86
title: "[Back-End] Auth Forms — connect static templates to Drupal User module"
branch: feat/auth-forms-86-connect-static-templates-drupal-user-module
status: closed
last_updated: 05-18-2026
---

# Issue #86 — Auth Forms — connect static templates to Drupal User module

## Objective
Connect the three existing static auth templates (user-login-form, user-register-form, user-pass) to Drupal's real User module forms. Replace hardcoded HTML with Form API render elements, apply CSS classes via hook_form_alter, and align field structure with what Drupal core actually provides.

## Scope
- Analyze field mismatches between static templates and Drupal core forms (username vs email, register fields that don't exist in core)
- Implement hook_form_alter() in doljak_theme.theme to inject CSS classes into form render arrays
- Update user-login-form.html.twig to render {{ form.name }}, {{ form.pass }}, {{ form.actions }}
- Update user-register-form.html.twig to align with core fields (name, mail, pass) and remove non-existent fields (first/last name, pet type)
- Update user-pass.html.twig to render the real reset form
- Validate output against Waggy design across all 3 breakpoints

## Status
> Updated on: 05-07-2026

- [ ] Passo 1 — dump para confirmar campos reais nos 3 forms
- [ ] Passo 2+3 — hook_form_alter + template do login
- [ ] Passo 4 — hook_form_alter + template do password reset
- [ ] Passo 5 — hook_form_alter + template do register
- [ ] Passo 6 — validar os 3 forms no browser

---

## Referência rápida

### Mapeamento form ID → template
| Form ID | Template |
|---|---|
| `user_login_form` | `templates/user/user-login-form.html.twig` |
| `user_register_form` | `templates/user/user-register-form.html.twig` |
| `user_pass` | `templates/user/user-pass.html.twig` |

### Campos reais por form
| Form | Campos |
|---|---|
| login | `name`, `pass`, `actions` |
| register | `account.name`, `account.mail`, `account.pass`, `actions` |
| password reset | `name`, `actions` |

### Regras do Twig
- **Não escrever `<form>` manualmente** — o Drupal injeta a tag automaticamente
- **Hidden fields obrigatórios** sempre incluir ao final:
  ```twig
  {{ form.form_token }}
  {{ form.form_build_id }}
  {{ form.form_id }}
  ```
- `#wrapper_attributes` = `<div>` que envolve label + input
- `#attributes` = o `<input>` em si

---

## Passo 1 — Inspecionar campos reais (dump)

Adicione temporariamente no início de cada template e acesse a URL após `ddev drush cr`:

```twig
{{ dump(form|keys) }}
```

Para o register, adicione também:
```twig
{{ dump(form.account|keys) }}
```

URLs: `/user/login` · `/user/register` · `/user/password`

Remova os `dump()` antes de continuar.

---

## Passo 2 — hook_form_alter: login

Em `doljak_theme.theme`, adicione:

```php
function doljak_theme_form_user_login_form_alter(array &$form, FormStateInterface $form_state, string $form_id): void {
  $form['#attributes']['class'][] = 'auth-form';

  $form['name']['#wrapper_attributes']['class'][] = 'auth-field';
  $form['name']['#attributes']['class'][] = 'auth-field__input';

  $form['pass']['#wrapper_attributes']['class'][] = 'auth-field';
  $form['pass']['#attributes']['class'][] = 'auth-field__input';

  $form['actions']['submit']['#attributes']['class'][] = 'btn';
  $form['actions']['submit']['#attributes']['class'][] = 'btn--primary';
  $form['actions']['submit']['#attributes']['class'][] = 'btn--full';
}
```

---

## Passo 3 — Template: user-login-form.html.twig

```twig
<section class="auth-page auth-page--login">
  <div class="auth-page__inner">

    <div class="auth-hero">
      <p class="auth-hero__eyebrow">WELCOME BACK</p>
      <h1 class="auth-hero__title">Login to keep your pet essentials moving</h1>
      <p class="auth-hero__desc">
        Access orders, saved pets, delivery status and your favorite products in one place.
      </p>
      <div class="auth-hero__stats">
        <div class="auth-stat"><strong>24h</strong><span>support access</span></div>
        <div class="auth-stat"><strong>1 tap</strong><span>reorder favorites</span></div>
      </div>
    </div>

    <div class="auth-card">
      <h2 class="auth-card__title">Login</h2>
      <p class="auth-card__subtitle">Use your account email and password.</p>

      {{ form.name }}
      {{ form.pass }}

      <div class="auth-form__row">
        <a href="/user/password" class="auth-link">Forgot password?</a>
      </div>

      {{ form.actions }}

      {{ form.form_token }}
      {{ form.form_build_id }}
      {{ form.form_id }}
    </div>

  </div>
</section>
```

---

## Passo 4 — hook_form_alter + template: password reset

Hook em `doljak_theme.theme`:

```php
function doljak_theme_form_user_pass_alter(array &$form, FormStateInterface $form_state, string $form_id): void {
  $form['#attributes']['class'][] = 'auth-form';

  $form['name']['#wrapper_attributes']['class'][] = 'auth-field';
  $form['name']['#attributes']['class'][] = 'auth-field__input';

  $form['actions']['submit']['#attributes']['class'][] = 'btn';
  $form['actions']['submit']['#attributes']['class'][] = 'btn--primary';
  $form['actions']['submit']['#attributes']['class'][] = 'btn--full';
}
```

Em `user-pass.html.twig`: mantém o wrapper de layout estático, substitui o `<form>` por:

```twig
{{ form.name }}
{{ form.actions }}
{{ form.form_token }}
{{ form.form_build_id }}
{{ form.form_id }}
```

---

## Passo 5 — hook_form_alter + template: register

Atenção: campos dentro de `$form['account']`.

Hook em `doljak_theme.theme`:

```php
function doljak_theme_form_user_register_form_alter(array &$form, FormStateInterface $form_state, string $form_id): void {
  $form['#attributes']['class'][] = 'auth-form';

  $form['account']['name']['#wrapper_attributes']['class'][] = 'auth-field';
  $form['account']['name']['#attributes']['class'][] = 'auth-field__input';

  $form['account']['mail']['#wrapper_attributes']['class'][] = 'auth-field';
  $form['account']['mail']['#attributes']['class'][] = 'auth-field__input';

  $form['account']['pass']['#wrapper_attributes']['class'][] = 'auth-field';

  $form['actions']['submit']['#attributes']['class'][] = 'btn';
  $form['actions']['submit']['#attributes']['class'][] = 'btn--primary';
  $form['actions']['submit']['#attributes']['class'][] = 'btn--full';
}
```

Em `user-register-form.html.twig`: remover first name, last name e pet type; usar:

```twig
{{ form.account.name }}
{{ form.account.mail }}
{{ form.account.pass }}
{{ form.actions }}
{{ form.form_token }}
{{ form.form_build_id }}
{{ form.form_id }}
```

> O campo `pass` no register gera dois inputs (password + confirmar) automaticamente.

---

## Passo 6 — Testar

```bash
ddev drush cr
```

Para cada form:
1. Acesse a URL e inspecione o HTML — confirmar classes CSS do Waggy nos elementos
2. Submeta com dados inválidos — Drupal deve exibir mensagens de erro nativas
3. Submeta com dados válidos — login autentica, register cria conta, pass envia email

---

## Notes
_(adicionar notas de decisão, bloqueios ou contexto relevante conforme o trabalho avançar)_
