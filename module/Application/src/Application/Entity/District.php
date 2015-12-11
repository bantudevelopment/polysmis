<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * District
 *
 * @ORM\Table(name="district")
 * @ORM\Entity
 */
class District
{
    /**
     * @var integer
     *
     * @ORM\Column(name="PK_DISTRICTID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pkDistrictid;

    /**
     * @var string
     *
     * @ORM\Column(name="DISTRICT_NAME", type="string", length=50, nullable=false)
     */
    private $districtName;



    /**
     * Get pkDistrictid
     *
     * @return integer
     */
    public function getPkDistrictid()
    {
        return $this->pkDistrictid;
    }

    /**
     * Set districtName
     *
     * @param string $districtName
     *
     * @return District
     */
    public function setDistrictName($districtName)
    {
        $this->districtName = $districtName;

        return $this;
    }

    /**
     * Get districtName
     *
     * @return string
     */
    public function getDistrictName()
    {
        return $this->districtName;
    }
}
