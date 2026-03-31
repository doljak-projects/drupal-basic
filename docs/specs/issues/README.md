# Specs de Issues

Esta pasta guarda o `spec` funcional e visual de cada issue.

## Objetivo

O `spec` existe para servir como contexto estável de retomada.

Ele deve responder rapidamente:

- o que está sendo construído
- o que está fora de escopo
- quais arquivos participam da entrega
- qual é o contrato visual ou técnico esperado
- quais restrições precisam ser respeitadas
- o que ainda falta integrar

## Diferença entre `spec` e `issue-plan`

### `docs/specs/issues/`

Use esta pasta para documentação mais estável.

Conteúdo esperado:

- objetivo
- escopo e fora de escopo
- contrato da solução
- estrutura de arquivos
- critérios de aceite
- pendências de integração

### `docs/issues-plans/`

Use esta pasta para acompanhamento de execução.

Conteúdo esperado:

- checklist de implementação
- status atual
- observações da worktree
- decisões tomadas durante a execução

## Convenção

- Um arquivo de `spec` por issue.
- Nome recomendado: `issue-<numero>-<slug>.md`
- O `issue-plan` correspondente deve apontar para o `spec`.

## Exemplo atual

- Spec: `docs/specs/issues/issue-19-journal-listing.md`
- Issue plan: `docs/issues-plans/issue-19-journal-listing.md`

## Regra prática

Se a informação for útil para qualquer próxima IA ou retomada futura, ela tende
a pertencer ao `spec`.

Se a informação descreve progresso, execução ou estado momentâneo da worktree,
ela tende a pertencer ao `issue-plan`.
