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


class FsAssessment extends Fieldset implements InputFilterProviderInterface
{
    protected $em;
    
    /*
     * Fetch list of program group
     */
    public function getTypes(){
        
        $options[""] = "--Select--";
        //Query all users(Lecturers) not assigned to other departments
        $types = $this->em->getRepository("\Application\Entity\Assessmenttype")->findBy(array("systemGenerated"=>0));
        
        foreach($types as $type ){
            $options[$type->getPkAtid()] = $type->getTypeName();
        }
        
        return $options;
    }


    public function __construct(\Doctrine\ORM\EntityManager $em = null)
    {
        $this->em = $em;
        
        parent::__construct('Assessment');
        
        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new \Application\Entity\Assessmentitem());
        
        
        $this->add(array(
            'name' => 'assessmentTitle',
            'options' => array(
                'label' => 'Title:* '
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                
                
            )
        ));
        
        $this->add(array(
            'name' => 'fkStaffid',
            'type' => 'hidden',
            'options' => array(
                'label' => ' '
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'fkAtid',
            'options' => array(
                'label' => 'Assessment type:*',
                'value_options' => $this->getTypes()
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                
            )
        ));
         
         
         $this->add(array(
            'name' => 'fkCcid',
            'type' => 'hidden',
            'options' => array(
                'label' => ' '
            ),
        ));
         
        $this->add(array(
             'name'         => 'weighting',
             'type'         => 'Zend\Form\Element\Number',
             'attributes'   => array('class'=> 'form-control','id'=>'weighting','required' => 'required',),
	     'options'      => array('label' => 'Weighting(%):',),
         ));
         
         $this->add(array(
            'name' => 'pkAiid',
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
            'fkAtid' => array(
                'required' => true
            ),
            'assessmentTitle' => array(
                'required' => true
            ),

        );
    }
}
