<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Form\Fieldset;

/**
 * Description of FsFaculty fieldset
 *
 * @author hkumwembe
 */

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;


class FsFaculty extends Fieldset implements InputFilterProviderInterface
{
    protected $em;
    
    /*
     * Fetch list of users
     */
    public function getStaff(){
        $options = array();
        $users = $this->em->getRepository("\Application\Entity\Staff")->findAll();
        
        foreach($users as $user ){
            $options[$user->getPkStaffid()] = $user->getFkUserid()->getFirstname()." ".$user->getFkUserid()->getSurname();
        }
        
        return $options;
    }
    
    
    public function __construct(\Doctrine\ORM\EntityManager $em = null)
    {
        $this->em = $em;
        
        parent::__construct('Faculty');
        
        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new \Application\Entity\Faculty());
        
        $this->add(array(
            'name' => 'pkFacultyid',
            'type' => 'hidden',
        )); 
        
       $this->add(array(
            'name' => 'facultyCode',
            'options' => array(
                'label' => 'Code:* '
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                
            )
        ));
        
        $this->add(array(
            'name' => 'facultyName',
            'options' => array(
                'label' => 'Name:* '
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                
                
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'fkStaffid',
            'options' => array(
                'label' => 'Dean: ',
                'value_options' => $this->getStaff(),
                'empty_option'  => "--Select--"
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
            
            'facultyCode' => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'DoctrineModule\Validator\UniqueObject',
                        'options' => array(
                            'use_context' => true,
                            'object_repository' => $this->em->getRepository('Application\Entity\Faculty'),
                            'fields' => 'facultyCode',
                            'object_manager' => $this->em,
                            'message' => 'Faculty code already exists in the system'
                        )
                    )
                ) 
            ),
            'facultyName' => array(
                'required' => true
            ),
            'fkStaffid' => array(
                'required' => false
            ),

        );
    }
}
