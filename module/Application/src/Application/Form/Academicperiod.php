<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class Academicperiod extends Form
 {
     private $em;
     
     public function __construct(\Doctrine\ORM\EntityManager $em = null, $preferences = null)
     {
         // we want to ignore the name passed
         parent::__construct('frmperiod');
         $this->em = $em; 
	
         $this->setAttribute('method', 'post')
             ->setHydrator(new ClassMethodsHydrator(false))
             ->setInputFilter(new InputFilter());

        $fieldset = new Fieldset\FsAcademicperiod($em,$preferences);
        $fieldset->setUseAsBaseFieldset(true);
        $this->add($fieldset);
           
     }
 }
