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
use Application\Entity\Classmodule;


class FsClassmodule extends Fieldset implements InputFilterProviderInterface
{
    protected $em;
    protected $classid;
    protected $academicperiodid;

    /*
     * Fetch available list
     */
    public function getAvailableModules(){
        $options = array();
        $modulequery  = $this->em->createQuery("SELECT M FROM \Application\Entity\Module M"
                                             . " WHERE M.pkModuleid NOT IN( SELECT IDENTITY(C.fkModuleid) FROM "
                                             . " \Application\Entity\Classmodule C JOIN C.fkAcademicperiod A WHERE C.fkClassid = :classid "
                                             . " AND A.parentid = :parentid ) ")
                             ->setParameter('classid', $this->classid)
                             ->setParameter('parentid', $this->academicperiodid);
        foreach($modulequery->getResult() as $module ){
            $options[$module->getPkModuleid()] = $module->getModuleName()." (".$module->getModuleCode().")";
        }
        
        return $options;
    }
    
     /*
     * Fetch semester
     */
    public function getSemesters(){

        $query  = $this->em->getRepository("\Application\Entity\Academicyear")->findBy(array("parentid"=>$this->academicperiodid));
        foreach($query as $semester ){
            $options[$semester->getPkAcademicperiodid()] = $semester->getAcyr();
        }
        
        return $options;
    }
    
    
    
     public function __construct($academicperiodid,\Doctrine\ORM\EntityManager $em = null,$classid = null,$classmodule=null)
    {
        $this->em = $em;
        $this->classid = $classid;
        $this->academicperiodid = $academicperiodid;
        
        parent::__construct('Classmodule');

        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new Classmodule());
        
            if($classmodule == NULL){
                $this->add(array(
                     'name'         => 'fkModuleid',
                     'type' => 'Zend\Form\Element\Select',
                     'attributes'   => array('class'=> 'form-control','id'=>'fkModuleid'),
                      'options' => array(
                        'label' => 'Module:*',
                        'value_options' => $this->getAvailableModules(),
                        'empty_option'   => "--Select module--"
                      )
                 )); 
            }else{
                $this->add(array(
                     'name'         => 'fkModuleid',
                     'type'         => 'Hidden'
                 )); 
            }
         /*
         * Configure examweight field to form
         */	 
         $this->add(array(
             'name'         => 'exweight',
             'type'         => 'Zend\Form\Element\Number',
             'attributes'   => array('class'=> 'form-control','id'=>'exweight'),
	     'options'      => array('label' => 'Exam weight*:',),
         ));
         
        
        /*
         * Configure id field to form
         */	 
         $this->add(array(
             'name'         => 'pkClassmoduleid',
             'type'         => 'hidden',
             
         )); 
        
        /*
         * Configure academic period
         */	 
         $this->add(array(
             'name'         => 'fkAcademicperiod',
             'type' => 'Zend\Form\Element\Select',
             'attributes'   => array('class'=> 'form-control','id'=>'fkAcademicperiod'),
              'options' => array(
                'label' => 'Semester:*',
                'value_options' => $this->getSemesters(),
                  'empty_option'   => "--Select semester--"
              )
         ));
         
         
	/*
         * Configure examweight field to form
         */	 
         $this->add(array(
             'name'         => 'cwkweight',
             'type'         => 'Zend\Form\Element\Number',
             'attributes'   => array('class'=> 'form-control','id'=>'cwkweight'),
	     'options'      => array('label' => 'Course work weight:*',),
         )); 
         
         $this->add(array(
             'name'         => 'fkClassid',
             'type'         => 'hidden'
         ));
         
        $this->add(array(
            'type' => 'Zend\Form\Element\Radio',
            'name' => 'isCore',
            'options' => array(
                'label' => 'Is core:*',
                'value_options' => array("1"=>"Yes","0"=>"No")
            ),
            
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Radio',
            'name' => 'isProject',
            'options' => array(
                'label' => 'Is project:*',
                'value_options' => array("1"=>"Yes","0"=>"No")
            ),
        ));
         
         
         
        
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            'fkModuleid' => array(
                'required' => true
            ),
            'exweight' => array(
                'required' => true,
                
            ),
            'cwkweight' => array(
                'required' => true,
                
            ),
            'fkAcademicperiod' => array(
                'required' => true
            ),
             'isCore' => array(
                'required' => true
            ),
             'isProject' => array(
                'required' => true
            ),
            
        );
    }
}
