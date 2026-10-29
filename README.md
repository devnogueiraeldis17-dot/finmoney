# FinMoney — Laravel 13

Sistema financeiro com autenticação, perfis `comum` e `admin`, lançamentos mensais, despesas parceladas e dashboard.

## Requisitos
- PHP compatível com Laravel 13
- Composer
- PostgreSQL
- Extensões PHP necessárias para Laravel e PostgreSQL

## Instalação
1. Crie um projeto Laravel 13 ou use um projeto Laravel 13 existente.
2. Extraia este pacote sobre a raiz do projeto, preservando os arquivos `artisan`, `composer.json` e demais arquivos padrão do Laravel.
3. Configure `.env`:
   ```dotenv
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=finmoney
   DB_USERNAME=postgres
   DB_PASSWORD=sua_senha
   ```
4. Execute:
   ```bash
   php artisan key:generate
   php artisan migrate --seed
   php artisan finmoney:create-admin
   php artisan serve
   ```
5. Acesse `http://127.0.0.1:8000/login`.

O comando `finmoney:create-admin` solicita os dados no terminal e cria o primeiro administrador. Não há cadastro público.

## Importante
- O pacote contém os arquivos da aplicação, não uma cópia do framework/vendor.
- Revise os arquivos de configuração e compare com os arquivos existentes antes de substituir.
- O serviço de parcelamento interpreta `value` como o valor total da compra.
- Ao editar ou excluir uma despesa parcelada, a operação afeta o grupo inteiro; a edição preserva a quantidade e a distribuição de centavos.
- Lançamentos são mensais e únicos por usuário, nome, mês e ano.
