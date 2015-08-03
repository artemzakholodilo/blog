<?php

namespace Blogger\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUser;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Blogger\BlogBundle\Entity\Repository\UserRepository")
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 */
class User extends OAuthUser implements EquatableInterface, \Serializable
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="social_id", type="string", length=255, unique=true, nullable=true)
     */
    protected $socialId;

    /**
     * @ORM\ManyToMany(targetEntity="Blogger\BlogBundle\Entity\Role", inversedBy="users")
     */
    protected $roles;

    /**
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     */
    protected $username;

    /**
     * @ORM\Column(name="realname", type="string", length=255, nullable=true)
     */
    protected $realName;

    /**
     * @ORM\Column(name="nickname", type="string", length=255, nullable=true)
     */
    protected $nickName;

    /**
     * @ORM\Column(name="salt", type="string", length=32)
     */
    protected $salt;

    /**
     * @ORM\Column(name="password", type="string", length=255)
     */
    protected $password;

    /**
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    protected $isActive;

    /**
     * @ORM\Column(name="work_hour_start", type="time", nullable=true)
     */
    protected $workHourStart;

    /**
     * @ORM\Column(name="work_hour_end", type="time", nullable=true)
     */
    protected $workHourEnd;

    /**
     * @ORM\Column(name="vacation_days", type="integer", length=2, nullable=true)
     */
    protected $vacationDays;

    public function __construct()
    {
        $this->roles = new ArrayCollection();

        $this->isActive = true;
        $this->salt = md5(uniqid(null, true));

        $workHoursStart = new \DateTime();
        $workHoursStart->setTime(0, 0, 0);

        $this->workHourStart = $workHoursStart;

        $workHoursEnd = new \DateTime();
        $workHoursEnd->setTime(0, 0, 0);

        $this->workHourEnd = $workHoursEnd;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getSocialId()
    {
        return $this->socialId;
    }

    /**
     * @param mixed $socialId
     */
    public function setSocialId($socialId)
    {
        $this->socialId = $socialId;
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getRealName()
    {
        return $this->realName;
    }

    /**
     * @param mixed $realName
     */
    public function setRealName($realName)
    {
        $this->realName = $realName;
    }

    /**
     * @return mixed
     */
    public function getNickName()
    {
        return $this->nickName;
    }

    /**
     * @param mixed $nickName
     */
    public function setNickName($nickName)
    {
        $this->nickName = $nickName;
    }

    /**
     * @return mixed
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param mixed $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param mixed $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * @return mixed
     */
    public function getWorkHourStart()
    {
        return $this->workHourStart;
    }

    /**
     * @param mixed $workHourStart
     */
    public function setWorkHourStart($workHourStart)
    {
        $this->workHourStart = $workHourStart;
    }

    /**
     * @return mixed
     */
    public function getWorkHourEnd()
    {
        return $this->workHourEnd;
    }

    /**
     * @param mixed $workHourEnd
     */
    public function setWorkHourEnd($workHourEnd)
    {
        $this->workHourEnd = $workHourEnd;
    }

    /**
     * @return mixed
     */
    public function getVacationDays()
    {
        return $this->vacationDays;
    }

    /**
     * @param mixed $vacationDays
     */
    public function setVacationDays($vacationDays)
    {
        $this->vacationDays = $vacationDays;
    }

    public function serialize()
    {
        return serialize([
            $this->id
        ]);
    }

    public function unserialize($serialized)
    {
        list($this->id) = unserialize($serialized);
    }

    public function isEqualTo(UserInterface $user)
    {
        if ((int)$this->getId() === $user->getId()) {
            return true;
        }

        return false;
    }

    public function eraseCredentials()
    {
        
    }
}