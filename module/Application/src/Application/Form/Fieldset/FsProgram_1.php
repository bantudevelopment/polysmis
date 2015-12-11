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
use Application\Entity\Program;


class FsProgram extends Fieldset implements InputFilterProviderInterface
{
    protected $em;
    
     /*
     * Fetch list of programs
     */
    public function getSchools(){
        
        $options[""] = "--Select--";
        
        $objects = $this->em->getRepository('\Application\Entity\School')->findAll();
        foreach($objects as $object ){
            $options[$object->getPkSchoolid()] = $object->getSchoolName();
        }
        
        return $options;
    }
    
    /*
     * Fetch list of programs categories
     */
    public function getCategory(){
        
        $options[""] = "--Select--";
        
        $objects = $this->em->getRepository('\Application\Entity\Programcategory')->findAll();
        foreach($objects as $object ){
            $options[$object->getPkProgramcategoryid()] = $object->getCategoryName();
        }
        
        return $options;
    }
    
    
    public function __construct(\Doctrine\ORM\EntityManager $em = null)
    {
        $this->em = $em;
        
        parent::__construct('Program');
        
        
        
        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new Program());
        
        
        $this->add(array(
            'name' => 'progCode',
            'options' => array(
                'label' => 'Code:* '
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                
            )
        ), array('priority' => 1000));
        
        $this->add(array(
            'name' => 'progName',
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
            'name' => 'fkSchoolid',
            'options' => array(
                'label' => 'School:* ',
                'value_options' => $this->getSchools()
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                
                
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'fkProgramcategoryid',
            'options' => array(
                'label' => 'Category:* ',
                'value_options' => $this->getCategory()
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                
                
            )
        ));
        
        
        $this->add(array(
            'name' => 'pkProgramid',
            'type' => 'hidden',
            'options' => array(
                'label' => ' '
            ),
        ));  
        
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            'progName' => array(
                'required' => true
            ),
            'fkProgramcategoryid' => array(
                'required' => true
            ),
            'fkSchoolid' => array(
                'required' => true
            ),
            'progCode' => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'DoctrineModule\Validator\UniqueObject',
                        'options' => array(
                            'use_context' => true,
                            'object_repository' => $this->em->getRepository('Application\Entity\Program'),
                            'fields' => 'progCode',
                            'object_manager' => $this->em,
                            'message' => 'Program code already exists in the system'
                        )
                    )
                ) 
            )
            
            
            
        );
    }
}
