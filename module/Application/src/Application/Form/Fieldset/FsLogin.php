<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Form\Fieldset;

/**
 * Description of Login fieldset
 *
 * @author hkumwembe
 */

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
use Application\Entity\User;


class FsLogin extends Fieldset implements InputFilterProviderInterface
{
    protected $em;
    public function __construct()
    {
        parent::__construct('Login');
        
        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new User());
        
        $this->add(array(
            'name' => 'pkUserid'
        ));
        
        $this->add(array(
            'name' => 'username',
            'options' => array(
                'label' => 'Username:*'
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control input-lg',
                'placeholder' => 'Username'
            )
        ));

        $this->add(array(
            'type' =>'Zend\Form\Element\Password',
            'name' => 'password',
            'options' => array(
                'label' => 'Password:*'
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control input-lg',
                'placeholder' => 'Password'
            )
        ));
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            'username' => array(
                'required' => true
            ),
            'password' => array(
                'required' => true
            )
        );
    }
}
