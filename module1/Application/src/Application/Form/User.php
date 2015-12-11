<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class User extends Form
 {
     private $em;
     
     public function __construct(\Doctrine\ORM\EntityManager $em = null)
     {
         // we want to ignore the name passed
         parent::__construct('frmuser');
         $this->em = $em; 
	
         $this->setAttribute('method', 'post')
             ->setHydrator(new ClassMethodsHydrator(false))
             ->setInputFilter(new InputFilter());

        $fieldset = new Fieldset\FsUser($em);
        $fieldset->setUseAsBaseFieldset(true);
        $this->add($fieldset);
        
        $stafffieldset = new Fieldset\FsStaff($em);
        $stafffieldset->setUseAsBaseFieldset(false);
        $this->add($stafffieldset);
        
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'ishead',
            'options' => array(
                'label' => 'Head of department:',
                'checked_value' => '1',
                'unchecked_value' => '0'
            )
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Login',
                'class' => 'btn btn-lg btn-primary btn-block'
            )
        ));
           
     }
 }
