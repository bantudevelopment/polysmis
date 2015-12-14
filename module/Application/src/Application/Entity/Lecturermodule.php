<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lecturermodule
 *
 * @ORM\Table(name="lecturermodule", indexes={@ORM\Index(name="modulelecturer_idx", columns={"FK_STAFFID"}), @ORM\Index(name="assignedmodulefk_idx", columns={"FK_CLASSMODULEID"})})
 * @ORM\Entity
 */
class Lecturermodule
{
    /**
     * @var integer
     *
     * @ORM\Column(name="PK_LMID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pkLmid;

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
     * @var \Application\Entity\Classmodule
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Classmodule")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_CLASSMODULEID", referencedColumnName="PK_CLASSMODULEID")
     * })
     */
    private $fkClassmoduleid;



    /**
     * Get pkLmid
     *
     * @return integer
     */
    public function getPkLmid()
    {
        return $this->pkLmid;
    }

    /**
     * Set fkStaffid
     *
     * @param \Application\Entity\Staff $fkStaffid
     *
     * @return Lecturermodule
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

    /**
     * Set fkClassmoduleid
     *
     * @param \Application\Entity\Classmodule $fkClassmoduleid
     *
     * @return Lecturermodule
     */
    public function setFkClassmoduleid(\Application\Entity\Classmodule $fkClassmoduleid = null)
    {
        $this->fkClassmoduleid = $fkClassmoduleid;

        return $this;
    }

    /**
     * Get fkClassmoduleid
     *
     * @return \Application\Entity\Classmodule
     */
    public function getFkClassmoduleid()
    {
        return $this->fkClassmoduleid;
    }
}
