<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class Groupenrollment extends Form
 {
     public function __construct()
     {
         // we want to ignore the name passed
         parent::__construct('group');
		 
	
         $this->setAttribute('method', 'post')
             ->setHydrator(new ClassMethodsHydrator(false))
             ->setInputFilter(new InputFilter());

        $this->add(array(
            'type' => 'Application\Form\Fieldset\FsFile',
            'options' => array(
                'use_as_base_fieldset' => true
            )
        ));
           
     }
 }
