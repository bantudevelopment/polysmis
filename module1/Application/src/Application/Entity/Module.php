<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Module
 *
 * @ORM\Table(name="module", uniqueConstraints={@ORM\UniqueConstraint(name="COURSE_CODE_UNIQUE", columns={"MODULE_CODE"})})
 * @ORM\Entity
 */
class Module
{
    /**
     * @var integer
     *
     * @ORM\Column(name="PK_MODULEID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pkModuleid;

    /**
     * @var string
     *
     * @ORM\Column(name="MODULE_CODE", type="string", length=15, nullable=false)
     */
    private $moduleCode;

    /**
     * @var string
     *
     * @ORM\Column(name="MODULE_NAME", type="string", length=100, nullable=false)
     */
    private $moduleName;



    /**
     * Get pkModuleid
     *
     * @return integer
     */
    public function getPkModuleid()
    {
        return $this->pkModuleid;
    }

    /**
     * Set moduleCode
     *
     * @param string $moduleCode
     *
     * @return Module
     */
    public function setModuleCode($moduleCode)
    {
        $this->moduleCode = $moduleCode;

        return $this;
    }

    /**
     * Get moduleCode
     *
     * @return string
     */
    public function getModuleCode()
    {
        return $this->moduleCode;
    }

    /**
     * Set moduleName
     *
     * @param string $moduleName
     *
     * @return Module
     */
    public function setModuleName($moduleName)
    {
        $this->moduleName = $moduleName;

        return $this;
    }

    /**
     * Get moduleName
     *
     * @return string
     */
    public function getModuleName()
    {
        return $this->moduleName;
    }
}
