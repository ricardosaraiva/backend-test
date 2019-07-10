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
    private $user;

    public function __construct($container) {
        $this->itemsPerPage = $container->get('config')['app']['itemsPerPageDefault'];
        if( $container->has('user') ) {
            $this->user = $container->get('user');
        }

        $this->eventModel = new EventModel($container->get(EntityManager::class), $this->user); 
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
        $params = $req->getQueryParams();

        $events = $this->eventModel->list($page, $this->itemsPerPage, $params);
        return $res->withJson($events);        
    }

    public function detailAction($req, $res, $args) {
        return $res->withJson($this->eventModel->detail($args['id']));
    }

    public function cancelAction($req, $res, $args) {
        return $res->withJson($this->eventModel->cancel($args['id']));
    }

    public function invitationFriendAction($req, $res, $args) {
        $body = $req->getParsedBody();

        try {
            $this->eventModel->invitationFriend($args['id'], $body['idUser']);
        } catch(ModelResponseException $e) {
            return $res->withJson($e->getMessage(), 400);
        }
    }

    public function myEventsAction($req, $res, $args) {
        $status = isset($args['status']) ? $args['status'] : 'accept';
        return $res->withJson($this->eventModel->invitationList($status));
    }

    public function invitationAcceptAction($req, $res, $args) {
        try {
            $this->eventModel->invitationStatus($args['id'], true);
        } catch(ModelResponseException $e) {
            return $res->withJson($e->getMessage(), 400);
        }
    }

    public function invitationRejectAction($req, $res, $args) {
        try {
            $this->eventModel->invitationStatus($args['id'], false);
        } catch(ModelResponseException $e) {
            return $res->withJson($e->getMessage(), 400);
        }
    }
}