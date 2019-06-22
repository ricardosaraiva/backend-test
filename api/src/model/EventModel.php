<?php

namespace Model;

use Model\Model;
use Entity\EventEntity;

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
        'date' => 'date',
        'time' => 'time',
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

    
    public function create() {
        $validate = $this->isValid();
        if(!$validate) {
            throw new \InvalidArgumentException($valide->getError()['message']);
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

        return $eventEntity;
    }

    public function update($id) {

    }

    public function list( $page, $itemsPerPage ) { 
        $qb = $this->em
        ->getRepository(EventEntity::class)
        ->createQueryBuilder('event');

        $data = $qb
            ->getQuery()
            ->getResult();
 
        $pages = $qb
            ->select('COUNT(event.id) AS total')
            ->getQuery()
            ->getSingleScalarResult();


        return [ 'pages' => ceil($pages / $itemsPerPage), 'data' => $data];
        
    }

}