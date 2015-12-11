<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Department
 *
 * @ORM\Table(name="department", uniqueConstraints={@ORM\UniqueConstraint(name="DEPT_CODE_UNIQUE", columns={"DEPT_CODE"})}, indexes={@ORM\Index(name="FACULTYFK_idx", columns={"FK_FACULTYID"}), @ORM\Index(name="HOD_idx", columns={"FK_STAFFID"})})
 * @ORM\Entity
 */
class Department
{
    /**
     * @var integer
     *
     * @ORM\Column(name="PK_DEPTID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pkDeptid;

    /**
     * @var string
     *
     * @ORM\Column(name="DEPT_CODE", type="string", length=10, nullable=false)
     */
    private $deptCode = '';

    /**
     * @var string
     *
     * @ORM\Column(name="DEPT_NAME", type="string", length=50, nullable=false)
     */
    private $deptName;

    /**
     * @var \Application\Entity\Faculty
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Faculty")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_FACULTYID", referencedColumnName="PK_FACULTYID")
     * })
     */
    private $fkFacultyid;

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
     * Get pkDeptid
     *
     * @return integer
     */
    public function getPkDeptid()
    {
        return $this->pkDeptid;
    }

    /**
     * Set deptCode
     *
     * @param string $deptCode
     *
     * @return Department
     */
    public function setDeptCode($deptCode)
    {
        $this->deptCode = $deptCode;

        return $this;
    }

    /**
     * Get deptCode
     *
     * @return string
     */
    public function getDeptCode()
    {
        return $this->deptCode;
    }

    /**
     * Set deptName
     *
     * @param string $deptName
     *
     * @return Department
     */
    public function setDeptName($deptName)
    {
        $this->deptName = $deptName;

        return $this;
    }

    /**
     * Get deptName
     *
     * @return string
     */
    public function getDeptName()
    {
        return $this->deptName;
    }

    /**
     * Set fkFacultyid
     *
     * @param \Application\Entity\Faculty $fkFacultyid
     *
     * @return Department
     */
    public function setFkFacultyid(\Application\Entity\Faculty $fkFacultyid = null)
    {
        $this->fkFacultyid = $fkFacultyid;

        return $this;
    }

    /**
     * Get fkFacultyid
     *
     * @return \Application\Entity\Faculty
     */
    public function getFkFacultyid()
    {
        return $this->fkFacultyid;
    }

    /**
     * Set fkStaffid
     *
     * @param \Application\Entity\Staff $fkStaffid
     *
     * @return Department
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
