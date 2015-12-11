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
use Application\Entity\Staff;


class FsStaff extends Fieldset implements InputFilterProviderInterface
{
    protected $em;
    
    /*
     * Fetch list of departments
     */
    public function getDepartments(){
        $options = array();
        //Query departments
        $departments = $this->em->getRepository("\Application\Entity\Department")->findAll();
        
        foreach($departments as $department ){
            $options[$department->getPkDeptid()] = $department->getDeptName()." (".$department->getDeptCode().")";
        }
        
        return $options;
    }


    public function __construct(\Doctrine\ORM\EntityManager $em = null)
    {
        $this->em = $em;
        
        parent::__construct('Staff');
        
        
        
        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new Staff());
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'fkDeptid',
            'options' => array(
                'label' => 'Department:*',
                'value_options' => $this->getDepartments(),
                'empty_option'  => "--Select department--",
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                
            )
        ));
        
         $this->add(array(
            'name' => 'fkUserid',
            'type' => 'hidden'
        ));
         
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'workmode',
            'options' => array(
                'label' => 'Mode:*',
                'value_options' => array("FULLTIME"=>"Full time","PARTTIME"=>"Part time"),
                'empty_option'  => '--Select--'
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                
            )
        ));
        
        $this->add(array(
            'name' => 'pkStaffid',
            'type' => 'hidden'
        ));
        
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            'fkDeptid' => array(
                'required' => true
            ),
            'workmode' => array(
                'required' => true
            ),

        );
    }
}
