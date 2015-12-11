<?php

namespace DoctrineORMModule\Proxy\__CG__\Application\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Staff extends \Application\Entity\Staff implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array();



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return array('__isInitialized__', '' . "\0" . 'Application\\Entity\\Staff' . "\0" . 'pkStaffid', '' . "\0" . 'Application\\Entity\\Staff' . "\0" . 'workmode', '' . "\0" . 'Application\\Entity\\Staff' . "\0" . 'fkUserid', '' . "\0" . 'Application\\Entity\\Staff' . "\0" . 'fkDeptid');
        }

        return array('__isInitialized__', '' . "\0" . 'Application\\Entity\\Staff' . "\0" . 'pkStaffid', '' . "\0" . 'Application\\Entity\\Staff' . "\0" . 'workmode', '' . "\0" . 'Application\\Entity\\Staff' . "\0" . 'fkUserid', '' . "\0" . 'Application\\Entity\\Staff' . "\0" . 'fkDeptid');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Staff $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', array());
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', array());
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getPkStaffid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getPkStaffid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPkStaffid', array());

        return parent::getPkStaffid();
    }

    /**
     * {@inheritDoc}
     */
    public function setWorkmode($workmode)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setWorkmode', array($workmode));

        return parent::setWorkmode($workmode);
    }

    /**
     * {@inheritDoc}
     */
    public function getWorkmode()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getWorkmode', array());

        return parent::getWorkmode();
    }

    /**
     * {@inheritDoc}
     */
    public function setFkUserid(\Application\Entity\User $fkUserid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFkUserid', array($fkUserid));

        return parent::setFkUserid($fkUserid);
    }

    /**
     * {@inheritDoc}
     */
    public function getFkUserid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFkUserid', array());

        return parent::getFkUserid();
    }

    /**
     * {@inheritDoc}
     */
    public function setFkDeptid(\Application\Entity\Department $fkDeptid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFkDeptid', array($fkDeptid));

        return parent::setFkDeptid($fkDeptid);
    }

    /**
     * {@inheritDoc}
     */
    public function getFkDeptid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFkDeptid', array());

        return parent::getFkDeptid();
    }

}