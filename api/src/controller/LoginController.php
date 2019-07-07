<?php

namespace Controller;

use Model\UserModel;
use Doctrine\ORM\EntityManager;
use Model\ModelResponseException;


class LoginController {
    
    /**
     * @var UserModel
     */
    private $userModel;
    private $itemsPerPage;
    private $dirPicuture;
    private $jwtKey;

    public function __construct($container) {
        $this->userModel = new UserModel($container->get(EntityManager::class), $this->user); 
        $this->itemsPerPage = $container->get('config')['app']['itemsPerPageDefault'];
        $this->dirPicuture = $container->get('dirPicuture');
        $this->jwtKey = $container->get('jwtKey');
    }


    public function registerAction($req, $res) {
        $body = $req->getParsedBody();

        $upload = $req->getUploadedFiles();
        
        $this->userModel->setName($body['name']);
        $this->userModel->setEmail($body['email']);
        $this->userModel->setPassword($body['password']);
        $this->userModel->setBio($body['bio']);
        $this->userModel->setPicture($upload['picture']);
        $this->userModel->setCity($body['city']);
        $this->userModel->setState($body['state']);
        
        if(!$this->userModel->isValid()) {
            return $res->withJson($this->userModel->getMessageErrorValidation(), 400);
        }

        try {
            return $res->withJson($this->userModel->create($this->dirPicuture));
        } catch(ModelResponseException $e) {
            return $res->withJson($e->getMessage(), 400);
        }           
    }

    public function loginAction($req, $res) {
        $body = $req->getParsedBody();
        $user = $this->userModel->login($body['email'], $body['password'], $this->jwtKey);
        
        if($user) {
            return $res->withJson($user);
        }

        return $res->withJson('email or password is invalid', 400);
    }
}