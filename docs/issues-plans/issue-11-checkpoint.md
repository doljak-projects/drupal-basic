# Issue #11 — Checkpoint: onde paramos

**Data:** 2026-04-01
**Branch:** `feat/article-detail-page-11`
**Worktree:** `worktree-article-detail-page-11`

---

## O que está feito

### Página de detalhe do artigo (`node--article.html.twig`)
- [x] Template criado com hero + estrutura body/aside (2 colunas)
- [x] `hook_preprocess_node()` implementado — expõe ao Twig:
  - `article_date` — data formatada
  - `article_reading_time` — tempo de leitura
  - `article_category` — label da categoria
  - `article_image_url` — URL da imagem hero
- [x] `css/base/article-styling.css` criado — hero desktop
- [x] Library registrada em `doljak_theme.libraries.yml`

### Listagem de artigos (Journal — View)
- [x] `views-view--journal.html.twig` — **agora dinâmico** (antes era scaffold estático)
- [x] `views-view-unformatted--journal.html.twig` — grid com `{% for row in rows %}`
- [x] `views-view-fields--journal.html.twig` — card dinâmico via fields da View
- [x] `css/base/journal-styling.css` — estilos da listagem
- [x] View `journal` criada no admin Drupal (`/admin/structure/views`) com campos:
  - `field_image`, `field_category`, `created`, `title`, `body` (trimmed), `field_tags`
  - Path: `/blog` · Formato: Unformatted list of Fields · 6 itens + pager
- [x] Bug de apostrofo corrigido no template (`pet''s food` → `"pet's food"`)
- [x] 16 artigos criados no Drupal para popular a listagem

---

## O que falta

### Página de detalhe do artigo
- [ ] CSS desktop — seções body/aside, tip cards, editor note, lista numerada, comments, formulário de comentário
- [ ] CSS tablet (768px) e mobile (390px)
- [ ] Revisão de fidelidade ao Paper (`Waggy — Article`)
- [ ] Fields criados no admin: `field_reading_time` e `field_category` (verificar se já foram criados)

### Listagem de artigos (Journal)
- [ ] CSS tablet e mobile para `journal-styling.css`
- [ ] Revisão de fidelidade ao Paper (`Waggy — Journal`)

### Encerramento
- [ ] PR aberto para `main`

---

## Próximo passo sugerido

Retomar pelo CSS da página de detalhe do artigo (`node--article.html.twig`),
seção body/aside — é a parte mais complexa e ainda sem estilo.
Inspecionar `Waggy — Article` no Paper antes de começar.

---

## Observações

- O DDEV serve sempre do `main/web/` — qualquer correção urgente de bug precisa
  ser feita no `main` também (além do worktree), até o PR ser mergeado.
- O `views-view--journal.html.twig` foi reescrito durante esta sessão para ser dinâmico;
  a versão estática original foi descartada.
