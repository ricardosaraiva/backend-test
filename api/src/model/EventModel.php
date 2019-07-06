<?php

namespace Model;

use Model\Model;
use Entity\UserEntity;
use Entity\EventEntity;
use Respect\Validation\Validator;
use Entity\EventOrganizationEntity;

class EventModel extends Model {

    protected $user;
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

    /**
     * Set the value of user
     *
     * @return  self
     */ 
    public function setUser( UserEntity $user)
    {
        $this->user = $user;

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

        $eventOrganizationEntity = $this->em
            ->getRepository(EventOrganizationEntity::class)
            ->findOneBy([
                'idEvent' => $eventEntity->getId(),
                'idUser' => $this->user->getId()
            ]);

        if(empty($eventOrganizationEntity)) {
            throw new ModelResponseException('without permission to edit event');
        }


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

}