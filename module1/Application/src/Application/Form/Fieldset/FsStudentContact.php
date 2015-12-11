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


class FsStudentContact extends Fieldset implements InputFilterProviderInterface
{
    protected $em;
    
    public function __construct(\Doctrine\ORM\EntityManager $em = null)
    {
        $this->em = $em;
        
        parent::__construct('Studentcontact');
        
        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new Studentcontact());
        
        
        $this->add(array(
            'name' => 'pkScid',
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
            'name' => 'postalAddress',
            'type' => 'textarea',
            'options' => array(
                'label' => 'Postal address:*'
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                //'placeholder' => 'Username'
            )
        ));
        
        $this->add(array(
            'name' => 'cell',
            'type' => 'text',
            'options' => array(
                'label' => 'Mobile phone:*'
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                //'placeholder' => 'Username'
            )
        ));
        
        $this->add(array(
            'name' => 'telephone',
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
        
        
        
       
              
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            'postalAddress' => array(
                'required' => true
            ),
           'cell' => array(
                'required' => true
            )
        );
    }
}
