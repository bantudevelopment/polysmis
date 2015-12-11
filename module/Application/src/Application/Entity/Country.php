<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 *
 * @ORM\Table(name="country", uniqueConstraints={@ORM\UniqueConstraint(name="COUNTRY_NAME_UNIQUE", columns={"COUNTRY_NAME"}), @ORM\UniqueConstraint(name="COUNTRY_CODE_UNIQUE", columns={"COUNTRY_CODE"}), @ORM\UniqueConstraint(name="NATIONALITY_UNIQUE", columns={"NATIONALITY"})})
 * @ORM\Entity
 */
class Country
{
    /**
     * @var integer
     *
     * @ORM\Column(name="PK_COUNTRYID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pkCountryid;

    /**
     * @var string
     *
     * @ORM\Column(name="COUNTRY_NAME", type="string", length=45, nullable=true)
     */
    private $countryName;

    /**
     * @var string
     *
     * @ORM\Column(name="COUNTRY_CODE", type="string", length=10, nullable=true)
     */
    private $countryCode;

    /**
     * @var string
     *
     * @ORM\Column(name="NATIONALITY", type="string", length=50, nullable=true)
     */
    private $nationality;



    /**
     * Get pkCountryid
     *
     * @return integer
     */
    public function getPkCountryid()
    {
        return $this->pkCountryid;
    }

    /**
     * Set countryName
     *
     * @param string $countryName
     *
     * @return Country
     */
    public function setCountryName($countryName)
    {
        $this->countryName = $countryName;

        return $this;
    }

    /**
     * Get countryName
     *
     * @return string
     */
    public function getCountryName()
    {
        return $this->countryName;
    }

    /**
     * Set countryCode
     *
     * @param string $countryCode
     *
     * @return Country
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * Get countryCode
     *
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * Set nationality
     *
     * @param string $nationality
     *
     * @return Country
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * Get nationality
     *
     * @return string
     */
    public function getNationality()
    {
        return $this->nationality;
    }
}
