<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class Changepassword extends Form implements InputFilterProviderInterface
 {
     private $em;
     private $cs;
     
     public function __construct(\Doctrine\ORM\EntityManager $em = null, \Application\Service\Security $cs= null)
     {
         // we want to ignore the name passed
         parent::__construct('frmreset');
         $this->em = $em; 
         $this->cs = $cs;
	
         $this->setAttribute('method', 'post')
             ->setHydrator(new ClassMethodsHydrator(false))
             ->setInputFilter(new InputFilter());

        $fieldset = new Fieldset\FsResetpassword($em);
        $fieldset->setUseAsBaseFieldset(true);
        $this->add($fieldset);

        $this->add(array(
            'type' =>'Zend\Form\Element\Password',
            'name' => 'oldpassword',
            'options' => array(
                'label' => 'Old password:*'
            ),
            'attributes' => array(
                'required' => 'required',
                'class'    => 'form-control'
            )
        ));
           
     }
     
     
     /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
           
            'oldpassword' => array(
                'required' => true,
                'validators' => array(
                                    array(
                                    'name' => 'Callback',
                                    'options' => array(
                                            'messages' => array(
                                                \Zend\Validator\Callback::INVALID_VALUE => 'Password does not exist',
                                            ),
                                            'callback' => function($value, $context = array()) {
           
                                                $counter = $this->em->getRepository("\Application\Entity\User")->findBy(array("pkUserid"=>$context['Password']['pkUserid'],"password"=>$this->cs->_hashing($value)));
                                                return (count($counter) <= 0)?false:true;
                                            },
                                        ),
                                    )
                 ),
            ),
            
            
            
        );
    }
     
     
     
 }
