<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Settings
 *
 * @ORM\Table(name="settings")
 * @ORM\Entity
 */
class Settings
{
    /**
     * @var integer
     *
     * @ORM\Column(name="PK_SETTINGS", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pkSettings;

    /**
     * @var integer
     *
     * @ORM\Column(name="PASSWORDEXPIREYDAYS", type="integer", nullable=false)
     */
    private $passwordexpireydays;

    /**
     * @var integer
     *
     * @ORM\Column(name="PASSWORDLENGTH", type="integer", nullable=false)
     */
    private $passwordlength;



    /**
     * Get pkSettings
     *
     * @return integer
     */
    public function getPkSettings()
    {
        return $this->pkSettings;
    }

    /**
     * Set passwordexpireydays
     *
     * @param integer $passwordexpireydays
     *
     * @return Settings
     */
    public function setPasswordexpireydays($passwordexpireydays)
    {
        $this->passwordexpireydays = $passwordexpireydays;

        return $this;
    }

    /**
     * Get passwordexpireydays
     *
     * @return integer
     */
    public function getPasswordexpireydays()
    {
        return $this->passwordexpireydays;
    }

    /**
     * Set passwordlength
     *
     * @param integer $passwordlength
     *
     * @return Settings
     */
    public function setPasswordlength($passwordlength)
    {
        $this->passwordlength = $passwordlength;

        return $this;
    }

    /**
     * Get passwordlength
     *
     * @return integer
     */
    public function getPasswordlength()
    {
        return $this->passwordlength;
    }
}
