<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class Department extends Form 
 {
     private $em;
     
     public function __construct(\Doctrine\ORM\EntityManager $em = null, $id = null)
     {
         // we want to ignore the name passed
         parent::__construct('frmdepartment');
         $this->em = $em; 
	
         $this->setAttribute('method', 'post')
             ->setHydrator(new ClassMethodsHydrator(false))
             ->setInputFilter(new InputFilter());
         
         $fieldset = new Fieldset\FsDepartment($em,$id);
         $fieldset->setUseAsBaseFieldset(true);
         $this->add($fieldset);
 
     }
     
 }
