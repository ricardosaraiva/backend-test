<?php 
namespace Test\Model;

use Model\EventModel;
use Entity\EventEntity;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

class EventModelTest extends TestCase {
    private $eventModel;

    public function setUp() {
        parent::setUp();
        $this->eventModel = new EventModel($this->createMock(EntityManager::class));
    }

    public function testCreateEvent() {
        $this->eventModel->setName('Event Name');
        $this->eventModel->setDescription(
            'Incididunt sint eiusmod consequat anim nisi quis officia laborum commodo culpa proident. 
            Tempor dolore sunt ex elit irure esse reprehenderit non. 
            Velit pariatur laborum id nisi adipisicing voluptate cupidatat reprehenderit duis culpa id 
            reprehenderit velit. Esse et pariatur mollit commodo in amet ad. Est aute Lorem anim Lorem. 
            Tempor pariatur enim do officia consectetur pariatur in magna velit nulla dolor exercitation 
            officia.'
        );
        $this->eventModel->setDate('2019-06-20');
        $this->eventModel->setTime('10:00:00');
        $this->eventModel->setCity('Event city');
        $this->eventModel->setState('Event State');
        $this->eventModel->setAddress('Event address, 00');
        
        $this->assertInstanceOf(EventEntity::class, $this->eventModel->create());
    }
}