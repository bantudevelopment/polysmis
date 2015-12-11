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
use Application\Entity\Academicyear;


class FsAcademicperiod extends Fieldset implements InputFilterProviderInterface
{
    protected $em;
    protected $preferences;


    public function __construct(\Doctrine\ORM\EntityManager $em = null,$preferences=null)
    {
        $this->em = $em;
        $this->preferences = $preferences;
        
        parent::__construct('Academicyear');
        
        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new Academicyear());
        
        
        $this->add(array(
            'name' => 'pkAcademicperiodid',
            'type' => 'hidden'
        ));
        
        $this->add(array(
            'name' => 'parentid',
            'type' => 'hidden'
        ));
        
        $this->add(array(
            'name' => 'acyr',
            'options' => array(
                'label' => 'Title:*'
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                //'placeholder' => 'Username'
            )
        ));
        
        $this->add(array(
            'name' => 'startDate',
            'type' => 'date',
            'options' => array(
                'label' => 'Start date:*'
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                //'placeholder' => 'Username'
            )
        ));
        
         $this->add(array(
            'name' => 'endDate',
            'type' => 'date',
            'options' => array(
                'label' => 'End date:*'
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                //'placeholder' => 'Username'
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'category',
            'options' => array(
                'label' => 'Category:*',
                'value_options' => array("GENERIC"=>"GENERIC","SPECIAL"=>"SPECIAL"),
                'empty_option'=>'--Select category--',
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
            'category' => array(
                'required' => false
            ),
           'startDate' => array(
                'required' => true,
                'validators'=>array(
                            array(
                                'name' => 'Callback',
                                'options' => array(
                                        'messages' => array(
                                            \Zend\Validator\Callback::INVALID_VALUE => 'Period set is too short',
                                        ),
                                        'callback' => function($value, $context = array()) {
                                            $days = $this->preferences->dateDiff($value,$context['endDate']);
                                            return ( $days < 40 )?false:true;
                                        },
                                    ),
                                ),
                            array(
                                'name' => 'Callback',
                                'options' => array(
                                        'messages' => array(
                                            \Zend\Validator\Callback::INVALID_VALUE=> 'Academic periods overap'
                                        ),
                                        'callback' => function($value, $context = array()) {
                                            return ( count($this->preferences->IsWithin($context))>0 )?false:true;
                                        },
                                    ),
                                ),
                ),
            ),
            'endDate' => array(
                'required' => true
            ),
            'acyr' => array(
                'required' => true
            ),
        );
    }
}
