<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Studentmodule
 *
 * @ORM\Table(name="studentmodule", indexes={@ORM\Index(name="fk_studentmodule_idx", columns={"FK_STUDENTID"}), @ORM\Index(name="fk_studentclassmodule_idx", columns={"FK_CLASSMODULEID"})})
 * @ORM\Entity
 */
class Studentmodule
{
    /**
     * @var integer
     *
     * @ORM\Column(name="PK_STUDENTMODULE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pkStudentmodule;

    /**
     * @var string
     *
     * @ORM\Column(name="STUDYMODE", type="text", nullable=true)
     */
    private $studymode = 'AUDIT';

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
     * @var \Application\Entity\Student
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Student")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FK_STUDENTID", referencedColumnName="PK_STUDENTID")
     * })
     */
    private $fkStudentid;



    /**
     * Get pkStudentmodule
     *
     * @return integer
     */
    public function getPkStudentmodule()
    {
        return $this->pkStudentmodule;
    }

    /**
     * Set studymode
     *
     * @param string $studymode
     *
     * @return Studentmodule
     */
    public function setStudymode($studymode)
    {
        $this->studymode = $studymode;

        return $this;
    }

    /**
     * Get studymode
     *
     * @return string
     */
    public function getStudymode()
    {
        return $this->studymode;
    }

    /**
     * Set fkClassmoduleid
     *
     * @param \Application\Entity\Classmodule $fkClassmoduleid
     *
     * @return Studentmodule
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

    /**
     * Set fkStudentid
     *
     * @param \Application\Entity\Student $fkStudentid
     *
     * @return Studentmodule
     */
    public function setFkStudentid(\Application\Entity\Student $fkStudentid = null)
    {
        $this->fkStudentid = $fkStudentid;

        return $this;
    }

    /**
     * Get fkStudentid
     *
     * @return \Application\Entity\Student
     */
    public function getFkStudentid()
    {
        return $this->fkStudentid;
    }
}
