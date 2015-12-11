<?php

namespace Authorization\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Privilege
 *
 * @ORM\Table(name="privilege")
 * @ORM\Entity
 */
class Privilege
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, precision=0, scale=0, nullable=true, unique=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="permission_allow", type="boolean", precision=0, scale=0, nullable=false, unique=false)
     */
    private $permissionAllow;

    /**
     * @var \CsnAuthorization\Entity\Resource
     *
     * @ORM\ManyToOne(targetEntity="CsnAuthorization\Entity\Resource")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="resource_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $resource;

    /**
     * @var \CsnUser\Entity\Role
     *
     * @ORM\ManyToOne(targetEntity="CsnUser\Entity\Role")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="role_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $role;


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Privilege
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set permissionAllow
     *
     * @param boolean $permissionAllow
     *
     * @return Privilege
     */
    public function setPermissionAllow($permissionAllow)
    {
        $this->permissionAllow = $permissionAllow;

        return $this;
    }

    /**
     * Get permissionAllow
     *
     * @return boolean
     */
    public function getPermissionAllow()
    {
        return $this->permissionAllow;
    }

    /**
     * Set resource
     *
     * @param \CsnAuthorization\Entity\Resource $resource
     *
     * @return Privilege
     */
    public function setResource(\CsnAuthorization\Entity\Resource $resource = null)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get resource
     *
     * @return \CsnAuthorization\Entity\Resource
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Set role
     *
     * @param \CsnUser\Entity\Role $role
     *
     * @return Privilege
     */
    public function setRole(\CsnUser\Entity\Role $role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \CsnUser\Entity\Role
     */
    public function getRole()
    {
        return $this->role;
    }
}
