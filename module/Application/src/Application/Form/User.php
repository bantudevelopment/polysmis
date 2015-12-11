<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class User extends Form implements InputFilterProviderInterface
 {
     private $em;
     
     /*
     * Fetch list of program group
     */
    public function getRoles(){
        
        $groups = $this->em->getRepository('\Application\Entity\Role')->findAll();
        foreach($groups as $group ){
            $role[$group->getPkRoleid()] = $group->getDescription();
        }
        
        return $role;
    }
     
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
            'type' =>'Zend\Form\Element\Password',
            'name' => 'password',
            'options' => array(
                'label' => 'Password:*'
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                //'placeholder' => 'Password'
            )
        ));
        
        $this->add(array(
            'type' =>'Zend\Form\Element\Password',
            'name' => 'cpassword',
            'options' => array(
                'label' => 'Confirm password:*'
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                //'placeholder' => 'Confirm password'
            )
        ));
        
        
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
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'fkRoleid',
            'options' => array(
                'label' => 'Role:*',
                'value_options' => $this->getRoles(),
                'empty_option'  => '--Select--'
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control',
                
            )
        ));
        
           
     }
     
     
     public function getInputFilterSpecification()
    {
        return array(
            'fkRoleid' => array(
                'required' => true
            ),
            'password' => array(
                'required' => true,
                'validators' => array(
                                    array(
                                    'name' => 'Callback',
                                    'options' => array(
                                            'messages' => array(
                                                \Zend\Validator\Callback::INVALID_VALUE => 'Passwords do not match',
                                            ),
                                            'callback' => function($value, $context = array()) {
                                                return ($context['cpassword'] != $value)?false:true;
                                            },
                                        ),
                                    ),
                                    array(
                                    'name' => 'StringLength',
                                    'options' => array(
                                            'min' => 6,
                                            'max' => 30
                                        ),
                                    )
                 ),
            ),
            
            
            
        );
    }
 }
