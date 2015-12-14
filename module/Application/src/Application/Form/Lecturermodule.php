<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class Lecturermodule extends Form implements InputFilterProviderInterface 
 {
     private $em;
     private $deptid;
     
     /*
     * Fetch list of staff
     */
    public function getDepartments(){
        $options = array();
        //if($this->deptid != NULL){
            $query = $this->em->createQuery("SELECT D FROM \Application\Entity\Department D "
                                           . " WHERE D.pkDeptid != :deptid ")
                              ->setParameter("deptid", $this->deptid);

            foreach($query->getResult() as $user ){
                $options[$user->getPkDeptid()] = $user->getDeptName();
            }
        //}
        
        return $options;
    }
     
     public function __construct(\Doctrine\ORM\EntityManager $em = null,$deptid = null)
     {
         // we want to ignore the name passed
         parent::__construct('frmlmodule');
         $this->em = $em; 
         $this->deptid = $deptid;
	
         $this->setAttribute('method', 'post')
             ->setHydrator(new ClassMethodsHydrator(false))
             ->setInputFilter(new InputFilter());
         
         $fieldset = new Fieldset\Exams\FsLecturermodule($em,$deptid);
         $fieldset->setUseAsBaseFieldset(true);
         $this->add($fieldset);
         
         $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'fkReqdeptid',
            'options' => array(
                'label' => 'Department: ',
                'value_options' => $this->getDepartments(),
                'empty_option'  => "--Select--"
            ),
            'attributes' => array(
                'class'    => 'form-control',
                'id'       => 'fkReqdeptid'
                
            )
        ));
 
     }
     
     /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            'fkReqdeptid' => array(
                'required' => false,
            ),
            
        );
    }
     
 }
