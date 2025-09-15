# Onfly Microserviço

Este repositório foi criado para o teste técnico da empresa Onfly. Ele contém um microserviço desenvolvido como parte do processo seletivo, seguindo os requisitos e padrões solicitados pela equipe técnica.

## Pré-requisitos

- [Docker](https://docs.docker.com/get-docker/) instalado
- [Git](https://git-scm.com/) instalado

## Instalação

1. **Clone o repositório:**
    ```bash
    git clone git@github.com:ulissesbueno/onfly.git
    cd onfly
    ```

2. **Configure variáveis de ambiente:**
    - Crie um arquivo `.env` com as configurações necessárias (exemplo disponível em `.env.example`).

3. **Construa e execute o serviço com Docker:**
    ```bash
    docker-compose up --build
    ```

## Uso

O microserviço estará disponível em `http://localhost:8080` (ou porta configurada).

## Scripts úteis

- Parar o serviço:
  ```bash
  docker-compose down
  ```

## Testes

- Para rodar os testes unitários:
  ```bash
  docker exec app.onfly php artisan test
  ```

- Deixei uma collection do Postman para ajudar: Onfly.postman_collection.json
