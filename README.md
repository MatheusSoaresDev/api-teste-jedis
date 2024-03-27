# API TEST JEDIS

## Descrição
Esta é minha aplicação teste para a vaga de dev php na jedis. Trata-se de uma aplicação laravel 10 para 
gestão de produtos com autenticação de usuários. A autenticação de usuários é feita com o laravel passport no formato
grant type password. O usuário deve fornecer um email e senha para obter um token de acesso. Este token de acesso deverá
ser utilizado para acessar as rotas protegidas da aplicação. As rotas possuem escopos para definir se o usuário da aplica
ção possui acesso à funcionalidade. A aplicação possui as seguintes rotas:

## Pré-requisitos

Certifique-se de ter os seguintes itens instalados:

- Docker

## Como Iniciar

1. **Clone o Repositório:**
    ```bash
    git clone https://github.com/MatheusSoaresDev/api-teste-jedis.git
    ```

2. **Navegue até o Diretório do Projeto:**
    ```bash
    cd api-teste-jedis
    ```

3. **Criar o arquivo .env**
    ```bash
   cp .env.example .env
    ```

4. **Execute e entre no Contêiner Docker:**
    ```bash
    docker compose up -d
   docker exec -it api-produtos bash
    ```

5. **Rode as configurações do laravel**
    ```bash
    php artisan key:generate
    php artisan migrate
    php artisan db:seed DatabaseSeeder
    php artisan passport:client --password
    ```
6. **Após gerar a chave. Copie o client id e o cliente secret e cole no .env**
    ```bash
    PASSPORT_PASSWORD_CLIENT_ID={client_id}
    PASSPORT_PASSWORD_CLIENT_SECRET={client_secret}
    ```
6. **Execute os testes**
    ```bash
    php artisan test
    ```

## Rotas da API

### Login: `/api/login`
- **Descrição:** Rota para autenticar um usuário e obter um token e um refresh de acesso.
- **Escopo: [Aberto]**
- **Método:** <span style="background-color:green;color:white;padding:3px;border-radius:2px">POST</span>
- **Headers:**
    - Content-Type: application/json
    - accept: application/json
- **Corpo da Solicitação:**
    ```json
    {
        "username": "User Example",
        "password": "password"
    }

### Cadastrar Usuário: `/api/user`
- **Descrição:** Rota para cadastrar um novo usuário.
- **Escopo: [Aberto]**
- **Método:** <span style="background-color:green;color:white;padding:3px;border-radius:2px">POST</span>
- **Headers:**
    - Content-Type: application/json
    - accept: application/json
- **Corpo da Solicitação:**
    ```json
    {
        "name": "User Example",
        "email": "user@example.com",
        "password": "password"
    }

### Logout: `/api/logout`
- **Descrição:** Rota para deslogar um usuário (Revogar access token).
- **Escopo: [admin,user]**
- **Método:** <span style="background-color:red;color:white;padding:3px;border-radius:2px">DELETE</span>
- **Headers:**
    - Content-Type: application/json
    - accept: application/json
    - Authorization: Bearer [seu-token]

### Cadastrar Usuário: `/api/user/{id}`
- **Descrição:** Rota para tornar um usuário administrador do sistema.
- **Escopo: [admin]**
- **Método:** <span style="background-color:#be8227;color:white;padding:3px;border-radius:2px">PUT</span>
- **Headers:**
    - Content-Type: application/json
    - accept: application/json
    - Authorization: Bearer [seu-token]


### Cadastrar Produto: `/api/produto`
- **Descrição:** Rota para cadastrar um novo produto.
- **Escopo: [admin]**
- **Método:** <span style="background-color:green;color:white;padding:3px;border-radius:2px">POST</span>
- **Headers:**
    - Content-Type: application/json
    - accept: application/json
    - Authorization: Bearer [seu-token]
- **Corpo da Solicitação:**
    ```json
    {
        "nome" : "Exemplo produto",
        "descricao" : "Exemplo de descrição de produto",
        "preco" : 10.00
        "quantidade" : 100
    }

### Atualizar os dados de um produto: `/api/produto/{id}`
- **Descrição:** Rota para alterar os dados de um produto.
- **Escopo: [admin]**
- **Método:** <span style="background-color:#be8227;color:white;padding:3px;border-radius:2px">PUT</span>
- **Headers:**
    - Content-Type: application/json
    - accept: application/json
    - Authorization: Bearer [seu-token]
- **Corpo da Solicitação:**
    ```json
    {
        "nome" : "Exemplo produto",
        "descricao" : "Exemplo de descrição de produto",
        "preco" : 10.00
        "quantidade" : 100
    }

### Deletar um produto cadastrado: `/api/produto/{id}`
- **Descrição:** Rota para deletar um produto cadastrado.
- **Escopo: [admin]**
- **Método:** <span style="background-color:red;color:white;padding:3px;border-radius:2px">DELETE</span>
- **Headers:**
    - Content-Type: application/json
    - accept: application/json
    - Authorization: Bearer [seu-token]

### Listar todos os produtos: `/api/produto`
- **Descrição:** Rota para listar todos os produtos cadastrados.
- **Escopo: [admin,user]**
- **Método:** <span style="background-color:#9526b8;color:white;padding:3px;border-radius:2px">GET</span>
- **Headers:**
    - Content-Type: application/json
    - accept: application/json
    - Authorization: Bearer [seu-token]

### Realizar uma compra `/user/compra/{id}`
- **Descrição:** Rota para realizar a compra de um produto.
- **Escopo: [admin,user]**
- **Método:** <span style="background-color:green;color:white;padding:3px;border-radius:2px">POST</span>
- **Headers:**
    - Content-Type: application/json
    - accept: application/json
    - Authorization: Bearer [seu-token]

### Listar Compras: `/api/user/compra/`
- **Descrição:** Rota para listar todas as compras realizadas pelo usuário.
- **Escopo: [admin,user]**
- **Método:** <span style="background-color:#9526b8;color:white;padding:3px;border-radius:2px">GET</span>
- **Headers:**
    - Content-Type: application/json
    - accept: application/json
    - Authorization: Bearer [seu-token]

### Listar Compras: `/api/user/compra/{id}`
- **Descrição:** Rota para listar uma compra realizada pelo usuário.
- **Escopo: [admin,user]**
- **Método:** <span style="background-color:#9526b8;color:white;padding:3px;border-radius:2px">GET</span>
- **Headers:**
    - Content-Type: application/json
    - accept: application/json
    - Authorization: Bearer [seu-token]

