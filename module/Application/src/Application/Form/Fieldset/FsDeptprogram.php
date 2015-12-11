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


class FsDeptprogram extends Fieldset implements InputFilterProviderInterface
{
    protected $em;
    
    /*
     * Fetch list of program group
     */
    public function getPrograms(){
        
        $options[""] = "--Select--";
        //Query all users(Lecturers) not assigned to other departments
        $userquery = $this->em->createQuery(" SELECT p"
                                          . " FROM \Application\Entity\Program p "
                                          . " WHERE p.pkProgramid NOT IN( SELECT IDENTITY(s.fkProgramid) FROM \Application\Entity\Departmentprogram s )");
        
        foreach($userquery->getResult() as $user ){
            $options[$user->getPkProgramid()] = $user->getProgName();
        }
        
        return $options;
    }


    public function __construct(\Doctrine\ORM\EntityManager $em = null)
    {
        $this->em = $em;
        
        parent::__construct('Program');
        
        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new \Application\Entity\Departmentprogram());
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'fkProgramid',
            'options' => array(
                'label' => 'Program:*',
                'value_options' => $this->getPrograms()
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                
            )
        ));
        
         $this->add(array(
            'name' => 'fkDepartmentid',
            'type' => 'hidden',
            'options' => array(
                'label' => ' '
            ),
        ));
         
         $this->add(array(
            'name' => 'pkDpid',
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
            'fkDepartmentid' => array(
                'required' => true
            ),
            'fkProgramid' => array(
                'required' => true
            ),

        );
    }
}
