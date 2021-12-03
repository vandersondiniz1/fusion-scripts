
<p align="center">
  <img src="docs/img/logo.jpg" />
</p>

----------
# Dev branch 1.0
Projeto para criação de branches padronizadas

----------

>## Sumário

* [Informações Gerais](#informações-gerais)
* [Requisitos](#requisitos)
* [Configuração](#configuração)
* [Execução](#execução)
* [Estrutura de Diretórios](#estrutura-de-diretórios)
* [Variáveis de Ambiente](#variáveis-de-ambiente)

>## Informações Gerais
>Esse projeto foi desenvolvido para auxiliar os desenvolvedores da FusionDMS, na criação de branches git localmente. 

>## Requisitos
>Php   - versão 7.4

>## Configuração
>Php   - versão 7.4

>## Execução
>php /src/core/app.php parâmetro número-da-eng nome-da-branch
> - Exemplo:php /src/core/app.php bug 666 master

>## Estrutura de Diretórios
>- `app` - Contains all the Eloquent models
>- `app/Http/Controllers/Api` - Contains all the api controllers
>- `app/Http/Middleware` - Contains the JWT auth middleware
>- `app/Http/Requests/Api` - Contains all the api form requests
>- `app/RealWorld/Favorite` - Contains the files implementing the favorite feature
>- `app/RealWorld/Filters` - Contains the query filters used for filtering api requests
>- `app/RealWorld/Follow` - Contains the files implementing the follow feature
>- `app/RealWorld/Paginate` - Contains the pagination class used to paginate the result
>- `app/RealWorld/Slug` - Contains the files implementing slugs to articles
>- `app/RealWorld/Transformers` - Contains all the data transformers
>- `config` - Contains all the application configuration files
>- `database/factories` - Contains the model factory for all the models
>- `database/migrations` - Contains all the database migrations
>- `database/seeds` - Contains the database seeder
>- `routes` - Contains all the api routes defined in api.php file
>- `tests` - Contains all the application tests
>- `tests/Feature/Api` - Contains all the api tests

>## Variáveis de Ambiente
>- `.env` - Variáveis de ambiente devem ser incluídas aqui

