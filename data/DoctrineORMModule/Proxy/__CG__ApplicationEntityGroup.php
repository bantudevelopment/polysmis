<?php

namespace DoctrineORMModule\Proxy\__CG__\Application\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Group extends \Application\Entity\Group implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', '' . "\0" . 'Application\\Entity\\Group' . "\0" . 'pkGroupid', '' . "\0" . 'Application\\Entity\\Group' . "\0" . 'groupCode', '' . "\0" . 'Application\\Entity\\Group' . "\0" . 'groupName', '' . "\0" . 'Application\\Entity\\Group' . "\0" . 'level', '' . "\0" . 'Application\\Entity\\Group' . "\0" . 'fkProgramid');
        }

        return array('__isInitialized__', '' . "\0" . 'Application\\Entity\\Group' . "\0" . 'pkGroupid', '' . "\0" . 'Application\\Entity\\Group' . "\0" . 'groupCode', '' . "\0" . 'Application\\Entity\\Group' . "\0" . 'groupName', '' . "\0" . 'Application\\Entity\\Group' . "\0" . 'level', '' . "\0" . 'Application\\Entity\\Group' . "\0" . 'fkProgramid');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Group $proxy) {
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
    public function getPkGroupid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getPkGroupid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPkGroupid', array());

        return parent::getPkGroupid();
    }

    /**
     * {@inheritDoc}
     */
    public function setGroupCode($groupCode)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setGroupCode', array($groupCode));

        return parent::setGroupCode($groupCode);
    }

    /**
     * {@inheritDoc}
     */
    public function getGroupCode()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getGroupCode', array());

        return parent::getGroupCode();
    }

    /**
     * {@inheritDoc}
     */
    public function setGroupName($groupName)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setGroupName', array($groupName));

        return parent::setGroupName($groupName);
    }

    /**
     * {@inheritDoc}
     */
    public function getGroupName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getGroupName', array());

        return parent::getGroupName();
    }

    /**
     * {@inheritDoc}
     */
    public function setLevel($level)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLevel', array($level));

        return parent::setLevel($level);
    }

    /**
     * {@inheritDoc}
     */
    public function getLevel()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLevel', array());

        return parent::getLevel();
    }

    /**
     * {@inheritDoc}
     */
    public function setFkProgramid(\Application\Entity\Program $fkProgramid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFkProgramid', array($fkProgramid));

        return parent::setFkProgramid($fkProgramid);
    }

    /**
     * {@inheritDoc}
     */
    public function getFkProgramid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFkProgramid', array());

        return parent::getFkProgramid();
    }

}
