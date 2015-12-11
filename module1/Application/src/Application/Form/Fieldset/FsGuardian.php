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
use Application\Entity\Studentcontact;


class FsGuardian extends Fieldset implements InputFilterProviderInterface
{
    protected $em;
    
    public function __construct(\Doctrine\ORM\EntityManager $em = null)
    {
        $this->em = $em;
        
        parent::__construct('Guardian');
        
        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new Studentcontact());
        
        
        $this->add(array(
            'name' => 'pkGuardianid',
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
            'type' => 'Zend\Form\Element\Select',
            'name' => 'title',
            'options' => array(
                'label' => 'Title:*',
                'value_options' => array(
                             'Dr.'   => 'Dr.',
                             'Prof.' => 'Prof.',
                             'Mrs'   => 'Mrs',
                             'Mr'    => 'Mr',
                             'Miss'  => 'Miss',       
                     ),
                'empty_option' => "--Title---",
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                
            )
        ));
        
        $this->add(array(
            'name' => 'surname',
            'options' => array(
                'label' => 'Surname:*',
                
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                'placeholder' => 'Surname'
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
                'placeholder' => 'Firstname'
            )
        ));
        
        
        $this->add(array(
            'name' => 'postalAddress',
            'type' => 'textarea',
            'options' => array(
                'label' => 'Postal address:*'
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
            )
        ));
        
        $this->add(array(
            'name' => 'mobile',
            'type' => 'text',
            'options' => array(
                'label' => 'Mobile phone:*'
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
            )
        ));
        
        $this->add(array(
            'name' => 'telephoneNumber',
            'type' => 'text',
            'options' => array(
                'label' => 'Telephone:'
            ),
            'attributes' => array(
                //'required' => 'required',
                'class'    => 'form-control',
                //'placeholder' => 'Username'
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Email',
            'name' => 'emailAddress',
            'options' => array(
                'label' => 'Email address:*'
            ),
            'attributes' => array(
                'class'    => 'form-control',
                //'required' => 'required',
                
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'relationship',
            'options' => array(
                'label' => 'Relationship:*',
                'value_options' => array(
                             'Aunt' => 'Aunt',
                             'Uncle' => 'Uncle',
                             'Brother' => 'Brother',
                             'Father' => 'Father',
                             'Sister' => 'Sister',       
                     ),
                'empty_option' => "--Relationship--",
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
//            'dob' => array(
//                'required' => true
//            ),
//           'maritalStatus' => array(
//                'required' => true
//            ),
//            'fkDistrictid' => array(
//                'required' => true
//            ),
//            'fkCountryid' => array(
//                'required' => true
//            ),
        );
    }
}
