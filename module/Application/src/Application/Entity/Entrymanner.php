<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entrymanner
 *
 * @ORM\Table(name="entrymanner", uniqueConstraints={@ORM\UniqueConstraint(name="ENTRY_CODE_UNIQUE", columns={"ENTRY_CODE"})})
 * @ORM\Entity
 */
class Entrymanner
{
    /**
     * @var integer
     *
     * @ORM\Column(name="PK_ENTRYMANNERID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pkEntrymannerid;

    /**
     * @var string
     *
     * @ORM\Column(name="ENTRY_CODE", type="string", length=10, nullable=false)
     */
    private $entryCode;

    /**
     * @var string
     *
     * @ORM\Column(name="ENTRY_NAME", type="string", length=45, nullable=false)
     */
    private $entryName;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRIPTION", type="string", length=150, nullable=true)
     */
    private $description;



    /**
     * Get pkEntrymannerid
     *
     * @return integer
     */
    public function getPkEntrymannerid()
    {
        return $this->pkEntrymannerid;
    }

    /**
     * Set entryCode
     *
     * @param string $entryCode
     *
     * @return Entrymanner
     */
    public function setEntryCode($entryCode)
    {
        $this->entryCode = $entryCode;

        return $this;
    }

    /**
     * Get entryCode
     *
     * @return string
     */
    public function getEntryCode()
    {
        return $this->entryCode;
    }

    /**
     * Set entryName
     *
     * @param string $entryName
     *
     * @return Entrymanner
     */
    public function setEntryName($entryName)
    {
        $this->entryName = $entryName;

        return $this;
    }

    /**
     * Get entryName
     *
     * @return string
     */
    public function getEntryName()
    {
        return $this->entryName;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Entrymanner
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
