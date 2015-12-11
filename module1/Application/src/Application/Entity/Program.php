<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Program
 *
 * @ORM\Table(name="program", indexes={@ORM\Index(name="deptprogram_idx", columns={"FK_DEPTID"}), @ORM\Index(name="programmeaward_idx", columns={"FK_AWARDID"})})
 * @ORM\Entity
 */
class Program
{
    /**
     * @var integer
     *
     * @ORM\Column(name="PK_PROGRAMID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pkProgramid;

    /**
     * @var string
     *
     * @ORM\Column(name="PROGRAM_CODE", type="string", length=10, nullable=false)
     */
    private $programCode = '';

    /**
     * @var string
     *
     * @ORM\Column(name="PROGRAM_NAME", type="string", length=255, nullable=false)
     */
    private $programName = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="DURATION", type="integer", nullable=false)
     */
    private $duration;

    /**
     * @var string
     *
     * @ORM\Column(name="PROGRAM_LONG_NAME", type="string", length=150, nullable=false)
     */
    private $programLongName;

    /**
     * @var \Application\Entity\Department
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Department")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_DEPTID", referencedColumnName="PK_DEPTID")
     * })
     */
    private $fkDeptid;

    /**
     * @var \Application\Entity\Award
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Award")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_AWARDID", referencedColumnName="PK_AWARDID")
     * })
     */
    private $fkAwardid;



    /**
     * Get pkProgramid
     *
     * @return integer
     */
    public function getPkProgramid()
    {
        return $this->pkProgramid;
    }

    /**
     * Set programCode
     *
     * @param string $programCode
     *
     * @return Program
     */
    public function setProgramCode($programCode)
    {
        $this->programCode = $programCode;

        return $this;
    }

    /**
     * Get programCode
     *
     * @return string
     */
    public function getProgramCode()
    {
        return $this->programCode;
    }

    /**
     * Set programName
     *
     * @param string $programName
     *
     * @return Program
     */
    public function setProgramName($programName)
    {
        $this->programName = $programName;

        return $this;
    }

    /**
     * Get programName
     *
     * @return string
     */
    public function getProgramName()
    {
        return $this->programName;
    }

    /**
     * Set duration
     *
     * @param integer $duration
     *
     * @return Program
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return integer
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set programLongName
     *
     * @param string $programLongName
     *
     * @return Program
     */
    public function setProgramLongName($programLongName)
    {
        $this->programLongName = $programLongName;

        return $this;
    }

    /**
     * Get programLongName
     *
     * @return string
     */
    public function getProgramLongName()
    {
        return $this->programLongName;
    }

    /**
     * Set fkDeptid
     *
     * @param \Application\Entity\Department $fkDeptid
     *
     * @return Program
     */
    public function setFkDeptid(\Application\Entity\Department $fkDeptid = null)
    {
        $this->fkDeptid = $fkDeptid;

        return $this;
    }

    /**
     * Get fkDeptid
     *
     * @return \Application\Entity\Department
     */
    public function getFkDeptid()
    {
        return $this->fkDeptid;
    }

    /**
     * Set fkAwardid
     *
     * @param \Application\Entity\Award $fkAwardid
     *
     * @return Program
     */
    public function setFkAwardid(\Application\Entity\Award $fkAwardid = null)
    {
        $this->fkAwardid = $fkAwardid;

        return $this;
    }

    /**
     * Get fkAwardid
     *
     * @return \Application\Entity\Award
     */
    public function getFkAwardid()
    {
        return $this->fkAwardid;
    }
}
