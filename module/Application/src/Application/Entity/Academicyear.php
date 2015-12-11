<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Academicyear
 *
 * @ORM\Table(name="academicyear", uniqueConstraints={@ORM\UniqueConstraint(name="ACYR_UNIQUE", columns={"ACYR"})}, indexes={@ORM\Index(name="PARENTPERIOD_idx", columns={"PARENTID"})})
 * @ORM\Entity
 */
class Academicyear
{
    /**
     * @var integer
     *
     * @ORM\Column(name="PK_ACADEMICPERIODID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pkAcademicperiodid;

    /**
     * @var string
     *
     * @ORM\Column(name="ACYR", type="string", length=15, nullable=false)
     */
    private $acyr = '';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="START_DATE", type="date", nullable=false)
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="END_DATE", type="date", nullable=false)
     */
    private $endDate;

    /**
     * @var string
     *
     * @ORM\Column(name="CATEGORY", type="text", nullable=true)
     */
    private $category = 'GENERIC';

    /**
     * @var \Application\Entity\Academicyear
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Academicyear")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PARENTID", referencedColumnName="PK_ACADEMICPERIODID")
     * })
     */
    private $parentid;



    /**
     * Get pkAcademicperiodid
     *
     * @return integer
     */
    public function getPkAcademicperiodid()
    {
        return $this->pkAcademicperiodid;
    }

    /**
     * Set acyr
     *
     * @param string $acyr
     *
     * @return Academicyear
     */
    public function setAcyr($acyr)
    {
        $this->acyr = $acyr;

        return $this;
    }

    /**
     * Get acyr
     *
     * @return string
     */
    public function getAcyr()
    {
        return $this->acyr;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Academicyear
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return Academicyear
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return Academicyear
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set parentid
     *
     * @param \Application\Entity\Academicyear $parentid
     *
     * @return Academicyear
     */
    public function setParentid(\Application\Entity\Academicyear $parentid = null)
    {
        $this->parentid = $parentid;

        return $this;
    }

    /**
     * Get parentid
     *
     * @return \Application\Entity\Academicyear
     */
    public function getParentid()
    {
        return $this->parentid;
    }
}
