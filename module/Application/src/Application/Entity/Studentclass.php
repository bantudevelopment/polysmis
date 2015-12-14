<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Studentclass
 *
 * @ORM\Table(name="studentclass", uniqueConstraints={@ORM\UniqueConstraint(name="EXAMNUMBER_UNIQUE", columns={"EXAMNUMBER"})}, indexes={@ORM\Index(name="fk_studentidx_idx", columns={"FK_STUDENTID"}), @ORM\Index(name="fk_classidx_idx", columns={"FK_CLASSID"}), @ORM\Index(name="fk_periodidx_idx", columns={"FK_ACADEMICPERIODID"}), @ORM\Index(name="fk_studentprogramidx_idx", columns={"FK_STUDENTPROGRAMID"})})
 * @ORM\Entity
 */
class Studentclass
{
    /**
     * @var integer
     *
     * @ORM\Column(name="PK_STUDENTCLASSID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pkStudentclassid;

    /**
     * @var string
     *
     * @ORM\Column(name="EXAMNUMBER", type="string", length=20, nullable=false)
     */
    private $examnumber;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="REGISTRATIONDATE", type="datetime", nullable=true)
     */
    private $registrationdate;

    /**
     * @var string
     *
     * @ORM\Column(name="STATUS", type="text", nullable=true)
     */
    private $status;

    /**
     * @var \Application\Entity\Classes
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Classes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_CLASSID", referencedColumnName="PK_CLASSID")
     * })
     */
    private $fkClassid;

    /**
     * @var \Application\Entity\Academicyear
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Academicyear")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_ACADEMICPERIODID", referencedColumnName="PK_ACADEMICPERIODID")
     * })
     */
    private $fkAcademicperiodid;

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
     * @var \Application\Entity\Studentprogram
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Studentprogram")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_STUDENTPROGRAMID", referencedColumnName="PK_STUDENTPROGRAMID")
     * })
     */
    private $fkStudentprogramid;



    /**
     * Get pkStudentclassid
     *
     * @return integer
     */
    public function getPkStudentclassid()
    {
        return $this->pkStudentclassid;
    }

    /**
     * Set examnumber
     *
     * @param string $examnumber
     *
     * @return Studentclass
     */
    public function setExamnumber($examnumber)
    {
        $this->examnumber = $examnumber;

        return $this;
    }

    /**
     * Get examnumber
     *
     * @return string
     */
    public function getExamnumber()
    {
        return $this->examnumber;
    }

    /**
     * Set registrationdate
     *
     * @param \DateTime $registrationdate
     *
     * @return Studentclass
     */
    public function setRegistrationdate($registrationdate)
    {
        $this->registrationdate = $registrationdate;

        return $this;
    }

    /**
     * Get registrationdate
     *
     * @return \DateTime
     */
    public function getRegistrationdate()
    {
        return $this->registrationdate;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Studentclass
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set fkClassid
     *
     * @param \Application\Entity\Classes $fkClassid
     *
     * @return Studentclass
     */
    public function setFkClassid(\Application\Entity\Classes $fkClassid = null)
    {
        $this->fkClassid = $fkClassid;

        return $this;
    }

    /**
     * Get fkClassid
     *
     * @return \Application\Entity\Classes
     */
    public function getFkClassid()
    {
        return $this->fkClassid;
    }

    /**
     * Set fkAcademicperiodid
     *
     * @param \Application\Entity\Academicyear $fkAcademicperiodid
     *
     * @return Studentclass
     */
    public function setFkAcademicperiodid(\Application\Entity\Academicyear $fkAcademicperiodid = null)
    {
        $this->fkAcademicperiodid = $fkAcademicperiodid;

        return $this;
    }

    /**
     * Get fkAcademicperiodid
     *
     * @return \Application\Entity\Academicyear
     */
    public function getFkAcademicperiodid()
    {
        return $this->fkAcademicperiodid;
    }

    /**
     * Set fkStudentid
     *
     * @param \Application\Entity\Student $fkStudentid
     *
     * @return Studentclass
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

    /**
     * Set fkStudentprogramid
     *
     * @param \Application\Entity\Studentprogram $fkStudentprogramid
     *
     * @return Studentclass
     */
    public function setFkStudentprogramid(\Application\Entity\Studentprogram $fkStudentprogramid = null)
    {
        $this->fkStudentprogramid = $fkStudentprogramid;

        return $this;
    }

    /**
     * Get fkStudentprogramid
     *
     * @return \Application\Entity\Studentprogram
     */
    public function getFkStudentprogramid()
    {
        return $this->fkStudentprogramid;
    }
}
