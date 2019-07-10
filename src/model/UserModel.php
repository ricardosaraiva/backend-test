<?php 

namespace Model;

use Firebase\JWT\JWT;
use Entity\UserEntity;
use Entity\UserLoginEntity;
use Entity\UserFriendEntity;
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
            ->getRepository(UserFriendEntity::class)
            ->findOneBy([
                'idUser' => $this->user->getId(),
                'emailFriend' => $email
            ]);

        if(!empty($userInvitationValidate)) {
            $error = ($userInvitationValidate->getStatus()) ? 'You are already friends' : 
            'already exists invitation to this user';    
            
            throw new ModelResponseException($error);
        }

        $userFriendValidate = $this->em
            ->getRepository(UserFriendEntity::class)
            ->createQueryBuilder('userFriend')
            ->join(UserEntity::class, 'user', 'WITH', 'userFriend.idUser = user.id')
            ->andWhere('userFriend.emailFriend = :emailFriend')
            ->andWhere('user.email = :emailUser')
            ->setParameter('emailFriend', $email)
            ->setParameter('emailUser', $this->user->getEmail())
            ->getQuery()
            ->getResult();

            if(!empty($userFriendValidate)) {
                $error = ($userInvitationValidate->getStatus()) ? 'You are already friends' : 
                    'already exists invitation to this user';    

                throw new ModelResponseException($error);
            }

        $userFriendEntity = new UserFriendEntity();
        $userFriendEntity->setIdUser($this->user->getId());
        $userFriendEntity->setEmailFriend($email);
        $this->em->persist($userFriendEntity);
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
                UserFriendEntity::class,
                'userFriend',
                'WITH', 
                'userFriend.idUser = user.id'
            )
            ->andWhere('userFriend.emailFriend = :email')
            ->andWhere('userFriend.status IS NULL')
            ->setParameter('email', $this->user->getEmail())
            ->getQuery()
            ->getResult();
    }

    /**
     *
     * @param bool $status
     * @return void
     */
    public function invitationStatus($idUser, $status) {

        $userFriendEntity = $this->em
            ->getRepository(UserFriendEntity::class)
            ->findOneBy([
                'idUser' => $idUser,
                'emailFriend' => $this->user->getEmail(),
            ]);

        if(empty($userFriendEntity)) {
            $error = $status ? 'Invalid friendship request' : 'Invalid Friend';
            throw new ModelResponseException($error);
        }

        $userFriendEntity->setStatus((bool) $status);
        $this->em->persist($userFriendEntity);
        $this->em->flush();
    }

    public function friendsList() {

        return $this->em
            ->getRepository(UserEntity::class)
            ->createQueryBuilder('user')
            ->join(
                UserFriendEntity::class,
                'userFriend',
                'WITH',
                'userFriend.idUser = user.id OR userFriend.emailFriend = user.email'
            )
            ->andWhere('user.id != :myId')
            ->andWhere('(userFriend.emailFriend = :email OR userFriend.idUser = :id)')
            ->andWhere('userFriend.status = 1')
            ->setParameter('email', $this->user->getEmail())
            ->setParameter('myId', $this->user->getId())
            ->setParameter('id', $this->user->getId())
            ->getQuery()
            ->getResult();
    }

    public function undoFriendship($idUser) {

        $userFriendEntity = $this->em
            ->getRepository(UserFriendEntity::class)
            ->findOneBy([
                'idUser' => $idUser,
                'emailFriend' => $this->user->getEmail(),
                'status' => true
            ]);

        if(!empty($userFriendEntity)) {
            $this->em->remove($userFriendEntity);
            $this->em->flush();
            return;
        }

        $userFriendEntity = $this->em
            ->getRepository(UserFriendEntity::class)
            ->createQueryBuilder('userFriend')
            ->join(UserEntity::class, 'user', 'WITH', 'userFriend.emailFriend = user.email')
            ->andWhere('userFriend.idUser = :idUser')
            ->andWhere('user.id = :id')
            ->andWhere('userFriend.status = true')
            ->setParameter('idUser', $this->user->getId())
            ->setParameter('id', $idUser)
            ->getQuery()
            ->getResult();
        
            if(empty($userFriendEntity)) {
                throw new ModelResponseException('Invalid friendship request');
            }

            $this->em->remove($userFriendEntity[0]);
            $this->em->flush();
    }

    public function isFriend($idUser) {
        $friend = $this->em
            ->getRepository(UserEntity::class)
            ->createQueryBuilder('user')
            ->join(
                UserFriendEntity::class,
                'userFriend',
                'WITH',
                'userFriend.idUser = user.id OR userFriend.emailFriend = user.email'
            )
            ->andWhere('user.id != :myId')
            ->andWhere('(userFriend.emailFriend = :email OR userFriend.idUser = :id)')
            ->andWhere('userFriend.status = 1')
            ->andWhere('user.id = :idUser')
            ->setParameter('email', $this->user->getEmail())
            ->setParameter('myId', $this->user->getId())
            ->setParameter('id', $this->user->getId())
            ->setParameter('idUser', $idUser)
            ->getQuery()
            ->getResult();

        return (!empty($friend)) ? true : false;
    }
}