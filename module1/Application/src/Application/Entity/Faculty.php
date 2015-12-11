<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Faculty
 *
 * @ORM\Table(name="faculty", uniqueConstraints={@ORM\UniqueConstraint(name="FACULTY_CODE_UNIQUE", columns={"FACULTY_CODE"})}, indexes={@ORM\Index(name="deanfk_idx", columns={"FK_STAFFID"})})
 * @ORM\Entity
 */
class Faculty
{
    /**
     * @var integer
     *
     * @ORM\Column(name="PK_FACULTYID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pkFacultyid;

    /**
     * @var string
     *
     * @ORM\Column(name="FACULTY_CODE", type="string", length=10, nullable=false)
     */
    private $facultyCode = '';

    /**
     * @var string
     *
     * @ORM\Column(name="FACULTY_NAME", type="string", length=45, nullable=false)
     */
    private $facultyName = '';

    /**
     * @var \Application\Entity\Staff
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Staff")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_STAFFID", referencedColumnName="PK_STAFFID")
     * })
     */
    private $fkStaffid;



    /**
     * Get pkFacultyid
     *
     * @return integer
     */
    public function getPkFacultyid()
    {
        return $this->pkFacultyid;
    }

    /**
     * Set facultyCode
     *
     * @param string $facultyCode
     *
     * @return Faculty
     */
    public function setFacultyCode($facultyCode)
    {
        $this->facultyCode = $facultyCode;

        return $this;
    }

    /**
     * Get facultyCode
     *
     * @return string
     */
    public function getFacultyCode()
    {
        return $this->facultyCode;
    }

    /**
     * Set facultyName
     *
     * @param string $facultyName
     *
     * @return Faculty
     */
    public function setFacultyName($facultyName)
    {
        $this->facultyName = $facultyName;

        return $this;
    }

    /**
     * Get facultyName
     *
     * @return string
     */
    public function getFacultyName()
    {
        return $this->facultyName;
    }

    /**
     * Set fkStaffid
     *
     * @param \Application\Entity\Staff $fkStaffid
     *
     * @return Faculty
     */
    public function setFkStaffid(\Application\Entity\Staff $fkStaffid = null)
    {
        $this->fkStaffid = $fkStaffid;

        return $this;
    }

    /**
     * Get fkStaffid
     *
     * @return \Application\Entity\Staff
     */
    public function getFkStaffid()
    {
        return $this->fkStaffid;
    }
}
