<?php

namespace Test\Model;
use Model\UserModel;
use Entity\UserEntity;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

class UserModelTest extends TestCase
{
    private $userModel;

    public function setUp() {
        parent::setUp();
        $this->userModel = new UserModel($this->createMock(EntityManager::class));
    }

    public function testCrateUser() {
    
        $this->userModel->setName('User Name');
        $this->userModel->setEmail('teste@teste.com');
        $this->userModel->setPassword('123456');
        $this->userModel->setCity('City Name');
        $this->userModel->setState('State Name');
        $this->assertTrue($this->userModel->isValid());

        $this->assertInstanceOf(UserEntity::class, $this->userModel->create(''));
    }
}