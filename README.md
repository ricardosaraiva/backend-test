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

## Área publica
* [Registro de usuário](doc/login/register.md) : `GET /register`
* [Login no sistema](doc/login/login.md) : `POST /login`
* [Lista de eventos](doc/event/event_get.md) : `GET /event/:page`
* [Informações do evento](doc/event/event_detail.md) : `GET /event/:id/detail`

## Área restrita
**Usurario**
* [Lista de solicitaçoes de amizade](doc/user/user_invitation_get.md) : `GET /user/invitation`
* [Envia uma solicitação de amizade](doc/user/user_invitation_post.md) : `POST /user/invitation`
* [Aceita uma solicitação de amizade](doc/user/user_invitation_put.md) : `PUT /user/:id/invitation`
* [Rejeita uma solicitação de amizade](doc/user/user_invitation_delete.md) : `DELETE /user/:id/invitation`
* [Remove um amigo](doc/user/friends_undo.md) : `DELETE user/:id/undo_friendship`
* [Lista os amigos](doc/user/friends.md) : `GET user/friends`

**Evento**
* [Adiciona um evento](doc/event/event_post.md) : `POST /event`
* [Editar um evento](doc/event/event_put.md) : `PUT /event/:id`
* [Cancela um evento](doc/event/event_delete.md) : `DELETE /event/:id`
* [Convida um amigo](doc/event/event_invitation_post.md) : `POST /event/:id/invitation`
* [Lista os evento do usuario](doc/event/event_user.md) : `GET /event/user`
* [Lista os convites de eventos: (abertos, aceitos e cancelados)](doc/event/event_invitation_get.md) : `GET /event/invitation/:status`
* [Aceita o convite para um evento](doc/event/event_invitation_put.md) : `PUT /event/:id/invitation`
* [Rejeita o convite para um evento](doc/event/event_invitation_delete.md) : `DELETE /event/:id/invitation`

