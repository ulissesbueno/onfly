# Onfly Microserviço

Este repositório contém um microserviço para a plataforma Onfly.

## Pré-requisitos

- [Docker](https://docs.docker.com/get-docker/) instalado
- [Git](https://git-scm.com/) instalado

## Instalação

1. **Clone o repositório:**
    ```bash
    git clone https://github.com/seu-usuario/onfly.git
    cd onfly
    ```

2. **Configure variáveis de ambiente:**
    - Crie um arquivo `.env` com as configurações necessárias (exemplo disponível em `.env.example`).

3. **Construa e execute o serviço com Docker:**
    ```bash
    docker-compose up --build
    ```

## Uso

O microserviço estará disponível em `http://localhost:8000` (ou porta configurada).

## Scripts úteis

- Parar o serviço:
  ```bash
  docker-compose down
  ```