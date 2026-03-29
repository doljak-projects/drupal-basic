# Drupal PoC — Aprendizado Prático

Este repositório é uma **prova de conceito (POC)** de estudo do Drupal 11, com foco em exercícios progressivos que cobrem desde os conceitos mais básicos até os recursos avançados do framework.

O objetivo não é construir um produto final, mas sim explorar e documentar na prática cada camada do Drupal, consolidando o entendimento real de como o CMS funciona por dentro.

## Ambiente

- **Drupal**: 11.x
- **PHP**: 8.3
- **Banco de dados**: MariaDB 11.8
- **Servidor**: nginx-fpm via DDEV
- **URL local**: http://drupal-treino-b.ddev.site

## Escopo de Negócio

O projeto simula o site de um **petshop fictício**, usado como contexto prático para os exercícios. O escopo público de apresentação inclui:

- **Home**: página estática com listagem de artigos do blog
- **Aside**: lista de produtos à venda, separados por categoria, com links direcionando para um e-commerce fictício da loja
- **Página de produto**: exibe a descrição detalhada de cada produto

O escopo será expandido conforme os tópicos forem abordados nos exercícios.

## Escopo dos Exercícios

### Basico

- [X] Instalação e configuração do ambiente com DDEV
- [X] Estrutura de diretórios e arquivos essenciais do Drupal
- [X] Tipos de conteúdo (Content Types) e campos (Fields)
- [X] Taxonomias e vocabulários
- [X] Menus e links de navegação
- [X] Blocos: criação, posicionamento e visibilidade
- [X] Usuários, papéis (roles) e permissões
- [X] Tema administrador com Gin

### Intermediário

- [ ] Views: criação de listagens, filtros e displays — aplicado na seção Blog (listagem de artigos)
- [X] Config API: exportar e importar configurações com `cex` / `cim`
- [X] Criação de módulo customizado simples (hook_theme, routing, controller)
  - [X] hook_theme — registro de templates customizados
  - [X] routing — via plugin system (Block)
  - [ ] controller — rota com página própria e render array
- [ ] Formulários com Form API
- [X] Criação de tema customizado com Starterkit
- [X] Twig: templates, variáveis, filtros e funções
- [ ] Preprocessors (`hook_preprocess_*`)
- [X] Bibliotecas de assets (libraries.yml, attachTo)
- [ ] Responsividade: media queries em CSS do tema customizado, breakpoints mobile/tablet/desktop
- [ ] Migrations básicas com Migrate API

### Avancado

- [ ] Serviços e injeção de dependência (Dependency Injection / Service Container)
- [X] Plugins: criação de tipos de bloco, campo e formatador customizados
  - [X] tipo de bloco — Block plugins com @Block annotation
  - [ ] campo customizado — FieldType plugin
  - [ ] formatador customizado — FieldFormatter plugin
- [ ] Event Subscribers e hooks via classes
- [ ] Queue API e processamento em background
- [ ] Cache API: cache tags, contexts e invalidação
- [ ] REST API e JSON:API
  - [ ] JSON:API nativo — produtos cadastrados no Drupal, consumidos via `/jsonapi/node/product` no bloco Shop by Pet
  - [ ] Guzzle (HTTP client server-side) — consumir API externa no backend; chave de API protegida, cliente não vê a URL
  - [ ] JavaScript fetch (client-side) — filtrar produtos sem reload de página; URL exposta ao browser
- [ ] Paragraphs e layouts com Layout Builder
- [ ] Migrate API avançado: migrações com transformações complexas
- [ ] Testes automatizados com PHPUnit e Nightwatch

## Como rodar

```bash
ddev start
ddev drush si --existing-config   # instalar com config existente
ddev drush cr                     # limpar cache
```

Acesse: http://drupal-treino-b.ddev.site
