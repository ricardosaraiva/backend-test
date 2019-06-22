<?php

namespace Controller;

use Model\EventModel;
use Model\ModelResponseException;
use Doctrine\ORM\EntityManager;

class EventController 
{
    /**
     * @var EventModel
     */
    private $eventModel;
    private $itemsPerPage;

    public function __construct($container) {
        $this->eventModel = new EventModel($container->get(EntityManager::class)); 
        $this->itemsPerPage = $container->get('config')['app']['itemsPerPageDefault'];
    }

    public function addAction ($req, $res) {
        $body = $req->getParsedBody();
        
        $this->eventModel->setName($body['name']);
        $this->eventModel->setDescription($body['description']);
        $this->eventModel->setDate($body['date']);
        $this->eventModel->setTime($body['time']);
        $this->eventModel->setCity($body['city']);
        $this->eventModel->setState($body['state']);
        $this->eventModel->setAddress($body['address']);

        if(!$this->eventModel->isValid()) {
            return $res->withJson($this->eventModel->getMessageErrorValidation(), 400);
        }
    
        return $res->withJson($this->eventModel->create());
    }

    public function updateAction ($req, $res, $args) {
        $body = $req->getParsedBody();
        
        $this->eventModel->setName($body['name']);
        $this->eventModel->setDescription($body['description']);
        $this->eventModel->setDate($body['date']);
        $this->eventModel->setTime($body['time']);
        $this->eventModel->setCity($body['city']);
        $this->eventModel->setState($body['state']);
        $this->eventModel->setAddress($body['address']);

        if(!$this->eventModel->isValid()) {
            return $res->withJson($this->eventModel->getMessageErrorValidation(), 400);
        }
    
        try {
            return $res->withJson($this->eventModel->update($args['id']));
        } catch(ModelResponseException $e) {
            return $res->withJson($e->getMessage(), 400);
        }
    }

    public function listAction($req, $res, $args) {
        $page = empty($args['page']) ? 1 : $args['page'];
        $events = $this->eventModel->list($page, $this->itemsPerPage);
        return $res->withJson($events);        
    }
}