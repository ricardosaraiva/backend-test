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

        $dateTime = new \DateTime();
        $dateTime->modify('+1 day');

        $this->eventModel->setDate($dateTime->format('Y-m-d'));
        $this->eventModel->setTime($dateTime->format('H:i:s'));
        $this->eventModel->setCity('Event city');
        $this->eventModel->setState('Event State');
        $this->eventModel->setAddress('Event address, 00');
        
        $this->assertInstanceOf(EventEntity::class, $this->eventModel->create());
    }

    public function testCreateEventInvalid() {
        $this->eventModel->setName('xx');
        $this->eventModel->setDescription('invalid');
        $this->eventModel->setDate('2019-02-30');
        $this->eventModel->setTime('60:00:00');
        $this->eventModel->setCity('x');
        $this->eventModel->setState('x');
        $this->eventModel->setAddress('x');
        $this->assertFalse($this->eventModel->isValid());
        $this->assertCount(7, $this->eventModel->getAllMessageErrorValidation());
    }

    public function testCreateEventDateLessThanCurrentDate() {
        $this->eventModel->setName('Event Name');
        $this->eventModel->setDescription(
            'Incididunt sint eiusmod consequat anim nisi quis officia laborum commodo culpa proident. 
            Tempor dolore sunt ex elit irure esse reprehenderit non. 
            Velit pariatur laborum id nisi adipisicing voluptate cupidatat reprehenderit duis culpa id 
            reprehenderit velit. Esse et pariatur mollit commodo in amet ad. Est aute Lorem anim Lorem. 
            Tempor pariatur enim do officia consectetur pariatur in magna velit nulla dolor exercitation 
            officia.'
        );

        $dateTime = new \DateTime();
        $dateTime->modify('-1 day');

        $this->eventModel->setDate($dateTime->format('Y-m-d'));
        $this->eventModel->setTime($dateTime->format('H:i:s'));
        $this->eventModel->setCity('Event city');
        $this->eventModel->setState('Event State');
        $this->eventModel->setAddress('Event address, 00');
        
        $this->assertFalse($this->eventModel->isValid());
        $this->assertEquals('not allowed to create an event with a date less than the current date', $this->eventModel->getMessageErrorValidation()['message']);
    }

}