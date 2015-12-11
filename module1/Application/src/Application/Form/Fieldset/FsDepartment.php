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
use Application\Entity\Department;


class FsDepartment extends Fieldset implements InputFilterProviderInterface
{
    protected $em;
    protected $deptid;


    /*
     * Fetch list of users
     */
    public function getStaff(){
        $options = array();
        if($this->deptid != NULL){
            $users = $this->em->getRepository("\Application\Entity\Staff")->findBy(array("fkDeptid"=>$this->deptid));

            foreach($users as $user ){
                $options[$user->getPkStaffid()] = $user->getFkUserid()->getFirstname()." ".$user->getFkUserid()->getSurname();
            }
        }
        
        return $options;
    }
    
    
    public function __construct(\Doctrine\ORM\EntityManager $em = null,$deptid = null)
    {
        $this->em = $em;
        $this->deptid = $deptid;
        
        parent::__construct('Department');
        
        
        
        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new Department());
        
        
        $this->add(array(
            'name' => 'deptCode',
            'options' => array(
                'label' => 'Code:* '
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                
            )
        ));
        
        $this->add(array(
            'name' => 'deptName',
            'options' => array(
                'label' => 'Name:* '
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                
                
            )
        ));
        
        $this->add(array(
            'name' => 'fkFacultyid',
            'type' => 'hidden'
        ));  
        
        $this->add(array(
            'name' => 'pkDeptid',
            'type' => 'hidden'
        ));  
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'fkStaffid',
            'options' => array(
                'label' => 'Head of department: ',
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
            'deptName' => array(
                'required' => true
            ),
            'deptCode' => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'DoctrineModule\Validator\UniqueObject',
                        'options' => array(
                            'use_context' => true,
                            'object_repository' => $this->em->getRepository('Application\Entity\Department'),
                            'fields' => 'deptCode',
                            'object_manager' => $this->em,
                            'message' => 'Department code already exists in the system'
                        )
                    )
                ) 
            ),
            'fkStaffid' => array(
                'required' => false
            ),
            
        );
    }
}
