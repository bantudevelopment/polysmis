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


class FsUser extends Fieldset implements InputFilterProviderInterface
{
    protected $em;
    public function __construct(\Doctrine\ORM\EntityManager $em = null)
    {
        $this->em = $em;
        
        parent::__construct('User');
        
        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new User());
        
        
        $this->add(array(
            'name' => 'pkUserid',
            'type' => 'hidden'
        ));
        
        $this->add(array(
             'name' => 'basicdetails',
             'type' => 'Application\Form\Fieldset\FsBasicUserDetails'
         ));
        
        $this->add(array(
            'name' => 'username',
            'options' => array(
                'label' => 'Username:*'
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                //'placeholder' => 'Username'
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Email',
            'name' => 'emailaddress',
            'options' => array(
                'label' => 'Email address:*'
            ),
            'attributes' => array(
                'class'    => 'form-control',
                
            )
        )); 
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            'emailaddress' => array(
                'required' => false,
                'validators' => array(
                    
                    array(
                        'name' => 'DoctrineModule\Validator\UniqueObject',
                        'options' => array(
                            'use_context' => true,
                            'object_repository' => $this->em->getRepository('Application\Entity\User'),
                            'fields' => 'emailaddress',
                            'object_manager' => $this->em,
                            'message' => 'Email address already exists in the system'
                        )
                    )
                )
            ),
            'username' => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'DoctrineModule\Validator\UniqueObject',
                        'options' => array(
                            'use_context' => true,
                            'object_repository' => $this->em->getRepository('Application\Entity\User'),
                            'fields' => 'username',
                            'object_manager' => $this->em,
                            'message' => 'Username already exists in the system'
                        )
                    ),
                    array(
                                    'name' => 'StringLength',
                                    'options' => array(
                                            'min' => 6,
                                            'max' => 20
                                        ),
                                    )
                        )
            )
            );
    }
    
}