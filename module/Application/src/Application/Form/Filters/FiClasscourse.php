<?php
namespace Application\Form\Filters;

 // Add these import statements
 use Zend\InputFilter\InputFilter;
 use Zend\InputFilter\InputFilterAwareInterface;
 use Zend\InputFilter\InputFilterInterface;

 class FiClasscourse implements InputFilterAwareInterface
 {
     protected $inputFilter;                       // <-- Add this variable
     protected $em;
     protected $fkModuleid;
     protected $fkGroupid;
     protected $iscore;
     protected $parentid;
     protected $examweight;
     protected $cwkweight;


     public function __construct(\Doctrine\ORM\EntityManager $em = null) {
        $this->em = $em;
    }
     
     public function exchangeArray($data)
     {

        $this->fkModuleid = (isset($data['fkModuleid'])) ?$data['fkModuleid'] : null;
	$this->fkGroupid  = (isset($data['fkGroupid']))?$data['fkGroupid'] : null;
        $this->iscore     = (isset($data['iscore'])) ?$data['iscore'] : null;
	$this->parentid   = (isset($data['parentid']))?$data['parentid'] : null;
        $this->examweight = (isset($data['examweight'])) ?$data['examweight'] : null;
	$this->cwkweight  = (isset($data['cwkweight']))?$data['cwkweight'] : null;
        
     }
	 

     // Add content to these methods:
     public function setInputFilter(InputFilterInterface $inputFilter)
     {
         throw new \Exception("Not used");
     }
     
     public function getInputFilter()
     {
         /*
          * 
          */
         
         if (!$this->inputFilter) {
             $inputFilter = new InputFilter();

             /*
              * Configuring filters
              */

             $inputFilter->add(array(
                'name'       => 'fkModuleid',
                'required'   => true
             ));
             
             $inputFilter->add(array(
                'name'       => 'fkGroupid',
                'required'   => true,
                 'validators'   => array(
                                     array(
                                            'name'    => 'NotEmpty',
                                            'options' => array(
                                                            'encoding' => 'UTF-8',
                                                            'messages' => array(\Zend\Validator\NotEmpty::IS_EMPTY=> 'Class or group is empty'),
                                                          ),
                                         )
                                   ),
             ));
             
             $inputFilter->add(array(
                'name'       => 'fkPeriodid',
                'required'   => true,
                 'validators'   => array(
                                     array(
                                            'name'    => 'NotEmpty',
                                            'options' => array(
                                                            'encoding' => 'UTF-8',
                                                            'messages' => array(\Zend\Validator\NotEmpty::IS_EMPTY=> 'Period is not set'),
                                                          ),
                                         )
                                   ),
             ));
             
             $inputFilter->add(array(
                'name'       => 'parentid',
                'required'   => false,
             ));
             
             $inputFilter->add(array(
                'name'       => 'iscore',
                'required'   => true,
                 'validators'   => array(
                                     array(
                                            'name'    => 'NotEmpty',
                                            'options' => array(
                                                            'encoding' => 'UTF-8',
                                                            'messages' => array(\Zend\Validator\NotEmpty::IS_EMPTY=> 'Select whether module is core or not'),
                                                          ),
                                         )
                                    ),
             ));

             
             $inputFilter->add(array(
                 'name'         => 'examweight',
                 //'type'         => 'Zend\Form\Element\Number',
                 'required'     => true,
                 'filters'      => array(
                                     array('name' => 'StripTags'),
                                     array('name' => 'StringTrim'),
                                    ),
                 'validators'   => array(
                                     array(
                                            'name'    => 'NotEmpty',
                                            'options' => array(
                                                            'encoding' => 'UTF-8',
                                                            
                                                            'messages' => array(\Zend\Validator\NotEmpty::IS_EMPTY=> 'Exam weighting is empty'),
                                                          ),
                                         ),
                                     array(
                                        'name'    => 'StringLength',
                                        'options' => array(
                                                            'encoding' => 'UTF-8',
                                                            'min'      => 1,
                                                            'max'      => 3,
                                                            'messages' => array('stringLengthInvalid' => 'Exam weighting should be between 0 and 100'),
                                                          ),
                                         ),
                                        ),
             ));
             
             
             $inputFilter->add(array(
                 'name'         => 'cwkweight',
                 //'type'         => 'Zend\Form\Element\Number',
                 'required'     => true,
                 'filters'      => array(
                                     array('name' => 'StripTags'),
                                     array('name' => 'StringTrim'),
                                    ),
                 'validators'   => array(
                                        array(
                                            'name'    => 'NotEmpty',
                                            'options' => array(
                                                            'encoding' => 'UTF-8',
                                                            
                                                            'messages' => array(\Zend\Validator\NotEmpty::IS_EMPTY=> 'Course work weight is empty'),
                                                          ),
                                         ),
                                        array(
                                            'name'    => 'StringLength',
                                            'options' => array(
                                                            'encoding' => 'UTF-8',
                                                            'min'      => 1,
                                                            'max'      => 3,
                                                            'messages' => array('stringLengthInvalid'=> 'Course work weight should be between 0 and 100'),
                                                          ),
                                         ),
                                         array(
                                            'name' => 'Callback',
                                            'options' => array(
                                                'messages' => array(
                                                    \Zend\Validator\Callback::INVALID_VALUE => 'Total Course work and exam weighting must be 100%',
                                                ),
                                                'callback' => function($value, $context = array()) {
                                                    return ($context['examweight'] + $value ==100)?true:false;
                                                },
                                            ),
                                        ),
                                    ),
             ));
                                                
             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;
     }
 }