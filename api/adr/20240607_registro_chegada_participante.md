# ADR: Registro de Chegada de Participante em Evento

**Status:** Proposto  
**Data:** 07/06/2024

## Contexto

Foi solicitado o desenvolvimento de um endpoint para registrar a chegada de um participante em um evento. O objetivo é permitir que organizadores marquem a presença dos participantes, atualizando o campo `arrival_date` na tabela de relacionamento `event_participants`.

## Decisão

Será criado o endpoint:

- **POST** `/api/v1/events/{event_id}/participants/arrival`

### Requisitos Técnicos

- **Autenticação:** Obrigatória (usuário deve estar logado)
- **Permissão:** Apenas organizadores do evento podem acessar
- **Request Body:**  
  ```json
  {
    "participant_id": 123
  }
  ```
- **Regras de Negócio:**
  - Verificar se o `participant_id` pertence ao evento (`event_id`).  
    - Se não pertencer, retornar **400 Bad Request** com mensagem: "Participante não faz parte do evento".
  - Se válido, atualizar o campo `arrival_date` do registro em `event_participants` com a data/hora atual do servidor (timestamp com timezone).
  - Retornar um Resource do participante com os dados atualizados.

### Respostas Esperadas

- **200 OK**  
  ```json
  {
    "uuid": "550e8400-e29b-41d4-a716-446655440000",
    "name": "João da Silva",
    "email": "joao@email.com",
    "arrival_date": "2025-06-07T10:45:00-03:00"
  }
  ```
- **401 Unauthorized:** Usuário não autenticado
- **403 Forbidden:** Usuário autenticado, mas não é organizador do evento
- **400 Bad Request:** `participant_id` inválido ou não pertence ao evento

### Observações

- A rota será protegida por middleware/decorator que valida o papel de organizador.
- O campo `arrival_date` será gravado com precisão de timestamp (UTC ou local com timezone, conforme política do sistema).

## Consequências

- Garante rastreabilidade da presença dos participantes.
- Reforça a segurança e integridade dos dados, limitando a ação apenas a organizadores autenticados.
- Facilita a integração com o frontend, retornando o recurso atualizado do participante. 