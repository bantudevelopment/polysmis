<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Form\Fieldset;

/**
 *
 * @author hkumwembe
 */

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
//use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;


class FsBasicUserDetails extends Fieldset implements InputFilterProviderInterface
{
    

    public function __construct()
    {   
        parent::__construct('basicdetails');
        /*
         * This part is common
         */
        $this->add(array(
            'name' => 'surname',
            'options' => array(
                'label' => 'Surname:*',
                
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                'id'       => 'surname'
                //'placeholder' => 'Surname'
            )
        ));
        
        
        $this->add(array(
            'name' => 'firstname',
            'options' => array(
                'label' => 'Firstname:*'
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                'id'       => 'firstname'
                //'placeholder' => 'Firstname'
            )
        ));
        
        $this->add(array(
            'name' => 'othernames',
            'options' => array(
                'label' => 'Other names:'
            ),
            'attributes' => array(
                'class'    => 'form-control',
                //'placeholder' => 'Initials'
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'gender',
            'options' => array(
                'label' => 'Gender:*',
                'value_options' => array(
                             'M' => 'Male',
                             'F' => 'Female',
                             
                     ),
                'empty_option'=>"--Select--",
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'title',
            'options' => array(
                'label' => 'Title:*',
                'value_options' => array(
                             'Dr' => 'Dr',
                             'Mr' => 'Mr',
                             'Mrs' => 'Mrs',
                             'Miss' => 'MISS',
                             'Prof' => 'Prof',
                             'Bro' => 'Bro',
                             'Fr' => 'Fr',
                             'Sr' => 'Sr',
                     ),
                'empty_option'=>"--Select--",
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                
            )
        ));
        
        
        
        //End of common elements        
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            'surname' => array(
                'required' => true
            ),
            'firstname' => array(
                'required' => true
            ),
            'gender' => array(
                'required' => true
            ),
           
        );
    }
}
