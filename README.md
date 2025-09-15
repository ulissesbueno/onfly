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





### Pontos de melhoria

1. Separar todas as exceptions de forma mais clara e organizada.
2. Atualmente, as notificações estão síncronas, mas poderiam ser assíncronas — o que seria o ideal.
3. O cadastro de usuário não recebeu tanta atenção. Esse processo poderia estar em outro microserviço ou até utilizar uma solução mais apropriada, como o **Keycloak**.
4. Nos testes unitários, priorizei os casos que considerei mais importantes:
    - Registrar um pedido de viagem;
    - Aprovar um pedido de viagem;
    - Cancelar um pedido de viagem.
        
        (Ainda assim, existem várias outras situações que poderiam ser cobertas).
        
5. Para documentação da API, seria possível usar o **Swagger**, mas considerei desnecessário para os objetivos propostos.

---

### Dúvidas

1. Quem exatamente seria o **usuário solicitante**? Usuário e solicitante representam a mesma entidade ou são papéis diferentes?
2. Seguindo a regra de que o usuário só pode acessar seus próprios cadastros, como ele poderia aprovar ou reprovar viagens de outros usuários?
