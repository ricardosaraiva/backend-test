# Instalação
Executar composer install

Dar permissão de escrita no diretorio public/pictures.

**Em caso de erro ao criar a pasta data ou banco de dados pode ser executado o procedimento abaixo.**

- criar o diretorio pictures dentro da pasta public com permissão para escrita.
- criar o diretorio data com permissão para escrita.
- rodar o comando **php vendor/bin/doctrine orm:schema-tool:update --force.**

O projeto necessita da extensão do php para sqlite habilitada!

# Rodar o projeto
php -S localhost:8082 -t public/ index.php

# Biblioteca de terceiros
- Foi usando o banco de dados sqlite para facilitar a instalação e configuração do projeto.
- Foi usado o micro framework slim para gerenciar as rotas e dependencias da aplicação através de seu dependency container.
- Foi usado o doctrine para gerenciar as entidade do banco de dados assim como para criar e atualizar o banco de dados.
- Foi usado o respec/validation para validar os dados dos modelos.
- Foi usado tuupola/slim-jwt-auth e firebase/php-jwt para fazer autenticação usando jwt.

# Documentação da api

$app->post('/register', LoginController::class . ':registerAction');
$app->post('/login', LoginController::class . ':loginAction');
$app->get('/event[/{page}]', EventController::class . ':listAction');
$app->get('/event/{id}/detail', EventController::class . ':detailAction');

## Área publica
* [Registro de usuário](doc/login/register.md) : `GET /register/`
* [Login no sistema](doc/login/login.md) : `POST /login/`
* [Lista de eventos](doc/pk/get.md) : `GET /event/:page/`
* [Detalhe do evento](doc/pk/put.md) : `GET /event/:id/detail`

