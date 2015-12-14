<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Studentprogram
 *
 * @ORM\Table(name="studentprogram", uniqueConstraints={@ORM\UniqueConstraint(name="STUDENTNUMBER_UNIQUE", columns={"STUDENTNUMBER"})}, indexes={@ORM\Index(name="fk_stud_idx", columns={"FK_STUDENTID"}), @ORM\Index(name="fk_entry_idx", columns={"FK_ENTRYMANNERID"}), @ORM\Index(name="fk_program_idx", columns={"FK_PROGRAMID"})})
 * @ORM\Entity
 */
class Studentprogram
{
    /**
     * @var integer
     *
     * @ORM\Column(name="PK_STUDENTPROGRAMID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pkStudentprogramid;

    /**
     * @var integer
     *
     * @ORM\Column(name="STUDENTNUMBER", type="integer", nullable=false)
     */
    private $studentnumber;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="YEARJOINED", type="date", nullable=false)
     */
    private $yearjoined;

    /**
     * @var integer
     *
     * @ORM\Column(name="REPEATING_LEVEL", type="integer", nullable=true)
     */
    private $repeatingLevel;

    /**
     * @var \Application\Entity\Entrymanner
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Entrymanner")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_ENTRYMANNERID", referencedColumnName="PK_ENTRYMANNERID")
     * })
     */
    private $fkEntrymannerid;

    /**
     * @var \Application\Entity\Program
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Program")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_PROGRAMID", referencedColumnName="PK_PROGRAMID")
     * })
     */
    private $fkProgramid;

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
     * Get pkStudentprogramid
     *
     * @return integer
     */
    public function getPkStudentprogramid()
    {
        return $this->pkStudentprogramid;
    }

    /**
     * Set studentnumber
     *
     * @param integer $studentnumber
     *
     * @return Studentprogram
     */
    public function setStudentnumber($studentnumber)
    {
        $this->studentnumber = $studentnumber;

        return $this;
    }

    /**
     * Get studentnumber
     *
     * @return integer
     */
    public function getStudentnumber()
    {
        return $this->studentnumber;
    }

    /**
     * Set yearjoined
     *
     * @param \DateTime $yearjoined
     *
     * @return Studentprogram
     */
    public function setYearjoined($yearjoined)
    {
        $this->yearjoined = $yearjoined;

        return $this;
    }

    /**
     * Get yearjoined
     *
     * @return \DateTime
     */
    public function getYearjoined()
    {
        return $this->yearjoined;
    }

    /**
     * Set repeatingLevel
     *
     * @param integer $repeatingLevel
     *
     * @return Studentprogram
     */
    public function setRepeatingLevel($repeatingLevel)
    {
        $this->repeatingLevel = $repeatingLevel;

        return $this;
    }

    /**
     * Get repeatingLevel
     *
     * @return integer
     */
    public function getRepeatingLevel()
    {
        return $this->repeatingLevel;
    }

    /**
     * Set fkEntrymannerid
     *
     * @param \Application\Entity\Entrymanner $fkEntrymannerid
     *
     * @return Studentprogram
     */
    public function setFkEntrymannerid(\Application\Entity\Entrymanner $fkEntrymannerid = null)
    {
        $this->fkEntrymannerid = $fkEntrymannerid;

        return $this;
    }

    /**
     * Get fkEntrymannerid
     *
     * @return \Application\Entity\Entrymanner
     */
    public function getFkEntrymannerid()
    {
        return $this->fkEntrymannerid;
    }

    /**
     * Set fkProgramid
     *
     * @param \Application\Entity\Program $fkProgramid
     *
     * @return Studentprogram
     */
    public function setFkProgramid(\Application\Entity\Program $fkProgramid = null)
    {
        $this->fkProgramid = $fkProgramid;

        return $this;
    }

    /**
     * Get fkProgramid
     *
     * @return \Application\Entity\Program
     */
    public function getFkProgramid()
    {
        return $this->fkProgramid;
    }

    /**
     * Set fkStudentid
     *
     * @param \Application\Entity\Student $fkStudentid
     *
     * @return Studentprogram
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
