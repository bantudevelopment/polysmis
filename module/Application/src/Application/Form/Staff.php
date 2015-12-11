<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class Staff extends Form
 {
     private $em;
     
     public function __construct(\Doctrine\ORM\EntityManager $em = null)
     {
         // we want to ignore the name passed
         parent::__construct('frmstaff');
         $this->em = $em; 
	
         $this->setAttribute('method', 'post')
             ->setHydrator(new ClassMethodsHydrator(false))
             ->setInputFilter(new InputFilter());

        $fieldset = new Fieldset\FsStaff($em);
        $fieldset->setUseAsBaseFieldset(true);
        $this->add($fieldset);

//        $this->add(array(
//            'name' => 'submit',
//            'attributes' => array(
//                'type' => 'submit',
//                'value' => 'Login',
//                'class' => 'btn btn-lg btn-primary btn-block'
//            )
//        ));
           
     }
 }
