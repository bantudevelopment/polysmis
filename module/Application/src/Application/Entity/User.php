<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="USERNAME_UNIQUE", columns={"USERNAME"}), @ORM\UniqueConstraint(name="EMAILADDRESS_UNIQUE", columns={"EMAILADDRESS"})}, indexes={@ORM\Index(name="userrole_fk_idx", columns={"FK_ROLEID"})})
 * @ORM\Entity
 */
class User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="PK_USERID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pkUserid;

    /**
     * @var string
     *
     * @ORM\Column(name="USERNAME", type="string", length=50, nullable=false)
     */
    private $username = '';

    /**
     * @var string
     *
     * @ORM\Column(name="PASSWORD", type="string", length=50, nullable=true)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="IPADDRESS", type="string", length=20, nullable=true)
     */
    private $ipaddress;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="PASSWORDLASTCHANGED", type="datetime", nullable=true)
     */
    private $passwordlastchanged;

    /**
     * @var integer
     *
     * @ORM\Column(name="LOGINTIMES", type="integer", nullable=true)
     */
    private $logintimes = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="LASTLOGINDATE", type="datetime", nullable=true)
     */
    private $lastlogindate;

    /**
     * @var string
     *
     * @ORM\Column(name="LASTLOGINIP", type="string", length=20, nullable=true)
     */
    private $lastloginip;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="LOGINDATE", type="datetime", nullable=true)
     */
    private $logindate;

    /**
     * @var string
     *
     * @ORM\Column(name="ACCOUNTTYPE", type="text", nullable=true)
     */
    private $accounttype = 'STUDENT';

    /**
     * @var string
     *
     * @ORM\Column(name="FIRSTNAME", type="string", length=45, nullable=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="SURNAME", type="string", length=45, nullable=false)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="TITLE", type="string", length=10, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="GENDER", type="text", nullable=true)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="OTHERNAMES", type="string", length=45, nullable=true)
     */
    private $othernames;

    /**
     * @var string
     *
     * @ORM\Column(name="EMAILADDRESS", type="string", length=45, nullable=true)
     */
    private $emailaddress;

    /**
     * @var \Application\Entity\Role
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Role")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_ROLEID", referencedColumnName="PK_ROLEID")
     * })
     */
    private $fkRoleid;



    /**
     * Get pkUserid
     *
     * @return integer
     */
    public function getPkUserid()
    {
        return $this->pkUserid;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set ipaddress
     *
     * @param string $ipaddress
     *
     * @return User
     */
    public function setIpaddress($ipaddress)
    {
        $this->ipaddress = $ipaddress;

        return $this;
    }

    /**
     * Get ipaddress
     *
     * @return string
     */
    public function getIpaddress()
    {
        return $this->ipaddress;
    }

    /**
     * Set passwordlastchanged
     *
     * @param \DateTime $passwordlastchanged
     *
     * @return User
     */
    public function setPasswordlastchanged($passwordlastchanged)
    {
        $this->passwordlastchanged = $passwordlastchanged;

        return $this;
    }

    /**
     * Get passwordlastchanged
     *
     * @return \DateTime
     */
    public function getPasswordlastchanged()
    {
        return $this->passwordlastchanged;
    }

    /**
     * Set logintimes
     *
     * @param integer $logintimes
     *
     * @return User
     */
    public function setLogintimes($logintimes)
    {
        $this->logintimes = $logintimes;

        return $this;
    }

    /**
     * Get logintimes
     *
     * @return integer
     */
    public function getLogintimes()
    {
        return $this->logintimes;
    }

    /**
     * Set lastlogindate
     *
     * @param \DateTime $lastlogindate
     *
     * @return User
     */
    public function setLastlogindate($lastlogindate)
    {
        $this->lastlogindate = $lastlogindate;

        return $this;
    }

    /**
     * Get lastlogindate
     *
     * @return \DateTime
     */
    public function getLastlogindate()
    {
        return $this->lastlogindate;
    }

    /**
     * Set lastloginip
     *
     * @param string $lastloginip
     *
     * @return User
     */
    public function setLastloginip($lastloginip)
    {
        $this->lastloginip = $lastloginip;

        return $this;
    }

    /**
     * Get lastloginip
     *
     * @return string
     */
    public function getLastloginip()
    {
        return $this->lastloginip;
    }

    /**
     * Set logindate
     *
     * @param \DateTime $logindate
     *
     * @return User
     */
    public function setLogindate($logindate)
    {
        $this->logindate = $logindate;

        return $this;
    }

    /**
     * Get logindate
     *
     * @return \DateTime
     */
    public function getLogindate()
    {
        return $this->logindate;
    }

    /**
     * Set accounttype
     *
     * @param string $accounttype
     *
     * @return User
     */
    public function setAccounttype($accounttype)
    {
        $this->accounttype = $accounttype;

        return $this;
    }

    /**
     * Get accounttype
     *
     * @return string
     */
    public function getAccounttype()
    {
        return $this->accounttype;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
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
     * Set title
     *
     * @param string $title
     *
     * @return User
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set othernames
     *
     * @param string $othernames
     *
     * @return User
     */
    public function setOthernames($othernames)
    {
        $this->othernames = $othernames;

        return $this;
    }

    /**
     * Get othernames
     *
     * @return string
     */
    public function getOthernames()
    {
        return $this->othernames;
    }

    /**
     * Set emailaddress
     *
     * @param string $emailaddress
     *
     * @return User
     */
    public function setEmailaddress($emailaddress)
    {
        $this->emailaddress = $emailaddress;

        return $this;
    }

    /**
     * Get emailaddress
     *
     * @return string
     */
    public function getEmailaddress()
    {
        return $this->emailaddress;
    }

    /**
     * Set fkRoleid
     *
     * @param \Application\Entity\Role $fkRoleid
     *
     * @return User
     */
    public function setFkRoleid(\Application\Entity\Role $fkRoleid = null)
    {
        $this->fkRoleid = $fkRoleid;

        return $this;
    }

    /**
     * Get fkRoleid
     *
     * @return \Application\Entity\Role
     */
    public function getFkRoleid()
    {
        return $this->fkRoleid;
    }
}
