<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classmodule
 *
 * @ORM\Table(name="classmodule", indexes={@ORM\Index(name="classmodulefk_idx", columns={"FK_MODULEID"}), @ORM\Index(name="classfk_idx", columns={"FK_CLASSID"}), @ORM\Index(name="parentfk_idx", columns={"PARENTMODULE"}), @ORM\Index(name="noduleacademicperiod_idx", columns={"FK_ACADEMICPERIOD"})})
 * @ORM\Entity
 */
class Classmodule
{
    /**
     * @var integer
     *
     * @ORM\Column(name="PK_CLASSMODULEID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pkClassmoduleid;

    /**
     * @var integer
     *
     * @ORM\Column(name="CWKWEIGHT", type="integer", nullable=true)
     */
    private $cwkweight = '60';

    /**
     * @var integer
     *
     * @ORM\Column(name="EXWEIGHT", type="integer", nullable=true)
     */
    private $exweight = '40';

    /**
     * @var boolean
     *
     * @ORM\Column(name="IS_PROJECT", type="boolean", nullable=true)
     */
    private $isProject = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="IS_PREREQUISITEFOR", type="string", length=255, nullable=true)
     */
    private $isPrerequisitefor;

    /**
     * @var integer
     *
     * @ORM\Column(name="SCHEME", type="integer", nullable=true)
     */
    private $scheme;

    /**
     * @var integer
     *
     * @ORM\Column(name="IS_CORE", type="smallint", nullable=true)
     */
    private $isCore;

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
     * @var \Application\Entity\Module
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Module")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_MODULEID", referencedColumnName="PK_MODULEID")
     * })
     */
    private $fkModuleid;

    /**
     * @var \Application\Entity\Academicyear
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Academicyear")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_ACADEMICPERIOD", referencedColumnName="PK_ACADEMICPERIODID")
     * })
     */
    private $fkAcademicperiod;

    /**
     * @var \Application\Entity\Classmodule
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Classmodule")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PARENTMODULE", referencedColumnName="PK_CLASSMODULEID")
     * })
     */
    private $parentmodule;



    /**
     * Get pkClassmoduleid
     *
     * @return integer
     */
    public function getPkClassmoduleid()
    {
        return $this->pkClassmoduleid;
    }

    /**
     * Set cwkweight
     *
     * @param integer $cwkweight
     *
     * @return Classmodule
     */
    public function setCwkweight($cwkweight)
    {
        $this->cwkweight = $cwkweight;

        return $this;
    }

    /**
     * Get cwkweight
     *
     * @return integer
     */
    public function getCwkweight()
    {
        return $this->cwkweight;
    }

    /**
     * Set exweight
     *
     * @param integer $exweight
     *
     * @return Classmodule
     */
    public function setExweight($exweight)
    {
        $this->exweight = $exweight;

        return $this;
    }

    /**
     * Get exweight
     *
     * @return integer
     */
    public function getExweight()
    {
        return $this->exweight;
    }

    /**
     * Set isProject
     *
     * @param boolean $isProject
     *
     * @return Classmodule
     */
    public function setIsProject($isProject)
    {
        $this->isProject = $isProject;

        return $this;
    }

    /**
     * Get isProject
     *
     * @return boolean
     */
    public function getIsProject()
    {
        return $this->isProject;
    }

    /**
     * Set isPrerequisitefor
     *
     * @param string $isPrerequisitefor
     *
     * @return Classmodule
     */
    public function setIsPrerequisitefor($isPrerequisitefor)
    {
        $this->isPrerequisitefor = $isPrerequisitefor;

        return $this;
    }

    /**
     * Get isPrerequisitefor
     *
     * @return string
     */
    public function getIsPrerequisitefor()
    {
        return $this->isPrerequisitefor;
    }

    /**
     * Set scheme
     *
     * @param integer $scheme
     *
     * @return Classmodule
     */
    public function setScheme($scheme)
    {
        $this->scheme = $scheme;

        return $this;
    }

    /**
     * Get scheme
     *
     * @return integer
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * Set isCore
     *
     * @param integer $isCore
     *
     * @return Classmodule
     */
    public function setIsCore($isCore)
    {
        $this->isCore = $isCore;

        return $this;
    }

    /**
     * Get isCore
     *
     * @return integer
     */
    public function getIsCore()
    {
        return $this->isCore;
    }

    /**
     * Set fkClassid
     *
     * @param \Application\Entity\Classes $fkClassid
     *
     * @return Classmodule
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
     * Set fkModuleid
     *
     * @param \Application\Entity\Module $fkModuleid
     *
     * @return Classmodule
     */
    public function setFkModuleid(\Application\Entity\Module $fkModuleid = null)
    {
        $this->fkModuleid = $fkModuleid;

        return $this;
    }

    /**
     * Get fkModuleid
     *
     * @return \Application\Entity\Module
     */
    public function getFkModuleid()
    {
        return $this->fkModuleid;
    }

    /**
     * Set fkAcademicperiod
     *
     * @param \Application\Entity\Academicyear $fkAcademicperiod
     *
     * @return Classmodule
     */
    public function setFkAcademicperiod(\Application\Entity\Academicyear $fkAcademicperiod = null)
    {
        $this->fkAcademicperiod = $fkAcademicperiod;

        return $this;
    }

    /**
     * Get fkAcademicperiod
     *
     * @return \Application\Entity\Academicyear
     */
    public function getFkAcademicperiod()
    {
        return $this->fkAcademicperiod;
    }

    /**
     * Set parentmodule
     *
     * @param \Application\Entity\Classmodule $parentmodule
     *
     * @return Classmodule
     */
    public function setParentmodule(\Application\Entity\Classmodule $parentmodule = null)
    {
        $this->parentmodule = $parentmodule;

        return $this;
    }

    /**
     * Get parentmodule
     *
     * @return \Application\Entity\Classmodule
     */
    public function getParentmodule()
    {
        return $this->parentmodule;
    }
}
