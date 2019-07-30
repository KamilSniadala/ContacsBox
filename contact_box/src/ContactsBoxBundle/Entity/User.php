<?php

namespace ContactsBoxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="ContactsBoxBundle\Repository\UserRepository")
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=25)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=50)
     */
    private $surname;

    /**
     * @var int
     *
     * @ORM\Column(name="age", type="integer")
     */
    private $age;

    /**
     * @var bool
     *
     * @ORM\Column(name="sex", type="boolean")
     */
    private $sex;

    /**
     * @var string
     *
     * @ORM\Column(name="portrait", type="string", length=255)
     */
    private $portrait;
    /**
     * @var integer
     * @ORM\OneToMany(targetEntity="ContactsBoxBundle\Entity\Address", mappedBy="user")
     */
    private $addresses;
    /**
     * @var integer
     * @ORM\OneToMany(targetEntity="ContactsBoxBundle\Entity\Mail", mappedBy="user")
     *
     */
    private $mails;
    /**
     * @ORM\OneToMany(targetEntity="ContactsBoxBundle\Entity\PhoneNumber", mappedBy="user")
     */
    private $phoneNumbers;
    /**
     * @ORM\ManyToMany(targetEntity="ContactsBoxBundle\Entity\Groups", inversedBy="users")
     * @ORM\JoinTable(name="users_groups")
     */
    private $groups;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
        $this->mails = new ArrayCollection();
        $this->groups = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */

    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     *
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return User
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set sex
     *
     * @param boolean $sex
     *
     * @return User
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex
     *
     * @return bool
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set portrait
     *
     * @param string $portrait
     *
     * @return User
     */
    public function setPortrait($portrait)
    {
        $this->portrait = $portrait;

        return $this;
    }

    /**
     * Get portrait
     *
     * @return string
     */
    public function getPortrait()
    {
        return $this->portrait;
    }

    /**
     * @return int
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @param int $addresses
     */
    public function setAddresses($addresses)
    {
        $this->addresses = $addresses;
    }

    /**
     * @return int
     */
    public function getMails()
    {
        return $this->mails;
    }

    /**
     * @param int $mails
     */
    public function setMails($mails)
    {
        $this->mails = $mails;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumbers()
    {
        return $this->phoneNumbers;
    }

    /**
     * @param mixed $phoneNumbers
     */
    public function setPhoneNumbers($phoneNumbers): void
    {
        $this->phoneNumbers = $phoneNumbers;
    }

    /**
     * @return mixed
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param mixed $groups
     */
    public function setGroups($groups): void
    {
        $this->groups = $groups;
    }
}

