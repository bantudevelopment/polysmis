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
use Application\Entity\Enrollment;


class FsEnrollment extends Fieldset implements InputFilterProviderInterface
{
    protected $em;
    
    /*
     * Fetch list of program group
     */
    public function getGroupList(){
        
        $grouplist[""] = "--Select--";
        
        $groups = $this->em->getRepository('\Application\Entity\Programgroup')->findAll();
        foreach($groups as $group ){
            $grouplist[$group->getPkGroupid()] = $group->getGroupCode();
        }
        
        return $grouplist;
    }
    
    /*
     * Fetch list of entry manner
     */
    public function getEntryMannerList(){
        
        $mannerlist[""] = "--Select--";
        $manners = $this->em->getRepository('\Application\Entity\Entrymanner')->findAll();
        foreach($manners as $manner ){
            $mannerlist[$manner->getPkEntrymannerid()] = $manner->getEntryName();
        }
        
        return $mannerlist;
    }
    
    /*
     * Fetch list of entry manner
     */
    public function getStudyMode(){
        
        $studymodelist[""] = "--Select--";
        $studymodes = $this->em->getRepository('\Application\Entity\Studymode')->findAll();
        foreach($studymodes as $studymode ){
            $studymodelist[$studymode->getPkStudymodeid()] = $studymode->getTitle();
        }
        
        return $studymodelist;
    }
    
    /*
     * Fetch list of academic periods
     */
    public function getAcademicPeriodList(){
        
        $periodlist[""] = "--Select--";
        $periods = $this->em->getRepository('\Application\Entity\Academicperiod')->findAll();
        foreach($periods as $period ){
            $periodlist[$period->getPkPeriodid()] = $period->getTitle();
        }
        
        return $periodlist;
    }
    


    public function __construct(\Doctrine\ORM\EntityManager $em = null)
    {
        
        parent::__construct('Enrollment');
        
        $this->em = $em;
        
        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new Enrollment());
        
        
        $this->add(array(
            'name' => 'pkEnrollmentid'
        ));
        
        $this->add(array(
             'name' => 'basicdetails',
             'type' => 'Application\Form\Fieldset\FsBasicUserDetails'
         ));
          
         $this->add(array(
            'type' => 'Date',
            'name' => 'dob',
            'options' => array(
                'label' => 'Date of birth:*',
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                
            )
        ));
        
        /*
         * Close common elements
         */
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'fkGroupid',
            'options' => array(
                'label' => 'Class/group:*',
                'value_options' => $this->getGroupList()
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'fkEntrymannerid',
            'options' => array(
                'label' => 'Entry manner:*',
                'value_options' => $this->getEntryMannerList()
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'fkPeriodid',
            'options' => array(
                'label' => 'Academic period:*',
                'value_options' => $this->getAcademicPeriodList()
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'fkStudymodeid',
            'options' => array(
                'label' => 'Study mode:*',
                'value_options' => $this->getStudyMode()
            ),
            'attributes' => array(
                'required' => 'required',
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
            'dob' => array(
                'required' => true
            ),
            'fkEntrymannerid' => array(
                'required' => true
            ),
            'fkPeriodid' => array(
                'required' => true
            ),
            'fkStudymodeid' => array(
                'required' => true
            ),
        );
    }
}
