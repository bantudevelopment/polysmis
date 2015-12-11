<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Student
 *
 * @ORM\Table(name="student", indexes={@ORM\Index(name="staffuserid_idx", columns={"FK_USERID"}), @ORM\Index(name="studentdistrictfk_idx", columns={"FK_DISTRICTID"}), @ORM\Index(name="studentcountryfk_idx", columns={"FK_COUNTRYID"})})
 * @ORM\Entity
 */
class Student
{
    /**
     * @var integer
     *
     * @ORM\Column(name="PK_STUDENTID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pkStudentid;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DOB", type="date", nullable=true)
     */
    private $dob;

    /**
     * @var string
     *
     * @ORM\Column(name="LASTSECONDARYSCHOOL", type="string", length=50, nullable=true)
     */
    private $lastsecondaryschool;

    /**
     * @var integer
     *
     * @ORM\Column(name="REPEAT_HISTORY", type="integer", nullable=true)
     */
    private $repeatHistory;

    /**
     * @var string
     *
     * @ORM\Column(name="VILLAGE", type="string", length=50, nullable=true)
     */
    private $village;

    /**
     * @var string
     *
     * @ORM\Column(name="TA", type="string", length=45, nullable=true)
     */
    private $ta;

    /**
     * @var \Application\Entity\Country
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Country")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_COUNTRYID", referencedColumnName="PK_COUNTRYID")
     * })
     */
    private $fkCountryid;

    /**
     * @var \Application\Entity\District
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\District")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_DISTRICTID", referencedColumnName="PK_DISTRICTID")
     * })
     */
    private $fkDistrictid;

    /**
     * @var \Application\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_USERID", referencedColumnName="PK_USERID")
     * })
     */
    private $fkUserid;



    /**
     * Get pkStudentid
     *
     * @return integer
     */
    public function getPkStudentid()
    {
        return $this->pkStudentid;
    }

    /**
     * Set dob
     *
     * @param \DateTime $dob
     *
     * @return Student
     */
    public function setDob($dob)
    {
        $this->dob = $dob;

        return $this;
    }

    /**
     * Get dob
     *
     * @return \DateTime
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * Set lastsecondaryschool
     *
     * @param string $lastsecondaryschool
     *
     * @return Student
     */
    public function setLastsecondaryschool($lastsecondaryschool)
    {
        $this->lastsecondaryschool = $lastsecondaryschool;

        return $this;
    }

    /**
     * Get lastsecondaryschool
     *
     * @return string
     */
    public function getLastsecondaryschool()
    {
        return $this->lastsecondaryschool;
    }

    /**
     * Set repeatHistory
     *
     * @param integer $repeatHistory
     *
     * @return Student
     */
    public function setRepeatHistory($repeatHistory)
    {
        $this->repeatHistory = $repeatHistory;

        return $this;
    }

    /**
     * Get repeatHistory
     *
     * @return integer
     */
    public function getRepeatHistory()
    {
        return $this->repeatHistory;
    }

    /**
     * Set village
     *
     * @param string $village
     *
     * @return Student
     */
    public function setVillage($village)
    {
        $this->village = $village;

        return $this;
    }

    /**
     * Get village
     *
     * @return string
     */
    public function getVillage()
    {
        return $this->village;
    }

    /**
     * Set ta
     *
     * @param string $ta
     *
     * @return Student
     */
    public function setTa($ta)
    {
        $this->ta = $ta;

        return $this;
    }

    /**
     * Get ta
     *
     * @return string
     */
    public function getTa()
    {
        return $this->ta;
    }

    /**
     * Set fkCountryid
     *
     * @param \Application\Entity\Country $fkCountryid
     *
     * @return Student
     */
    public function setFkCountryid(\Application\Entity\Country $fkCountryid = null)
    {
        $this->fkCountryid = $fkCountryid;

        return $this;
    }

    /**
     * Get fkCountryid
     *
     * @return \Application\Entity\Country
     */
    public function getFkCountryid()
    {
        return $this->fkCountryid;
    }

    /**
     * Set fkDistrictid
     *
     * @param \Application\Entity\District $fkDistrictid
     *
     * @return Student
     */
    public function setFkDistrictid(\Application\Entity\District $fkDistrictid = null)
    {
        $this->fkDistrictid = $fkDistrictid;

        return $this;
    }

    /**
     * Get fkDistrictid
     *
     * @return \Application\Entity\District
     */
    public function getFkDistrictid()
    {
        return $this->fkDistrictid;
    }

    /**
     * Set fkUserid
     *
     * @param \Application\Entity\User $fkUserid
     *
     * @return Student
     */
    public function setFkUserid(\Application\Entity\User $fkUserid = null)
    {
        $this->fkUserid = $fkUserid;

        return $this;
    }

    /**
     * Get fkUserid
     *
     * @return \Application\Entity\User
     */
    public function getFkUserid()
    {
        return $this->fkUserid;
    }
}
