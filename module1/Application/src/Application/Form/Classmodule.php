<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class Classmodule extends Form 
 {
     private $em;
     
     public function __construct($period,\Doctrine\ORM\EntityManager $em = null,$class=null,$classmodule=null)
     {
         // we want to ignore the name passed
         parent::__construct('classmodule');
         $this->em = $em; 

         $this->setAttribute('method', 'post')
             ->setHydrator(new ClassMethodsHydrator(false))
             ->setInputFilter(new InputFilter());
         
         $fieldset = new Fieldset\FsClassmodule($period,$em,$class,$classmodule);
         $fieldset->setUseAsBaseFieldset(true);
         $this->add($fieldset);
 
     }
     
 }
