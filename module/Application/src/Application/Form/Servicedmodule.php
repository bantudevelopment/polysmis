<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class Servicedmodule extends Form
 {
     private $em;
     private $deptid;
     
     public function __construct(\Doctrine\ORM\EntityManager $em = null,$deptid = null)
     {
         // we want to ignore the name passed
         parent::__construct('frmlmodule');
         $this->em = $em; 
         $this->deptid = $deptid;
	
         $this->setAttribute('method', 'post')
             ->setHydrator(new ClassMethodsHydrator(false))
             ->setInputFilter(new InputFilter());
         
         $fieldset = new Fieldset\Exams\FsServicedmodule($em,$deptid);
         $fieldset->setUseAsBaseFieldset(true);
         $this->add($fieldset);
      
     }
     
 }
