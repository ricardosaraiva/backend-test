<?php 

namespace Controller;

use Model\UserModel;
use Doctrine\ORM\EntityManager;
use Model\ModelResponseException;

class UserController {

    private $userModel;

    public function __construct($container) {
        $this->userModel = new UserModel($container->get(EntityManager::class), $container->get('user'));
    }

    public function invitationAction($req, $res) {
        $body = $req->getParsedBody();

        try {
            $this->userModel->invitation($body['email']);
        } catch( ModelResponseException $e ) {
            return $res->withJson($e->getMessage(), 400);
        }
    }

    public function invitationListAction($req, $res) {
        return $res->withJson($this->userModel->invitationList());
    }

    public function invitationAccpetAction($req, $res, $args) {
        try {
            $this->userModel->invitationStatus($args['id'], true);
        } catch( ModelResponseException $e ) {
            return $res->withJson($e->getMessage(), 400);
        }
    }

    public function invitationRejectAction($req, $res, $args) {
        try {
            $this->userModel->invitationStatus($args['id'], false);
        } catch( ModelResponseException $e ) {
            return $res->withJson($e->getMessage(), 400);
        }
    }

    public function undoFriendshipAction($req, $res, $args) {
        try {
            $this->userModel->undoFriendship($args['id']);
        } catch( ModelResponseException $e ) {
            return $res->withJson($e->getMessage(), 400);
        }
    }

    public function friendsListAction($req, $res) {
        return $res->withJson($this->userModel->friendsList());
    }
}