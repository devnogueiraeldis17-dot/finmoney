# FinMoney 💰

Sistema de gerenciamento financeiro desenvolvido com **Laravel**, com o objetivo de facilitar o controle de despesas, lançamentos mensais e acompanhamento dos gastos.

O FinMoney permite organizar despesas, controlar compras parceladas e visualizar informações financeiras por meio de um dashboard.

## 🚀 Funcionalidades

### 🔐 Autenticação e usuários
- Login e logout.
- Controle de acesso por nível de usuário.
- Dois tipos de perfil:
  - **Comum:** pode cadastrar e consultar suas despesas e lançamentos.
  - **Administrador:** possui controle administrativo, podendo gerenciar usuários e editar ou excluir despesas.

### 💳 Gerenciamento de despesas
- Cadastro de despesas.
- Nome e descrição da despesa.
- Definição de categoria.
- Registro de valor.
- Definição da quantidade de parcelas.
- Data de vencimento.
- Distribuição automática dos valores entre as parcelas.
- Criação automática dos lançamentos dos meses seguintes.
- Edição e exclusão de despesas parceladas pelo administrador.

### 📅 Lançamentos mensais
- Organização dos lançamentos por nome, mês e ano.
- Criação automática de lançamentos para os meses das parcelas.
- Associação das despesas aos respectivos lançamentos.
- Separação dos lançamentos por usuário.

### 📊 Dashboard
- Área destinada à análise dos gastos.
- Visualização de informações financeiras para auxiliar no acompanhamento das despesas.

### 👥 Administração de usuários
- Listagem de usuários.
- Cadastro de novos usuários.
- Controle de permissões por perfil.

## 🛠️ Tecnologias utilizadas

- PHP
- Laravel
- Composer
- Banco de dados relacional
- Eloquent ORM
- PHPUnit / Pest (conforme configuração do ambiente de testes)
- HTML, CSS e JavaScript

## ⚙️ Requisitos

Antes de instalar o projeto, certifique-se de possuir:

- PHP compatível com a versão do Laravel utilizada.
- Composer.
- Banco de dados configurado.
- Laravel.
- Git (opcional).

## 📥 Instalação

### 1. Clonar o repositório

```bash
git clone URL_DO_REPOSITORIO
```

### 2. Entrar na pasta do projeto

```bash
cd finmoney
```

### 3. Instalar as dependências

```bash
composer install
```

### 4. Configurar o ambiente

Copie o arquivo `.env.example` para `.env`:

```bash
cp .env.example .env
```

No Windows PowerShell, também é possível utilizar:

```powershell
Copy-Item .env.example .env
```

### 5. Gerar a chave da aplicação

```bash
php artisan key:generate
```

### 6. Configurar o banco de dados

Abra o arquivo `.env` e configure as informações de conexão:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=finmoney
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

Ajuste os valores conforme o banco de dados utilizado no seu ambiente.

### 7. Executar as migrations

```bash
php artisan migrate
```

### 8. Iniciar o servidor

```bash
php artisan serve
```

A aplicação ficará disponível em:

```text
http://127.0.0.1:8000
```

## 🧪 Testes automatizados

O projeto possui testes automatizados para verificar funcionalidades e regras de negócio.

Para executar todos os testes:

```bash
php artisan test
```

### Cobertura atual dos testes

O projeto possui **26 testes aprovados e 93 asserções**, contemplando:

- Autenticação.
- Autorização e controle de acesso.
- Cadastro e validação de despesas.
- Criação de lançamentos.
- Controle de despesas entre usuários.
- Edição e exclusão de grupos de parcelas.
- Distribuição correta dos centavos.
- Tratamento de anos bissextos.
- Parcelamentos que atravessam a virada do ano.

*Resultado registrado durante o desenvolvimento em 01/11/2026.*

## 📁 Organização do projeto

O FinMoney utiliza a estrutura MVC do Laravel:

```text
finmoney/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   └── Requests/
│   │
│   ├── Models/
│   ├── Policies/
│   └── Services/
│
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
│
├── resources/
│   └── views/
│
├── routes/
│   └── web.php
│
├── tests/
│   ├── Feature/
│   └── Unit/
│
├── .env.example
└── README.md
```

## 🔒 Segurança

O sistema utiliza recursos do Laravel para:

- Autenticação de usuários.
- Controle de permissões.
- Validação de dados.
- Proteção de rotas administrativas.
- Restrição de acesso aos dados pertencentes a outros usuários.
- Transações de banco de dados para operações de parcelamento.

## 🎯 Objetivo do projeto

O FinMoney foi desenvolvido com o propósito de oferecer uma solução prática para organização financeira, permitindo o controle de despesas e parcelamentos de maneira estruturada.

O projeto também representa uma oportunidade de aplicar conhecimentos de desenvolvimento web, arquitetura MVC, orientação a objetos, banco de dados, regras de negócio e testes automatizados.

## 👨‍💻 Desenvolvimento

**Projeto:** FinMoney  
**Categoria:** Sistema de gerenciamento financeiro  
**Tecnologia principal:** PHP / Laravel

---

Desenvolvido como projeto de estudo e aprimoramento em desenvolvimento web.
