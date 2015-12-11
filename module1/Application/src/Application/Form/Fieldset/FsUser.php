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
    
    /*
     * Fetch list of program group
     */
    public function getRoles(){
        
        $groups = $this->em->getRepository('\Application\Entity\Role')->findAll();
        foreach($groups as $group ){
            $role[$group->getPkRoleid()] = $group->getDescription();
        }
        
        return $role;
    }


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
            'type' => 'Zend\Form\Element\Select',
            'name' => 'fkRoleid',
            'options' => array(
                'label' => 'Role:*',
                'value_options' => $this->getRoles(),
                'empty_option'  => '--Select--'
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                
            )
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
            'type' =>'Zend\Form\Element\Password',
            'name' => 'password',
            'options' => array(
                'label' => 'Password:*'
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                //'placeholder' => 'Password'
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
                'class'    => 'form-control',
                //'placeholder' => 'Confirm password'
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
            'fkRoleid' => array(
                'required' => true
            ),
            'emailaddress' => array(
                'required' => false,
                'validators' => array(
                     array(
                        'name' => 'DoctrineModule\Validator\UniqueObject',
                        'options' => array(
                            'object_repository' => $this->em->getRepository('Application\Entity\User'),
                            'fields' => 'emailaddress',
                            'object_manager' => $this->em,
                        )
                    ),
                )
            ),
            'username' => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'DoctrineModule\Validator\UniqueObject',
                        'options' => array(
                            'object_repository' => $this->em->getRepository('Application\Entity\User'),
                            'fields' => 'username',
                            'object_manager' => $this->em,
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
            ),
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
