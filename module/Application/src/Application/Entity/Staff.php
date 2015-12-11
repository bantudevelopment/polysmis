<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Staff
 *
 * @ORM\Table(name="staff", indexes={@ORM\Index(name="staffuserid_idx", columns={"FK_USERID"}), @ORM\Index(name="userdepartment_idx", columns={"FK_DEPTID"})})
 * @ORM\Entity
 */
class Staff
{
    /**
     * @var integer
     *
     * @ORM\Column(name="PK_STAFFID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pkStaffid;

    /**
     * @var string
     *
     * @ORM\Column(name="WORKMODE", type="text", nullable=false)
     */
    private $workmode = 'FULLTIME';

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
     * @var \Application\Entity\Department
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Department")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_DEPTID", referencedColumnName="PK_DEPTID")
     * })
     */
    private $fkDeptid;



    /**
     * Get pkStaffid
     *
     * @return integer
     */
    public function getPkStaffid()
    {
        return $this->pkStaffid;
    }

    /**
     * Set workmode
     *
     * @param string $workmode
     *
     * @return Staff
     */
    public function setWorkmode($workmode)
    {
        $this->workmode = $workmode;

        return $this;
    }

    /**
     * Get workmode
     *
     * @return string
     */
    public function getWorkmode()
    {
        return $this->workmode;
    }

    /**
     * Set fkUserid
     *
     * @param \Application\Entity\User $fkUserid
     *
     * @return Staff
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

    /**
     * Set fkDeptid
     *
     * @param \Application\Entity\Department $fkDeptid
     *
     * @return Staff
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
}
