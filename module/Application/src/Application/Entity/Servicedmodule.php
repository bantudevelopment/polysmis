<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Servicedmodule
 *
 * @ORM\Table(name="servicedmodule", indexes={@ORM\Index(name="servicingdept_idx", columns={"SERVICINGDEPT"}), @ORM\Index(name="requestingdept_idx", columns={"REQDEPT"}), @ORM\Index(name="assignedlecturermodule_idx", columns={"FKLMID"}), @ORM\Index(name="servicedmodule_fx_idx", columns={"FK_CLASSMODULEID"})})
 * @ORM\Entity
 */
class Servicedmodule
{
    /**
     * @var integer
     *
     * @ORM\Column(name="PK_SMID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pkSmid;

    /**
     * @var string
     *
     * @ORM\Column(name="FLAG", type="text", nullable=false)
     */
    private $flag;
    
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
     * @var \Application\Entity\Department
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Department")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="SERVICINGDEPT", referencedColumnName="PK_DEPTID")
     * })
     */
    private $servicingdept;

    /**
     * @var \Application\Entity\Department
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Department")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="REQDEPT", referencedColumnName="PK_DEPTID")
     * })
     */
    private $reqdept;

    /**
     * @var \Application\Entity\Lecturermodule
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Lecturermodule")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FKLMID", referencedColumnName="PK_LMID")
     * })
     */
    private $fklmid;



    /**
     * Get pkSmid
     *
     * @return integer
     */
    public function getPkSmid()
    {
        return $this->pkSmid;
    }

    /**
     * Set flag
     *
     * @param string $flag
     *
     * @return Servicedmodule
     */
    public function setFlag($flag)
    {
        $this->flag = $flag;

        return $this;
    }

    /**
     * Get flag
     *
     * @return string
     */
    public function getFlag()
    {
        return $this->flag;
    }
    
    /**
     * Set fkClassmoduleid
     *
     * @param \Application\Entity\Classmodule $fkClassmoduleid
     *
     * @return Servicedmodule
     */
    
    public function setFkClassmoduleid(\Application\Entity\Classmodule $fkClassmoduleid = null)
    {
        $this->fkClassmoduleid = $fkClassmoduleid;

        return $this;
    }

    /**
     * Get fkClassmoduleid
     *
     * @return \Application\Entity\Department
     */
    public function getFkClassmoduleid()
    {
        return $this->fkClassmoduleid;
    }

    /**
     * Set servicingdept
     *
     * @param \Application\Entity\Department $servicingdept
     *
     * @return Servicedmodule
     */
    public function setServicingdept(\Application\Entity\Department $servicingdept = null)
    {
        $this->servicingdept = $servicingdept;

        return $this;
    }

    /**
     * Get servicingdept
     *
     * @return \Application\Entity\Department
     */
    public function getServicingdept()
    {
        return $this->servicingdept;
    }

    /**
     * Set reqdept
     *
     * @param \Application\Entity\Department $reqdept
     *
     * @return Servicedmodule
     */
    public function setReqdept(\Application\Entity\Department $reqdept = null)
    {
        $this->reqdept = $reqdept;

        return $this;
    }

    /**
     * Get reqdept
     *
     * @return \Application\Entity\Department
     */
    public function getReqdept()
    {
        return $this->reqdept;
    }

    /**
     * Set fklmid
     *
     * @param \Application\Entity\Lecturermodule $fklmid
     *
     * @return Servicedmodule
     */
    public function setFklmid(\Application\Entity\Lecturermodule $fklmid = null)
    {
        $this->fklmid = $fklmid;

        return $this;
    }

    /**
     * Get fklmid
     *
     * @return \Application\Entity\Lecturermodule
     */
    public function getFklmid()
    {
        return $this->fklmid;
    }
}
