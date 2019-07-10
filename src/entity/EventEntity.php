<?php 
namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="event")
 */
class EventEntity implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $name = '';

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $description = '';

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $date = '';

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $city = '';

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $state = '';

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $address = '';

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $cancel = false;
    

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

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
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
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
     * Get the value of date
     */ 
    public function getDate()
    {
        return $this->date;
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
     * Get the value of city
     */ 
    public function getCity()
    {
        return $this->city;
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
     * Get the value of state
     */ 
    public function getState()
    {
        return $this->state;
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
     * Get the value of address
     */ 
    public function getAddress()
    {
        return $this->address;
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
     * Get the value of cancel
     */ 
    public function getCancel()
    {
        return $this->cancel;
    }

    /**
     * Set the value of cancel
     *
     * @return  self
     */ 
    public function setCancel($cancel)
    {
        $this->cancel = $cancel;

        return $this;
    }

    public function jsonSerialize() {
        $json = new \StdClass;
        $json->id = $this->getId();
        $json->name = $this->getName();
        $json->description = $this->getDescription();
        $json->date  = $this->getDate()->format('Y-m-d H:i:s');
        $json->city = $this->getCity();
        $json->state = $this->getState();
        $json->address = $this->getAddress();
        $json->cancel = $this->getCancel();
        return $json;
    }
}