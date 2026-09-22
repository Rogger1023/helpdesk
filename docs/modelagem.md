## Modelagem BD helpdesk

## Responsável 

campos: 
    - id
    - nome 
    - email
    - created_at
    - updated_at

## Chamado

campos:
    - id
    - titulo
    - descricao
    - prioridades
    - status
    - responsavel_id
    - aberto_em
    - created_at
    - updated_at 

## Relacionamento

Um responsável pode possuir vários chamados. 
Um chamado pertence a um responsável.

Responsável 1:N Chamados 

## Prioridades

    - Baixa
    - Media
    - Alta

## Status 
    - aberto 
    - em_aberto
    - resolvido
    - fechado

## Regra de chamados em aberto

Considerei como não concluimos:
    - aberto
    - em_andamento

Considerei como concluidos: 

    - resolvido
    - fechado

Essa definição será utilizada futuramente na distribuição 
automatica de chamados.   