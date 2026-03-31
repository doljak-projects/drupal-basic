# Spec — Issue #19: Journal Listing

## Identificação

- Issue: `#19`
- Branch: `feat/blog-article-listing-19`
- Worktree: `worktree-blog-article-listing-19`
- Paper: `Waggy — Journal`
- Artboards de referência:
  - desktop `1440`
  - tablet `768`
  - mobile `390`

## Objetivo

Construir a camada visual estática da página `Journal`, equivalente à listagem
de artigos do blog, usando apenas `Twig + CSS` no tema customizado.

Nesta etapa, o foco é entregar a experiência visual da página, sem depender de
Views dinâmicas, preprocess, PHP customizado ou alterações de core.

## Escopo desta spec

Inclui:

- estrutura visual da página `Journal`
- templates Twig do tema para a view `journal`
- CSS responsivo da página
- assets estáticos necessários para reproduzir o layout
- contrato inicial para futura integração com a View Drupal

Não inclui:

- criação ou alteração de PHP
- alterações de core
- criação de fields
- criação/export final de `views.view.journal.yml`
- integração com dados reais

## Referências de contexto

- plano da issue: `docs/issues-plans/issue-19-journal-listing.md`
- visão geral do projeto: `README.md`
- tokens globais do tema: `web/themes/custom/doljak_theme/css/layout/global.css`

## Restrições

- Nesta seção, atuar apenas em camada visual.
- Se surgir necessidade de tocar em PHP ou core, isso precisa ser autorizado à parte.
- Usar tokens existentes de `global.css` em vez de valores soltos sempre que possível.
- Preservar o padrão já existente do tema `doljak_theme`.

## Estrutura de arquivos

### Templates

- `web/themes/custom/doljak_theme/templates/views-view--journal.html.twig`
- `web/themes/custom/doljak_theme/templates/views-view-unformatted--journal.html.twig`
- `web/themes/custom/doljak_theme/templates/views-view-fields--journal.html.twig`

### Estilos

- `web/themes/custom/doljak_theme/css/base/journal-styling.css`

### Registro de library

- `web/themes/custom/doljak_theme/doljak_theme.libraries.yml`

### Assets estáticos

- `web/themes/custom/doljak_theme/assets/journal/`

## Contrato visual da página

### 1. Filter bar

Conteúdo:

- chips `Latest`, `Most Read`, `Featured`
- bloco de sort com label `Sort`
- valor visual `Newest first`
- botão circular com seta

Responsável:

- `views-view--journal.html.twig`
- `journal-styling.css`

### 2. Intro editorial

Conteúdo:

- eyebrow `Archive`
- headline principal
- texto de apoio lateral

Responsável:

- `views-view--journal.html.twig`
- `journal-styling.css`

### 3. Grid de artigos

Conteúdo:

- 6 cards
- desktop com 2 colunas
- tablet/mobile com empilhamento progressivo

Cada card deve conter:

- imagem
- categoria
- data
- título
- excerpt
- tags em pills
- CTA `Read article`

Responsável:

- estático: `views-view--journal.html.twig`
- integração futura: `views-view-fields--journal.html.twig`
- estilo: `journal-styling.css`

### 4. Shop the stories

Conteúdo:

- eyebrow `Shop the stories`
- título da seção
- ações visuais anterior/próximo
- 4 product cards estáticos

Cada product card deve conter:

- badge
- imagem
- categoria
- título
- preço
- preço comparativo quando existir
- caption curta
- botão circular `+`

Responsável:

- `views-view--journal.html.twig`
- `journal-styling.css`

### 5. CTA final

Bloco esquerdo:

- eyebrow `Newsletter`
- headline curta
- texto de apoio

Bloco direito:

- eyebrow `Reader list`
- headline
- botão circular com seta
- campo visual de email

Responsável:

- `views-view--journal.html.twig`
- `journal-styling.css`

## Estratégia de implementação

### Estado atual

O template principal `views-view--journal.html.twig` foi implementado como
estrutura estática completa, com arrays locais para artigos e produtos.

Isso permite:

- montar a experiência visual imediatamente
- validar hierarquia, espaçamento e proporção
- manter um contrato claro para trocar o conteúdo estático depois

### Preparação para integração futura

O arquivo `views-view-fields--journal.html.twig` já foi preparado para receber:

- `title`
- `body`
- `field_image`
- `created`
- `field_tags`
- `field_category` como fallback opcional, se existir

Se a View `journal` for criada depois com machine name compatível, o tema já
tem a base de override pronta.

## Assets

Assets copiados para o tema em:

- `web/themes/custom/doljak_theme/assets/journal/`

Uso atual:

- 6 imagens para article cards
- 4 imagens para product cards

Motivo:

- evitar depender de caminhos externos ou de mídia dinâmica nesta etapa
- permitir fidelidade visual mínima do layout estático

## Responsividade

### Desktop

- toolbar horizontal
- intro em duas colunas
- grid de artigos em 2 colunas
- grid de produtos em 4 colunas
- CTA final em 2 colunas

### Tablet

- toolbar com empilhamento quando necessário
- títulos reduzidos
- grid de produtos em 2 colunas
- CTA final em 1 coluna

### Mobile

- layout em coluna única
- filtros e formulário empilhados
- cards ajustados para largura total
- CTA final com input verticalizado

## Critérios de aceite

- existe um template `views-view--journal.html.twig` para a página
- existe um template `views-view-fields--journal.html.twig` para cards
- existe `journal-styling.css` registrado na library global do tema
- a composição visual segue o Paper `Waggy — Journal`
- a página possui versão estática coerente para desktop, tablet e mobile
- nenhuma alteração em PHP ou core é necessária para esta entrega visual

## Pendências

- criar/exportar a View Drupal `journal`
- validar no browser usando a própria worktree ativa
- substituir o conteúdo estático pelos dados reais da View
- decidir se `field_category` e `field_reading_time` entram na integração final

## Decisão de documentação

Este arquivo é o `spec` da issue e deve servir como referência rápida de
contexto técnico e visual.

O arquivo abaixo continua sendo o rastreio de execução da tarefa:

- `docs/issues-plans/issue-19-journal-listing.md`
