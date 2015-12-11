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
     * Fetch list of programs categories
     */
    public function getAwards(){
        
        $options = array();
        
        $objects = $this->em->getRepository('\Application\Entity\Award')->findAll();
        foreach($objects as $object ){
            $options[$object->getPkAwardid()] = $object->getAward();
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
            'name' => 'programCode',
            'options' => array(
                'label' => 'Code:* '
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                
            )
        ));
        
        $this->add(array(
            'name' => 'duration',
            'type' => 'Number',
            'options' => array(
                'label' => 'Duration:* '
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                
                
            )
        ));
        
        $this->add(array(
            'name' => 'programName',
            'options' => array(
                'label' => 'Name:* '
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                
                
            )
        ));
        
        $this->add(array(
            'name' => 'programLongName',
            'options' => array(
                'label' => 'Long name: '
            ),
            'attributes' => array(
                'class'    => 'form-control',
                
                
            )
        ));
        
        $this->add(array(
            'type' => 'hidden',
            'name' => 'fkDeptid'
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'fkAwardid',
            'options' => array(
                'label' => 'Award:* ',
                'value_options' => $this->getAwards(),
                'empty_option'  => '--Select--'
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
            'programName' => array(
                'required' => true
            ),
            'programLongName' => array(
                'required' => false
            ),
            'fkAwardid' => array(
                'required' => true
            ),
            'fkDeptid' => array(
                'required' => true
            ),
            'programCode' => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'DoctrineModule\Validator\UniqueObject',
                        'options' => array(
                            'use_context' => true,
                            'object_repository' => $this->em->getRepository('Application\Entity\Program'),
                            'fields' => 'programCode',
                            'object_manager' => $this->em,
                            'message' => 'Program code already exists in the system'
                        )
                    )
                ) 
            )
            
            
            
        );
    }
}
