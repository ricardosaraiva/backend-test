<?php

namespace Controller;

class EventController {
    public function listAction($req, $res) {
        return $res->withJson('Index conteudo');
    }
}