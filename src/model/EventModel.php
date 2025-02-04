<?php

namespace Model;

use Model\Model;
use Entity\UserEntity;
use Entity\EventEntity;
use Entity\EventUserEntity;
use Respect\Validation\Validator;
use Entity\EventOrganizationEntity;

class EventModel extends Model {

    protected $name;
    protected $description;
    protected $date;
    protected $time;
    protected $city;
    protected $state;
    protected $address;

    protected $error;

    protected $rules = [
        'name' => ['length', 3, 10],
        'description' => ['length',30],
        'date' => ['date', 'Y-m-d'],
        'time' => ['date', 'H:i:s'],
        'city' => ['length', 3, 100],
        'state' => ['length', 2],
        'address' => ['length', 3, 200]
    ];


    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */ 
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Set the value of time
     *
     * @return  self
     */ 
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Set the value of city
     *
     * @return  self
     */ 
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Set the value of state
     *
     * @return  self
     */ 
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Set the value of address
     *
     * @return  self
     */ 
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }
    

    public function isValid() {
        if (!parent::isValid()) {
            return false;
        }    

        $dateTime = new \DateTime();
        $dateEvent = new \DateTime(sprintf('%s %s', $this->date, $this->time));
        if($dateTime->format('Y-m-d H:i:s') >= $dateEvent->format('Y-m-d H:i:s')) {
            $this->messageError[] = [
                'field' => 'date',
                'message' => 'not allowed to create an event with a date less than the current date'
            ];
            return false;
        }

        return true;
    }
    
    public function create() {
        
        if(!$this->isValid()) {
            throw new \InvalidArgumentException($this->getMessageErrorValidation()['message']);
        }

        $eventEntity = new EventEntity();
        $eventEntity->setName($this->name);
        $eventEntity->setDescription($this->description);
        $eventEntity->setDate(new \DateTime(sprintf('%s %s', $this->date, $this->time)));
        $eventEntity->setCity($this->city);
        $eventEntity->setState($this->state);
        $eventEntity->setAddress($this->address);

        $this->em->persist($eventEntity);
        $this->em->flush();

        $eventOrganizationEntity = new EventOrganizationEntity();
        $eventOrganizationEntity->setIdEvent($eventEntity->getId());
        $eventOrganizationEntity->setIdUser($this->user->getId());
        $this->em->persist($eventOrganizationEntity);
        $this->em->flush();

        return $eventEntity;
    }

    public function validateUserIsOrganizationEvent($idUser, $idEvent) {
        $eventOrganizationEntity = $this->em
            ->getRepository(EventOrganizationEntity::class)
            ->findOneBy([
                'idEvent' => $idEvent,
                'idUser' => $idUser
            ]);

        if(empty($eventOrganizationEntity)) {
            throw new ModelResponseException('without permission to edit event');
        }
    }

    public function update($id) {

        if(!$this->isValid()) {
            throw new \InvalidArgumentException($this->getMessageErrorValidation()['message']);
        }

        $eventEntity = $this
            ->em
            ->getRepository(EventEntity::class)
            ->findOneBy([
                'id' => $id
            ]);

        if(empty($eventEntity)) {
            throw new ModelResponseException('invalid event');
        }
        
        if( $eventEntity->getCancel() ) {
            throw new ModelResponseException('not allowed to edit canceled events');
        }

        $dateTime = new \DateTime();
        if($eventEntity->getDate()->format('Y-m-d H:i:s')  < $dateTime->format('Y-m-d H:i:s')) {
            throw new ModelResponseException('not allowed to edit event that has already happened');
        }

        $this->validateUserIsOrganizationEvent($this->user->getId(), $eventEntity->getId());

        $eventEntity->setName($this->name);
        $eventEntity->setDescription($this->description);
        $eventEntity->setDate(new \DateTime(sprintf('%s %s', $this->date, $this->time)));
        $eventEntity->setCity($this->city);
        $eventEntity->setState($this->state);
        $eventEntity->setAddress($this->address);

        $this->em->persist($eventEntity);
        $this->em->flush();

        return $eventEntity;
    }

    public function list( $page, $itemsPerPage, $filter = [] ) { 

        $qb = $this->em
        ->getRepository(EventEntity::class)
        ->createQueryBuilder('event');

        if(!empty($filter['dateStart'])) {

            if(!Validator::date()->validate($filter['dateStart'])) {
                throw new ModelResponseException("Invalida date start");
                
            }

            $qb
                ->andWhere('event.date >= :dateStart ')
                ->setParameter('dateStart', $filter['dateStart'] . ' 00:00:00');
        }

        if(!empty($filter['dateEnd'])) {

            if(!Validator::date()->validate($filter['dateEnd'])) {
                throw new ModelResponseException("Invalida date end");
                
            }

            $qb
                ->andWhere('event.date <= :dateEnd ')
                ->setParameter('dateEnd', $filter['dateEnd'] . ' 23:59:59');
        }

        if(!empty($filter['place'])) {
            $qb
                ->andWhere('(event.city LIKE :place  OR event.state LIKE :place  OR event.address LIKE :place )')
                ->setParameter('place', '%' . $filter['place'] . '%');
        }

        $data = $qb
            ->orderBy('event.id', 'DESC')
            ->getQuery()
            ->setFirstResult($this->offset($page, $itemsPerPage))
            ->setMaxResults($itemsPerPage)
            ->getResult();
 
        $total = $qb
            ->select('COUNT(event.id) AS total')
            ->getQuery()
            ->getSingleScalarResult();

        return [ 
            'items' => $total , 
            'itemsPerPage' => $itemsPerPage, 
            'data' => $data
        ];

    }

    public function detail($id) {
        return $this->em->getRepository(EventEntity::class)->find($id);
    }

    public function cancel($id) {

        $this->validateUserIsOrganizationEvent($this->user->getId(), $id);
        
        $eventEntity = $this->em
            ->getRepository(EventEntity::class)
            ->find($id);

        $eventEntity->setCancel(true);
        $this->em->persist($eventEntity);
        $this->em->flush();


        return $eventEntity;
    }


    public function invitationFriend($idEvent, $idUser) {
        if($idUser == $this->user->getId()) {
            throw new ModelResponseException('It is not possible to invite yourself'); 
        }

        $userModel = new UserModel($this->em, $this->user);
        
        if(!$userModel->isFriend($idUser)) {
            throw new ModelResponseException('This user not is friend'); 
        }

        $eventInvitionalValidate = $this->em
            ->getRepository(EventUserEntity::class)
            ->findOneBy([
                'idUser' => $idUser,
                'idEvent' => $idEvent
            ]);

        if(!empty($eventInvitionalValidate)) {
            throw new ModelResponseException("Already exists invitation to this user");
        }

        $eventEntity = $this->em
            ->getRepository(EventEntity::class)
            ->find($idEvent);

        if($eventEntity->getCancel()) {
            throw new ModelResponseException("Event is cancelled");
        }

        $dateTime = new \DateTime();
        if($eventEntity->getDate()->format('Y-m-d H:i:s')  < $dateTime->format('Y-m-d H:i:s')) {
            throw new ModelResponseException('not allowed invitional user to event that 
                has already happened');
        }

        $eventInvitionalEntity = new EventUserEntity();
        $eventInvitionalEntity->setIdEvent($idEvent);
        $eventInvitionalEntity->setIdUser($idUser);
        $this->em->persist($eventInvitionalEntity);
        $this->em->flush();
    }

    public function invitationList($status = 'open') {
            
        $statusFilter = [
            'open' => 'is null',
            'accept' => '= true', 
            'reject' => '= false'
        ];

        if(!isset($statusFilter[$status])) {
            throw new \Exception("Invalid status");
        }


        $date = new \DateTime(); 

        return $this->em
            ->getRepository(EventEntity::class)
            ->createQueryBuilder('event')
            ->innerJoin(
                EventUserEntity::class,
                'eventUser',
                'WITH',
                'event.id = eventUser.idEvent'
            )
            ->andWhere('eventUser.status ' . $statusFilter[$status])
            ->andWhere('eventUser.idUser = :idUser')
            ->andWhere('event.date >= :date')
            ->andWhere('event.cancel = false')
            ->setParameter('idUser', $this->user->getId())
            ->setParameter('date', $date->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult();
    }

    public function invitationStatus($idEvent, $status) {
        $date = new \DateTime(); 

        $event  = $this->em
            ->getRepository(EventUserEntity::class)
            ->createQueryBuilder('eventUser')
            ->innerJoin(
                EventEntity::class,
                'event',
                'WITH',
                'event.id = eventUser.idEvent'
            )
            ->andWhere('eventUser.idUser = :idUser')
            ->andWhere('event.id = :idEvent')
            ->andWhere('event.date >= :date')
            ->andWhere('event.cancel = false')
            ->setParameter('idUser', $this->user->getId())
            ->setParameter('idEvent', $idEvent)
            ->setParameter('date', $date->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult();

            if( empty($event[0]) ) {
                throw new \Exception("Invalid event");
            }

            $event[0]->setStatus((bool) $status);
            $this->em->persist($event[0]);
            $this->em->flush();

            
    }

    

}