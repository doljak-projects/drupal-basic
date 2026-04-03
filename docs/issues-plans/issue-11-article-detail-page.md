---
issue: 11
title: "feat: article detail page — preprocessors, cache tags and responsive layout"
branch: feat/article-detail-page-11
status: closed
last_updated: 04-02-2026
---

# Issue #11 — Article Detail Page

**Branch:** `feat/article-detail-page-11`
**Worktree:** `worktree-article-detail-page-11`
**Referência Paper:** `Waggy — Article` (desktop 1440 / tablet 768 / mobile 390)

## Objetivo
Implementar a página individual de artigo com fidelidade ao design do Paper,
preprocessors Drupal, cache tags e layout responsivo completo.

## Entregas

- [ ] `node--article.html.twig` — template Twig seguindo o Paper
- [ ] `hook_preprocess_node()` — variáveis limpas para o Twig:
  - data formatada
  - tempo de leitura
  - nome do autor
  - label da categoria
- [ ] `css/layout/article.css` — tipografia, hero image, layout do conteúdo
- [ ] Responsividade: desktop (1440px), tablet (768px), mobile (390px)

## Learning checkpoints
- [ ] Preprocessors — `hook_preprocess_node()` expondo variáveis computadas ao Twig
- [ ] Cache API — entender node cache tags (`[node:X]`) e quando são invalidadas;
      por que o output do preprocess não deve quebrar cacheabilidade
- [ ] Responsiveness — primeira implementação responsiva completa para content page

## Content type: article

**Já existem por padrão:**
- `title` — título do artigo
- `body` — conteúdo principal (summary = subtítulo no hero)
- `field_image` — imagem do hero
- `created` — data de publicação (campo do sistema)

**Adicionar no admin:**
- `field_reading_time` — Text (plain) — ex: "8 min read"
- `field_category` — Text (plain) — ex: "DAILY RHYTHM"

**Opcionais (próximas etapas):**
- `field_tags` — Taxonomy reference
- `field_editor_note` — Text (plain, long)

## Seções da página (Waggy — Article no Paper)

| # | Seção | Descrição |
|---|-------|-----------|
| 1 | Hero | Imagem full-width + overlay, label FROM THE JOURNAL, título, subtítulo (body summary), data + reading time |
| 2 | Body + Aside | 2 colunas: conteúdo principal à esquerda, Latest posts à direita |
| 3 | Tip cards | 2 cards lado a lado dentro do body |
| 4 | Editor note | Bloco escuro com quote |
| 5 | Lista numerada | Passos/rotina do artigo |
| 6 | Comments | Cards de comentários de leitores |
| 7 | Leave a comment | Formulário Name, Email, textarea, botão |
| 8 | Footer | Já existente no projeto |

## Status
- [x] Inspeção dos artboards no Paper
- [x] Fields do content type mapeados
- [ ] Fields criados no admin (você)
- [x] `node--article.html.twig` criado (hero + estrutura body/aside)
- [x] `hook_preprocess_node()` implementado (article_date, article_reading_time, article_category, article_image_url)
- [x] `css/base/article-styling.css` criado — hero desktop + responsivo
- [x] Library registrada em `doljak_theme.libraries.yml`
- [ ] CSS desktop
- [ ] CSS tablet + mobile
- [ ] Revisão de fidelidade ao Paper
- [ ] PR aberto para main
