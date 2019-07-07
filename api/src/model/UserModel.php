<?php 

namespace Model;

use Firebase\JWT\JWT;
use Entity\UserEntity;
use Entity\UserLoginEntity;
use Entity\UserInvitationEntity;
use Respect\Validation\Validator;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class UserModel extends Model {
    protected $name;
    protected $email;
    protected $password;
    protected $bio;
    protected $picture;
    protected $city;
    protected $state;

    protected $error;

    protected $rules = [
        'name' => ['length', 3, 100],
        'email' => ['email'],
        'password' => ['length', 6, 100],
        'city' => ['length', 3, 100],
        'state' => ['length', 2],
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
     * Set the value of bio
     *
     * @return  self
     */ 
    public function setBio($bio)
    {
        $this->bio = $bio;

        return $this;
    }
    
    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set the value of picture
     *
     * @return  self
     */ 
    public function setPicture($picture)
    {
        $this->picture = $picture;

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
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function create($dirUpload) {
        
        if(!$this->isValid()) {
            throw new \InvalidArgumentException($this->getMessageErrorValidation()['message']);
        }
        
        $userEntity = new UserEntity();
        $userEntity->setName($this->name);
        $userEntity->setEmail($this->email);
        $userEntity->setPassword(password_hash($this->password, PASSWORD_DEFAULT));
        $userEntity->setBio($this->bio);

        if (!empty($this->picture) ) {

            if(
                !exif_imagetype($this->picture->file) || $this->picture->getError() !== UPLOAD_ERR_OK) {
                throw new ModelResponseException('invalid picture');
            }

            $ext = pathinfo($this->picture->getClientFilename(), PATHINFO_EXTENSION);
            $filename = md5(uniqid(time())) . $ext;
            $this->picture->moveTo($dirUpload . $filename);
            $userEntity->setPicture($filename);
        }

        $userEntity->setCity($this->city);
        $userEntity->setState($this->state);

        
        try {
            $this->em->persist($userEntity);
            $this->em->flush();        
            return $userEntity;
        } catch(UniqueConstraintViolationException $e) {
            throw new ModelResponseException('E-mail is registred');
        }
    
    }

    public function login($email, $password, $jwtKey) {
        $user = $this->em
            ->getRepository(UserEntity::class)
            ->findOneBy([
                'email' => $email
            ]);

        if(password_verify($password, $user->getPassword())) {

            $date = new \DateTime();

            $tokenData = [
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'date' => $date->format('Y-m-d H:i:s')
            ];

            $token = JWT::encode($tokenData, $jwtKey);

            $userLogin = new UserLoginEntity();
            $userLogin->setIdUser($user->getId());
            $userLogin->setToken($token);
            $this->em->persist($userLogin);
            $this->em->flush();

            return $token;
        }

        return false;
    }

    public function invitation($email) {

        if(!Validator::email()->validate($email)) {
            throw new ModelResponseException('Invalid email');            
        }

        if($email == $this->user->getEmail()) {
            throw new ModelResponseException('It is not possible to invite yourself');            
        }

        $userInvitationValidate = $this->em
            ->getRepository(UserInvitationEntity::class)
            ->findOneBy([
                'idUser' => $this->user->getId(),
                'emailFriend' => $email
            ]);

        if(!empty($userInvitationValidate)) {
            throw new ModelResponseException('already exists invitation to this user');
        }

        $userInvitationEntity = new UserInvitationEntity();
        $userInvitationEntity->setIdUser($this->user->getId());
        $userInvitationEntity->setEmailFriend($email);
        $this->em->persist($userInvitationEntity);
        $this->em->flush();

        $userEntity = $this->em
            ->getRepository(UserEntity::class)
            ->findOneBy(['email' => $email]);

        //validate if exists user in database
        if(empty($userEntity)) {
            //TODO: Implement sending registration email 
        }
    }

    public function invitationList() {
        return $this->em
            ->getRepository(UserEntity::class)
            ->createQueryBuilder('user')
            ->innerJoin(
                UserInvitationEntity::class,
                'userInvitation',
                'WITH', 
                'userInvitation.idUser = user.id'
            )
            ->andWhere('userInvitation.emailFriend = :email')
            ->setParameter('email', $this->user->getEmail())
            ->getQuery()
            ->getResult();
    }
}