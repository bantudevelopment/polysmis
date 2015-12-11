<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Form\Fieldset;

/**
 * Description of EntityFieldset
 *
 * @author hkumwembe
 */

use Application\Entity\Studentmark;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;


class FsAssessmentmark extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('Mark');
        
        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new Studentmark());

        $this->add(array(
            'type' => 'Zend\Form\Element\Number',
            'name' => 'mark',
            'attributes' => array(
                'class'    => 'form-control',
                'style'    => "width: 80px; margin: 0px;",
                //'required' => 'required'
            )
        ));
        
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
//        return array(
//            'mark' => array(
//                'required' => false,
//            )
//        );
    }
}
