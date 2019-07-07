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
            
            return $res->withJson('invitation sent successfully');
        } catch( ModelResponseException $e ) {
            return $res->withJson($e->getMessage(), 400);
        }
    }

    public function invitationListAction($req, $res) {
        return $res->withJson($this->userModel->invitationList());
    }
}