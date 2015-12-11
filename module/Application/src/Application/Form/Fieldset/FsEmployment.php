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
use Application\Entity\Employment;


class FsEmployment extends Fieldset implements InputFilterProviderInterface
{
    protected $em;
    
    public function __construct(\Doctrine\ORM\EntityManager $em = null)
    {
        $this->em = $em;
        
        parent::__construct('Employment');
        
        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new Employment());
        
        
        $this->add(array(
            'name' => 'pkEmploymentid',
            'type' => 'hidden',
            'options' => array(
                'label' => ' '
            ),
        ));
        
        $this->add(array(
            'name' => 'fkStudentid',
            'type' => 'hidden',
            'options' => array(
                'label' => ' '
            ),
        ));
        
        $this->add(array(
            'name' => 'designation',
            'type' => 'text',
            'options' => array(
                'label' => 'Designation:'
            ),
            'attributes' => array(
                //'required' => 'required',
                'class'    => 'form-control',
                //'placeholder' => 'Username'
            )
        ));
        
        $this->add(array(
            'name' => 'organization',
            'type' => 'text',
            'options' => array(
                'label' => 'Organization/company:'
            ),
            'attributes' => array(
                //'required' => 'required',
                'class'    => 'form-control',
                //'placeholder' => 'Username'
            )
        ));
        
        $this->add(array(
            'name' => 'startYear',
            'type' => 'Number',
            'options' => array(
                'label' => 'Start year:'
            ),
            'attributes' => array(
                //'required' => 'required',
                'class'    => 'form-control',
                //'placeholder' => 'Username'
                //'min' => '1950',
//                'max' => date('Y'),
//                'step' => '1', // months; default step interval is 1 month
            )
        ));
        
        $this->add(array(
            'name' => 'endYear',
            'type' => 'Number',
            'options' => array(
                'label' => 'End year:'
            ),
            'attributes' => array(
                //'min' => '1950',
                'max' => date('Y'),
                //'required' => 'required',
                'class'    => 'form-control',
                //'placeholder' => 'Username'
//                'min' => '1950',
//                'max' => date('Y'),
//                'step' => '1', // months; default step interval is 1 month
            )
        ));
        
         $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'isCurrent',
            'options' => array(
                'label' => 'Is current:',
                'checked_value' => '1',
                'unchecked_value' => '0'
            )
        ));
       
              
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
//            'startYear' => array(
//                'validators' => array(
//                                    array(
//                                    'name' => 'Callback',
//                                    'options' => array(
//                                            'messages' => array(
//                                                \Zend\Validator\Callback::INVALID_VALUE => 'Start year can not be greater than end year',
//                                            ),
//                                            'callback' => function($value, $context = array()) {
//                                                return ($context['endYear'] <= $value)?false:true;
//                                            },
//                                        ),
//                                    )
//                 ),
//            ),
        );
    }
}
