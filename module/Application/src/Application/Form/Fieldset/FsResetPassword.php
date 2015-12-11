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


class FsResetpassword extends Fieldset implements InputFilterProviderInterface
{
    protected $em;
    
    public function __construct(\Doctrine\ORM\EntityManager $em = null)
    {
        $this->em = $em;
        
        parent::__construct('Password');
        
        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new User());
        
        
        $this->add(array(
            'name' => 'pkUserid'
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
                'placeholder' => 'New password'
            )
        ));
        
        $this->add(array(
            'type' =>'Zend\Form\Element\Password',
            'name' => 'cpassword',
            'options' => array(
                'label' => 'Confirm password:*'
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control input-lg',
                'placeholder' => 'Confirm password'
            )
        ));
        
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
           
            'password' => array(
                'required' => true,
                'validators' => array(
                                    array(
                                    'name' => 'Callback',
                                    'options' => array(
                                            'messages' => array(
                                                \Zend\Validator\Callback::INVALID_VALUE => 'Passwords do not match',
                                            ),
                                            'callback' => function($value, $context = array()) {
                                                return ($context['cpassword'] != $value)?false:true;
                                            },
                                        ),
                                    ),
                                    array(
                                    'name' => 'StringLength',
                                    'options' => array(
                                            'min' => 6,
                                            'max' => 30
                                        ),
                                    )
                 ),
            ),
            
            
            
        );
    }
}
