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
use Application\Entity\Module;


class FsModule extends Fieldset implements InputFilterProviderInterface
{
    protected $em;
    
    


    public function __construct(\Doctrine\ORM\EntityManager $em = null)
    {
        $this->em = $em;
        
        parent::__construct('Module');
        
        
        
        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new Module());
        
        
        $this->add(array(
            'name' => 'pkModuleid',
            'type' => 'hidden',
            'options' => array(
                'label' => ' '
            ),
        ));
        
        $this->add(array(
            'name' => 'moduleCode',
            'options' => array(
                'label' => 'Code:*'
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                //'placeholder' => 'Username'
            )
        ));
        
        $this->add(array(
            'name' => 'moduleName',
            'options' => array(
                'label' => 'Name:*'
            ),
            'attributes' => array(
                'required' => 'required',
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
            'moduleName' => array(
                'required' => true
            ),
            'moduleCode' => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'DoctrineModule\Validator\UniqueObject',
                        'options' => array(
                            'use_context' => true,
                            'object_repository' => $this->em->getRepository('Application\Entity\Module'),
                            'fields' => 'moduleCode',
                            'object_manager' => $this->em,
                        )
                    )
                ) 
            )
            
        );
    }
}
