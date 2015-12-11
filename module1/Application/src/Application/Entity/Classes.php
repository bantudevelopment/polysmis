<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classes
 *
 * @ORM\Table(name="classes", uniqueConstraints={@ORM\UniqueConstraint(name="CLASS_CODE_UNIQUE", columns={"CLASS_CODE"})}, indexes={@ORM\Index(name="programclass_idx", columns={"FK_PROGRAMID"})})
 * @ORM\Entity
 */
class Classes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="PK_CLASSID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pkClassid;

    /**
     * @var integer
     *
     * @ORM\Column(name="CLASS_YEAR", type="integer", nullable=false)
     */
    private $classYear = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="CLASS_NAME", type="string", length=100, nullable=false)
     */
    private $className = '';

    /**
     * @var string
     *
     * @ORM\Column(name="CLASS_CODE", type="string", length=45, nullable=false)
     */
    private $classCode;

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
     * Get pkClassid
     *
     * @return integer
     */
    public function getPkClassid()
    {
        return $this->pkClassid;
    }

    /**
     * Set classYear
     *
     * @param integer $classYear
     *
     * @return Classes
     */
    public function setClassYear($classYear)
    {
        $this->classYear = $classYear;

        return $this;
    }

    /**
     * Get classYear
     *
     * @return integer
     */
    public function getClassYear()
    {
        return $this->classYear;
    }

    /**
     * Set className
     *
     * @param string $className
     *
     * @return Classes
     */
    public function setClassName($className)
    {
        $this->className = $className;

        return $this;
    }

    /**
     * Get className
     *
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Set classCode
     *
     * @param string $classCode
     *
     * @return Classes
     */
    public function setClassCode($classCode)
    {
        $this->classCode = $classCode;

        return $this;
    }

    /**
     * Get classCode
     *
     * @return string
     */
    public function getClassCode()
    {
        return $this->classCode;
    }

    /**
     * Set fkProgramid
     *
     * @param \Application\Entity\Program $fkProgramid
     *
     * @return Classes
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
}
