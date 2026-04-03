---
issue: 19
title: "[Blog] Static layout for article listing page"
branch: feat/blog-article-listing-19
status: closed
last_updated: 04-02-2026
---

# Issue #19 — Journal: Static layout for article listing page

**Branch:** `feat/blog-article-listing-19`
**Worktree:** `worktree-blog-article-listing-19`
**Referência Paper:** `Waggy — Journal` (desktop 1440 / tablet 768 / mobile 390)
**Spec:** `docs/specs/issues/issue-19-journal-listing.md`

## Objetivo
Implementar o layout estático da página de listagem de artigos (Journal)
com HTML/Twig e CSS, sem integração com Views ou dados dinâmicos nesta etapa.

## Atualização desta worktree

Implementação visual estática criada na camada de tema, sem alterações em PHP
ou core.

### Arquivos adicionados

- `web/themes/custom/doljak_theme/templates/views-view--journal.html.twig`
- `web/themes/custom/doljak_theme/templates/views-view-unformatted--journal.html.twig`
- `web/themes/custom/doljak_theme/templates/views-view-fields--journal.html.twig`
- `web/themes/custom/doljak_theme/css/base/journal-styling.css`
- `web/themes/custom/doljak_theme/assets/journal/*`

### Arquivos atualizados

- `web/themes/custom/doljak_theme/doljak_theme.libraries.yml`

### Observações de implementação

- O template `views-view--journal.html.twig` renderiza uma versão estática da
  página completa com:
  - barra de filtros/sort
  - hero editorial
  - grid com 6 article cards
  - seção "Shop the stories"
  - CTA final com newsletter + reader list
- O template `views-view-fields--journal.html.twig` já ficou preparado para a
  futura troca do conteúdo estático por dados reais da View.
- O CSS foi construído com base nos tokens de `css/layout/global.css` e cobre
  desktop, tablet e mobile.
- Foram copiados assets estáticos para dentro do tema apenas para esta etapa
  visual.
- Ainda não existe `views.view.journal.yml` nesta worktree, então a integração
  final da página com uma View Drupal continua pendente.
- A inspeção visual foi baseada nos artboards do Paper (`Waggy — Journal`),
  mas a validação final no browser desta worktree ainda depende do ambiente
  local apontar para ela.

---

## Convenções do projeto — SEGUIR OBRIGATORIAMENTE

### Estrutura de pastas do tema
```
web/themes/custom/doljak_theme/
  css/
    base/          # Estilos de componente (hero, produto, shop...)
    layout/        # global.css — tokens de design (cores, tipografia, espaçamento)
  js/
  templates/
```

### Nomenclatura de arquivos CSS
| Padrão existente | Novo arquivo (esta issue) |
|------------------|--------------------------|
| `css/base/hero-styling.css` | `css/base/journal-styling.css` |
| `css/base/shop-styling.css` | — |

### Nomenclatura de templates Twig
| Padrão existente | Novo arquivo (esta issue) |
|------------------|--------------------------|
| `views-view--shop.html.twig` | `views-view--journal.html.twig` |
| `views-view-unformatted--shop.html.twig` | `views-view-unformatted--journal.html.twig` |
| `views-view-fields--shop.html.twig` | `views-view-fields--journal.html.twig` |

### Registrar CSS em doljak_theme.libraries.yml
Adicionar entrada seguindo o padrão existente:
```yaml
global-styling:
  css:
    base:
      css/base/journal-styling.css: {}  # adicionar aqui
```

### Tokens de design (global.css)
Usar sempre variáveis CSS de `css/layout/global.css`. Nunca valores hardcoded.
Exemplos: `var(--color-*)`, `var(--text-*)`, `var(--space-*)`, `var(--radius-*)`.

---

## Hierarquia de templates

```
views-view--journal.html.twig
    └── views-view-unformatted--journal.html.twig
            └── views-view-fields--journal.html.twig
```

O Drupal liga automaticamente pelo machine name da View (`journal`).

---

## Seções da página

| # | Seção | Arquivo responsável |
|---|-------|-------------------|
| 1 | Filtros/sort (Latest, Most Read, Featured) | `views-view--journal.html.twig` |
| 2 | Archive hero (label + título + subtítulo) | `views-view--journal.html.twig` |
| 3 | Grid de cards (2 colunas, 6 cards) | `views-view-fields--journal.html.twig` |
| 4 | Shop the Stories (carrossel de produtos) | `views-view--journal.html.twig` |
| 5 | Journal CTA (newsletter + reader list) | `views-view--journal.html.twig` |
| 6 | Footer | já existente — não tocar |

### Estrutura do article card
Cada card em `views-view-fields--journal.html.twig`:
- Imagem
- Categoria + data
- Título
- Excerpt (body summary)
- Tags (pills)
- Link "Read article"

---

## Content type: article

**Fields disponíveis (padrão Drupal):**
- `title` — título
- `body` — conteúdo (summary = excerpt no card)
- `field_image` — imagem
- `created` — data

**Fields a adicionar (coordenar com issue #11):**
- `field_reading_time` — Text plain
- `field_category` — Text plain
- `field_tags` — Taxonomy reference (opcional)

> ⚠️ Os fields são compartilhados com a issue #11 (article detail).
> Não criar fields duplicados — verificar se já existem antes de criar.

---

## Status
- [X] Inspeção dos artboards no Paper (Journal desktop/tablet/mobile)
- [X] `views-view--journal.html.twig` criado
- [X] `views-view-unformatted--journal.html.twig` criado
- [X] `views-view-fields--journal.html.twig` criado
- [X] `css/base/journal-styling.css` criado
- [X] Library registrada em `doljak_theme.libraries.yml`
- [X] CSS desktop
- [X] CSS tablet + mobile
- [ ] Revisão de fidelidade ao Paper
- [ ] PR aberto para main

## Pendências

- Criar ou exportar a View `journal` para o Drupal ligar estes templates
  automaticamente pelo machine name.
- Validar a fidelidade visual final no browser da própria worktree.
- Substituir o conteúdo estático do template principal pelos dados reais da
  View quando a integração estiver pronta.
