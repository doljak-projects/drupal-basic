# Spec — Login Journey (Static HTML/CSS)

> Referência visual: Waggy Pet Shop (Paper/Figma)
> Escopo: 3 telas × 3 breakpoints = 9 variações
> Telas: Login · Cadastro · Esqueci a Senha

---

## 1. Estrutura de arquivos recomendada

Crie os arquivos **diretamente no tema Drupal**. O HTML será estático agora (sem variáveis Twig); na próxima etapa, basta substituir os valores fixos pelas variáveis do Drupal.

```
web/themes/custom/doljak_theme/
├── css/
│   └── base/
│       └── auth-styling.css          ← CRIAR
├── templates/
│   └── user/                         ← CRIAR pasta
│       ├── user-login-form.html.twig ← CRIAR (Login)
│       ├── user-register-form.html.twig ← CRIAR (Cadastro)
│       └── user-pass.html.twig       ← CRIAR (Esqueci a Senha)
└── doljak_theme.libraries.yml        ← ATUALIZAR: adicionar auth-styling.css
```

**Por que já no tema?**
- Sem arquivos duplicados para gerenciar depois.
- Estrutura de pastas idêntica ao que o Drupal vai processar (`templates/user/`).
- CSS já dentro do sistema de libraries do tema.

---

## 2. Atualização do libraries.yml

Adicionar `auth-styling.css` na library `global-styling` existente:

```yaml
global-styling:
  css:
    base:
      # ... entradas existentes ...
      css/base/auth-styling.css: {}
```

---

## 3. Design Tokens

Todos os tokens já existem em `css/layout/global.css`. **Não redefinir**, apenas consumir.

| Papel | Token |
|---|---|
| Background da página | `--color-bg-base` (#FAF3ED) |
| Card do formulário | `#ffffff` |
| Borda dos inputs | `--color-border` (#EDE4D8) |
| Background do input | `--color-bg-hero` (#F5EDE0) |
| Botão primário (fill) | `--color-accent` (#DE9C6F) |
| Botão primário (hover) | `--color-accent-dark` (#C47A40) |
| Botão secundário | `#ffffff` com borda `--color-border` |
| Texto primário | `--color-text-primary` (#414040) |
| Texto secundário | `--color-text-secondary` (#908F8D) |
| Eyebrow/label | `--color-text-light` (#B0A898) |
| Heading H1 | `--font-display` (Spinnaker) |
| Body/inputs | `--font-body` (Montserrat) |
| Sombra do card | `--shadow-lg` |
| Border radius do card | `--radius-xl` (20px) |
| Border radius dos inputs | `--radius-md` (12px) |
| Border radius do botão | `--radius-pill` (50px) |

---

## 4. Breakpoints

| Nome | Largura | Layout |
|---|---|---|
| Mobile | < 768px | 1 coluna, form card full-width |
| Tablet | 768px – 1199px | 1 coluna, form card centralizado max-width 540px |
| Desktop | ≥ 1200px | 2 colunas (hero esquerda · card direita) |

---

## 5. Componentes compartilhados (não implementar — já existem)

- **Header** (`page.html.twig`) — reutilizar o existente
- **Footer** (`node--footer.html.twig`) — reutilizar o existente
- **CSS base** (`global.css`) — já carregado

As telas de auth são apenas o `<main>` com `<section class="auth-page">` dentro do layout existente.

---

## 6. Tela 1 — Login (`user-login-form.html.twig`)

### Layout

```
[ Desktop ]
┌──────────────────┬──────────────────────┐
│  Hero text       │  Form card           │
│  (col 55%)       │  (col 45%)           │
└──────────────────┴──────────────────────┘

[ Tablet / Mobile ]
┌──────────────────────────────────────────┐
│  Hero text (condensado)                  │
│  Form card (centralizado)                │
└──────────────────────────────────────────┘
```

### HTML — estrutura

```html
<section class="auth-page auth-page--login">
  <div class="auth-page__inner">

    <!-- Coluna esquerda: hero -->
    <div class="auth-hero">
      <p class="auth-hero__eyebrow">WELCOME BACK</p>
      <h1 class="auth-hero__title">Login to keep your pet essentials moving</h1>
      <p class="auth-hero__desc">
        Access orders, saved pets, delivery status and your favorite products in one place.
      </p>
      <div class="auth-hero__stats">
        <div class="auth-stat">
          <strong>24h</strong>
          <span>support access</span>
        </div>
        <div class="auth-stat">
          <strong>1 tap</strong>
          <span>reorder favorites</span>
        </div>
      </div>
    </div>

    <!-- Coluna direita: card -->
    <div class="auth-card">
      <h2 class="auth-card__title">Login</h2>
      <p class="auth-card__subtitle">Use your account email and password.</p>

      <form class="auth-form" action="#" method="post" novalidate>

        <div class="auth-field">
          <label for="login-email">Email</label>
          <input id="login-email" type="email" placeholder="you@example.com" autocomplete="email">
        </div>

        <div class="auth-field">
          <label for="login-password">Password</label>
          <input id="login-password" type="password" placeholder="••••••••••" autocomplete="current-password">
        </div>

        <div class="auth-form__row">
          <label class="auth-checkbox">
            <input type="checkbox"> Remember me
          </label>
          <a href="/user/password" class="auth-link">Forgot password?</a>
        </div>

        <button type="submit" class="btn btn--primary btn--full">Sign In</button>
        <a href="/user/register" class="btn btn--secondary btn--full">Create Account</a>

      </form>
    </div>

  </div>
</section>
```

### Detalhes visuais

- `.auth-page`: `min-height: calc(100vh - 80px - <footer-height>)`, `display: flex; align-items: center`
- `.auth-page__inner`: `display: grid; grid-template-columns: 55fr 45fr; gap: var(--space-20); max-width: var(--container-inner); margin: 0 auto; padding: var(--space-20) var(--gutter)`
- `.auth-hero__eyebrow`: `font-size: var(--text-xs); font-weight: var(--font-semibold); letter-spacing: var(--tracking-widest); color: var(--color-text-light); text-transform: uppercase; margin-bottom: var(--space-4)`
- `.auth-hero__title`: `font-family: var(--font-display); font-size: var(--text-3xl); line-height: 1.15; color: var(--color-text-primary); margin-bottom: var(--space-6)` — no mobile: `font-size: var(--text-2xl)`
- `.auth-hero__desc`: `font-size: var(--text-sm); color: var(--color-text-secondary); line-height: 1.7; margin-bottom: var(--space-10)`
- `.auth-hero__stats`: `display: flex; gap: var(--space-4)`
- `.auth-stat`: `background: var(--color-bg-base); border: 1px solid var(--color-border); border-radius: var(--radius-md); padding: var(--space-5) var(--space-6); min-width: 110px` — `strong`: `font-size: var(--text-xl); font-family: var(--font-display); display: block` — `span`: `font-size: var(--text-xs); color: var(--color-text-secondary)`
- `.auth-card`: `background: #fff; border-radius: var(--radius-xl); box-shadow: var(--shadow-lg); padding: var(--space-12)`
- `.auth-card__title`: `font-family: var(--font-display); font-size: var(--text-2xl); margin-bottom: var(--space-2)`
- `.auth-card__subtitle`: `font-size: var(--text-sm); color: var(--color-text-secondary); margin-bottom: var(--space-8)`

---

## 7. Tela 2 — Cadastro (`user-register-form.html.twig`)

### Diferenças em relação ao Login

**Hero text:**
- Eyebrow: `NEW ACCOUNT`
- H1: `Create a simple profile for faster pet shopping`
- Desc: `Save addresses, track subscriptions and keep your household essentials ready with fewer steps.`
- Sem stat boxes

**Form card:**

```html
<div class="auth-card">
  <h2 class="auth-card__title">Create Account</h2>
  <p class="auth-card__subtitle">Basic information to get started.</p>

  <form class="auth-form" action="#" method="post" novalidate>

    <div class="auth-field-row">
      <div class="auth-field">
        <label for="reg-firstname">First name</label>
        <input id="reg-firstname" type="text" placeholder="Jane" autocomplete="given-name">
      </div>
      <div class="auth-field">
        <label for="reg-lastname">Last name</label>
        <input id="reg-lastname" type="text" placeholder="Doe" autocomplete="family-name">
      </div>
    </div>

    <div class="auth-field">
      <label for="reg-email">Email</label>
      <input id="reg-email" type="email" placeholder="jane@example.com" autocomplete="email">
    </div>

    <div class="auth-field">
      <label for="reg-password">Password</label>
      <input id="reg-password" type="password" placeholder="Minimum 8 characters" autocomplete="new-password">
    </div>

    <div class="auth-field">
      <label for="reg-pettype">Pet type</label>
      <input id="reg-pettype" type="text" placeholder="Dog, Cat, Bird…">
    </div>

    <button type="submit" class="btn btn--primary btn--full">Create My Account</button>

    <p class="auth-form__footer-text">
      Already have an account? <a href="/user/login" class="auth-link">Sign in</a>
    </p>

  </form>
</div>
```

**CSS adicional:**
- `.auth-field-row`: `display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-4)` — no mobile: `grid-template-columns: 1fr`
- `.auth-form__footer-text`: `text-align: center; font-size: var(--text-sm); color: var(--color-text-secondary); margin-top: var(--space-4)`

---

## 8. Tela 3 — Esqueci a Senha (`user-pass.html.twig`)

### Layout — centrado (sem hero lateral em nenhum breakpoint)

```html
<section class="auth-page auth-page--reset">
  <div class="auth-reset__inner">

    <p class="auth-hero__eyebrow">PASSWORD HELP</p>
    <h1 class="auth-reset__title">Reset your password</h1>
    <p class="auth-reset__subtitle">
      Enter your email and we will send a reset link.
    </p>

    <div class="auth-card auth-card--centered">
      <form class="auth-form" action="#" method="post" novalidate>

        <div class="auth-field">
          <label for="reset-email">Email address</label>
          <input id="reset-email" type="email" placeholder="you@example.com" autocomplete="email">
        </div>

        <button type="submit" class="btn btn--primary btn--full">Send Reset Link</button>

        <a href="/user/login" class="auth-link auth-link--center">Back to login</a>

      </form>
    </div>

  </div>
</section>
```

**CSS:**
- `.auth-page--reset`: `text-align: center`
- `.auth-reset__inner`: `max-width: 480px; margin: 0 auto; padding: var(--space-20) var(--gutter)`
- `.auth-reset__title`: `font-family: var(--font-display); font-size: var(--text-3xl); margin-bottom: var(--space-4)` — mobile: `var(--text-2xl)`
- `.auth-reset__subtitle`: `font-size: var(--text-sm); color: var(--color-text-secondary); margin-bottom: var(--space-8)`
- `.auth-card--centered`: sem alteração no card base, apenas contexto já é centralizado
- `.auth-link--center`: `display: block; text-align: center; margin-top: var(--space-5)`

---

## 9. Classes utilitárias compartilhadas (em `auth-styling.css`)

### Inputs

```css
.auth-field {
  display: flex;
  flex-direction: column;
  gap: var(--space-2);
  margin-bottom: var(--space-5);
}

.auth-field label {
  font-size: var(--text-sm);
  font-weight: var(--font-medium);
  color: var(--color-text-primary);
}

.auth-field input {
  background: var(--color-bg-hero);
  border: 1px solid var(--color-border);
  border-radius: var(--radius-md);
  padding: var(--space-4) var(--space-5);
  font-family: var(--font-body);
  font-size: var(--text-sm);
  color: var(--color-text-primary);
  outline: none;
  transition: border-color var(--transition-fast), box-shadow var(--transition-fast);
  width: 100%;
}

.auth-field input:focus {
  border-color: var(--color-accent);
  box-shadow: 0 0 0 3px rgba(222, 156, 111, 0.15);
}

.auth-field input::placeholder {
  color: var(--color-text-light);
}
```

### Botões

```css
.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-family: var(--font-body);
  font-size: var(--text-sm);
  font-weight: var(--font-semibold);
  border-radius: var(--radius-pill);
  padding: var(--space-4) var(--space-8);
  cursor: pointer;
  transition: background-color var(--transition-fast), transform var(--transition-fast);
  border: 1px solid transparent;
  text-decoration: none;
}

.btn--primary {
  background-color: var(--color-accent);
  color: #fff;
  border-color: var(--color-accent);
}

.btn--primary:hover {
  background-color: var(--color-accent-dark);
  border-color: var(--color-accent-dark);
}

.btn--secondary {
  background-color: #fff;
  color: var(--color-text-primary);
  border-color: var(--color-border);
}

.btn--secondary:hover {
  border-color: var(--color-accent);
  color: var(--color-accent);
}

.btn--full {
  width: 100%;
  margin-bottom: var(--space-4);
}
```

### Links e checkbox

```css
.auth-link {
  font-size: var(--text-sm);
  color: var(--color-accent-dark);
  text-decoration: underline;
  text-decoration-color: transparent;
  transition: text-decoration-color var(--transition-fast);
}

.auth-link:hover {
  text-decoration-color: var(--color-accent-dark);
}

.auth-form__row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: var(--space-6);
}

.auth-checkbox {
  display: flex;
  align-items: center;
  gap: var(--space-2);
  font-size: var(--text-sm);
  color: var(--color-text-secondary);
  cursor: pointer;
}
```

---

## 10. Responsivo (`auth-styling.css`)

```css
/* === Tablet ≤ 1199px === */
@media (max-width: 1199px) {
  .auth-page__inner {
    grid-template-columns: 1fr;
    max-width: 540px;
    padding: var(--space-16) var(--space-8);
  }

  .auth-hero__stats {
    display: none; /* ocultar stat boxes no tablet */
  }
}

/* === Mobile ≤ 767px === */
@media (max-width: 767px) {
  .auth-page__inner {
    padding: var(--space-10) var(--space-6);
  }

  .auth-card {
    padding: var(--space-8) var(--space-6);
  }

  .auth-hero__title,
  .auth-reset__title {
    font-size: var(--text-2xl);
  }

  .auth-hero {
    margin-bottom: var(--space-8);
  }

  .auth-field-row {
    grid-template-columns: 1fr;
  }

  .auth-reset__inner {
    padding: var(--space-10) var(--space-6);
  }
}
```

---

## 11. Notas para o Codex

1. **Não alterar** `global.css`, `page.html.twig`, `node--footer.html.twig` — apenas criar os novos arquivos listados.
2. **Atualizar** `doljak_theme.libraries.yml` adicionando `css/base/auth-styling.css: {}` dentro da library `global-styling`.
3. Os arquivos `.html.twig` devem ser HTML puro (sem sintaxe Twig por enquanto). Usar `action="#"` nos forms.
4. Header e Footer **não entram** nos arquivos de template de usuário — o Drupal injeta automaticamente via `page.html.twig`.
5. Manter BEM-like: `.auth-page`, `.auth-card`, `.auth-field`, `.auth-hero`, `.btn` como blocos raiz.
6. Google Fonts já está carregado pelo `libraries.yml` existente — não replicar o `<link>`.
7. Ícones do header (search, wishlist, cart) são blocos Drupal separados — não replicar no static.
