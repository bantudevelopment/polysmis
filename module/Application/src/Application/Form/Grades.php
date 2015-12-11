<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class Grades extends Form
 {
     private $em;
     
     public function __construct($studentcounter,\Doctrine\ORM\EntityManager $em = null)
     {
         // we want to ignore the name passed
         parent::__construct('grades');
         $this->em = $em; 
	
         $this->setAttribute('method', 'post')
             ->setHydrator(new ClassMethodsHydrator(false))
             ->setInputFilter(new InputFilter());

//        $fieldset = new Fieldset\FsAssessment($em);
//        $fieldset->setUseAsBaseFieldset(true);
//        $this->add($fieldset);

            $this->add(array(
                'type' => 'Zend\Form\Element\Collection',
                'name' => 'mark',
                'options' => array(
                    //'label' => 'Please choose programs',
                    'count' => $studentcounter,
                    'should_create_template' => true,
                    //'allow_add' => true,
                    //'allow_remove' => true,
                    'template_placeholder' => '__mark__',
                    'target_element' => new \Application\Form\Fieldset\FsAssessmentmark()
                )
            ));
           
     }
 }
