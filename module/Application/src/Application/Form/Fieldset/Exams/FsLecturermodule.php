<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Form\Fieldset\Exams;

/**
 * Description of Login fieldset
 *
 * @author hkumwembe
 */

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
use Application\Entity\Lecturermodule;


class FsLecturermodule extends Fieldset implements InputFilterProviderInterface
{
    protected $em;
    protected $deptid;


    /*
     * Fetch list of staff
     */
    public function getStaff(){
        $options = array("-1"=>"Request other departments");
        if($this->deptid != NULL){
            $users = $this->em->getRepository("\Application\Entity\Staff")->findBy(array("fkDeptid"=>$this->deptid));

            foreach($users as $user ){
                $options[$user->getPkStaffid()] = sprintf("%s %s",$user->getFkUserid()->getFirstname(),$user->getFkUserid()->getSurname());
            }
        }
        
        return $options;
    }
    
    
    public function __construct(\Doctrine\ORM\EntityManager $em = null,$deptid = null)
    {
        $this->em = $em;
        $this->deptid = $deptid;
        
        parent::__construct('Lecturermodule');
        
        
        
        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new Lecturermodule());
       
        
        $this->add(array(
            'name' => 'fkClassmoduleid',
            'type' => 'hidden'
        ));  
        
        $this->add(array(
            'name' => 'pkLmid',
            'type' => 'hidden'
        ));  
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'fkStaffid',
            'options' => array(
                'label' => 'Lecturer: ',
                'value_options' => $this->getStaff(),
                'empty_option'  => "--Select--",
                
            ),
            'attributes' => array(
                'class'    => 'form-control',
                'id'       => 'fkStaffid',
                'required' => 'required',
                
            )
        ));  
        
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            'fkStaffid' => array(
                'required' => true
            ),
            
        );
    }
}
