<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Studentcontact
 *
 * @ORM\Table(name="studentcontact", indexes={@ORM\Index(name="fk_studentcontact_idx", columns={"FK_STUDENTID"})})
 * @ORM\Entity
 */
class Studentcontact
{
    /**
     * @var integer
     *
     * @ORM\Column(name="PK_CONTACTID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pkContactid;

    /**
     * @var string
     *
     * @ORM\Column(name="MOBILE", type="string", length=30, nullable=true)
     */
    private $mobile;

    /**
     * @var string
     *
     * @ORM\Column(name="LANDLINE", type="string", length=10, nullable=true)
     */
    private $landline;

    /**
     * @var string
     *
     * @ORM\Column(name="POSTALADDRESS", type="text", length=65535, nullable=true)
     */
    private $postaladdress;

    /**
     * @var string
     *
     * @ORM\Column(name="NOKTITLE", type="string", length=45, nullable=true)
     */
    private $noktitle;

    /**
     * @var string
     *
     * @ORM\Column(name="NOKFIRSTNAME", type="string", length=45, nullable=true)
     */
    private $nokfirstname;

    /**
     * @var string
     *
     * @ORM\Column(name="NOKSURNAME", type="string", length=45, nullable=true)
     */
    private $noksurname;

    /**
     * @var string
     *
     * @ORM\Column(name="NOKRELATIONSHIP", type="string", length=45, nullable=true)
     */
    private $nokrelationship;

    /**
     * @var string
     *
     * @ORM\Column(name="NOKPOSTALADDRESS", type="text", length=65535, nullable=true)
     */
    private $nokpostaladdress;

    /**
     * @var string
     *
     * @ORM\Column(name="NOKMOBILE", type="string", length=30, nullable=true)
     */
    private $nokmobile;

    /**
     * @var string
     *
     * @ORM\Column(name="NOKEMAIL", type="string", length=45, nullable=true)
     */
    private $nokemail;

    /**
     * @var \Application\Entity\Student
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Student")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_STUDENTID", referencedColumnName="PK_STUDENTID")
     * })
     */
    private $fkStudentid;



    /**
     * Get pkContactid
     *
     * @return integer
     */
    public function getPkContactid()
    {
        return $this->pkContactid;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     *
     * @return Studentcontact
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set landline
     *
     * @param string $landline
     *
     * @return Studentcontact
     */
    public function setLandline($landline)
    {
        $this->landline = $landline;

        return $this;
    }

    /**
     * Get landline
     *
     * @return string
     */
    public function getLandline()
    {
        return $this->landline;
    }

    /**
     * Set postaladdress
     *
     * @param string $postaladdress
     *
     * @return Studentcontact
     */
    public function setPostaladdress($postaladdress)
    {
        $this->postaladdress = $postaladdress;

        return $this;
    }

    /**
     * Get postaladdress
     *
     * @return string
     */
    public function getPostaladdress()
    {
        return $this->postaladdress;
    }

    /**
     * Set noktitle
     *
     * @param string $noktitle
     *
     * @return Studentcontact
     */
    public function setNoktitle($noktitle)
    {
        $this->noktitle = $noktitle;

        return $this;
    }

    /**
     * Get noktitle
     *
     * @return string
     */
    public function getNoktitle()
    {
        return $this->noktitle;
    }

    /**
     * Set nokfirstname
     *
     * @param string $nokfirstname
     *
     * @return Studentcontact
     */
    public function setNokfirstname($nokfirstname)
    {
        $this->nokfirstname = $nokfirstname;

        return $this;
    }

    /**
     * Get nokfirstname
     *
     * @return string
     */
    public function getNokfirstname()
    {
        return $this->nokfirstname;
    }

    /**
     * Set noksurname
     *
     * @param string $noksurname
     *
     * @return Studentcontact
     */
    public function setNoksurname($noksurname)
    {
        $this->noksurname = $noksurname;

        return $this;
    }

    /**
     * Get noksurname
     *
     * @return string
     */
    public function getNoksurname()
    {
        return $this->noksurname;
    }

    /**
     * Set nokrelationship
     *
     * @param string $nokrelationship
     *
     * @return Studentcontact
     */
    public function setNokrelationship($nokrelationship)
    {
        $this->nokrelationship = $nokrelationship;

        return $this;
    }

    /**
     * Get nokrelationship
     *
     * @return string
     */
    public function getNokrelationship()
    {
        return $this->nokrelationship;
    }

    /**
     * Set nokpostaladdress
     *
     * @param string $nokpostaladdress
     *
     * @return Studentcontact
     */
    public function setNokpostaladdress($nokpostaladdress)
    {
        $this->nokpostaladdress = $nokpostaladdress;

        return $this;
    }

    /**
     * Get nokpostaladdress
     *
     * @return string
     */
    public function getNokpostaladdress()
    {
        return $this->nokpostaladdress;
    }

    /**
     * Set nokmobile
     *
     * @param string $nokmobile
     *
     * @return Studentcontact
     */
    public function setNokmobile($nokmobile)
    {
        $this->nokmobile = $nokmobile;

        return $this;
    }

    /**
     * Get nokmobile
     *
     * @return string
     */
    public function getNokmobile()
    {
        return $this->nokmobile;
    }

    /**
     * Set nokemail
     *
     * @param string $nokemail
     *
     * @return Studentcontact
     */
    public function setNokemail($nokemail)
    {
        $this->nokemail = $nokemail;

        return $this;
    }

    /**
     * Get nokemail
     *
     * @return string
     */
    public function getNokemail()
    {
        return $this->nokemail;
    }

    /**
     * Set fkStudentid
     *
     * @param \Application\Entity\Student $fkStudentid
     *
     * @return Studentcontact
     */
    public function setFkStudentid(\Application\Entity\Student $fkStudentid = null)
    {
        $this->fkStudentid = $fkStudentid;

        return $this;
    }

    /**
     * Get fkStudentid
     *
     * @return \Application\Entity\Student
     */
    public function getFkStudentid()
    {
        return $this->fkStudentid;
    }
}
