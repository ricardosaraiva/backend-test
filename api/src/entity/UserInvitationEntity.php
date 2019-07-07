<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_invitation")
 */
class UserInvitationEntity {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;
    
    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $idUser;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $emailFriend;

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
     * Get the value of idUser
     */ 
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set the value of idUser
     *
     * @return  self
     */ 
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get the value of emailFriend
     */ 
    public function getEmailFriend()
    {
        return $this->emailFriend;
    }

    /**
     * Set the value of emailFriend
     *
     * @return  self
     */ 
    public function setEmailFriend($emailFriend)
    {
        $this->emailFriend = $emailFriend;
        return $this;
    }
}