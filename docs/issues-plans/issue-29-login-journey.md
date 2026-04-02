# Issue #29 — Theme: Implementar HTML e CSS estático da jornada de login

**Branch:** `feat/auth-templates-29-html-css-login-journey`
**Worktree:** `worktree-auth-templates-29`
**Referência Paper:** `Waggy — Login`, `Waggy — Cadastro`, `Waggy — Esqueci a Senha` (desktop 1440 / tablet 768 / mobile 390)
**Spec:** `docs/spec-login-journey.md`

## Objetivo

Implementar as telas estáticas da jornada de autenticação do tema `doljak_theme`,
com HTML/Twig e CSS, seguindo o design do Waggy Pet Shop. HTML estático por enquanto
(sem variáveis Twig); integração com o módulo User do Drupal é etapa futura.

## Status

- [x] `user-login-form.html.twig` — tela de Login (desktop + tablet + mobile)
- [x] `user-register-form.html.twig` — tela de Cadastro (desktop + tablet + mobile)
- [x] `user-pass.html.twig` — tela de Esqueci a Senha (desktop + tablet + mobile)
- [x] `css/base/auth-styling.css` — estilos da jornada
- [x] `doljak_theme.libraries.yml` atualizado com `auth-styling.css`
- [ ] Integração dinâmica com Drupal User module (próxima etapa)

## Arquivos adicionados

- `web/themes/custom/doljak_theme/templates/user/user-login-form.html.twig`
- `web/themes/custom/doljak_theme/templates/user/user-register-form.html.twig`
- `web/themes/custom/doljak_theme/templates/user/user-pass.html.twig`
- `web/themes/custom/doljak_theme/css/base/auth-styling.css`

## Arquivos atualizados

- `web/themes/custom/doljak_theme/doljak_theme.libraries.yml`

## Estrutura das telas

| Tela | Layout desktop | Layout mobile |
|---|---|---|
| Login | 2 colunas (hero esquerda · card direita) | 1 coluna empilhado |
| Cadastro | 2 colunas (hero esquerda · card direita) | 1 coluna empilhado |
| Esqueci a Senha | Centralizado (sem hero lateral) | Centralizado |

## Decisões de implementação

- Templates ficam em `templates/user/` — pasta padrão do Drupal para override do módulo User.
  Quando a integração dinâmica for feita, basta substituir os valores fixos pelas variáveis Twig
  sem mover nenhum arquivo.
- CSS usa exclusivamente tokens de `css/layout/global.css` — nenhuma cor ou espaçamento hardcoded.
- Breakpoints: desktop ≥ 1200px · tablet 768–1199px · mobile < 768px.
- Botões e inputs extraídos como classes utilitárias (`.btn`, `.auth-field`) reutilizáveis.

## Próxima etapa (fora do escopo desta issue)

Substituir o HTML estático por variáveis e formulários reais do Drupal:
- `{{ form }}` no lugar dos `<form>` manuais
- Campos `{{ form.name }}`, `{{ form.pass }}`, `{{ form.actions }}` etc.
- Tratar mensagens de erro/validação via `{{ messages }}`
