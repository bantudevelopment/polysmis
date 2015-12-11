<?php
namespace Application\Form;

use Zend\Form\Form;

class Lecturerassignment extends Form
 {
    protected $em;
    protected $department;
    
    /*
     * Fetch available list
     */
    public function getLecturers(){
        
        $options[""] = "--Select--";
        //Query all users(Lecturers) not assigned to other departments
        $objects = $this->em->getRepository('\Application\Entity\Staff')->findBy(array("fkDeptid"=>$this->department));
        
        foreach($objects as $object ){
            $options[$object->getPkStaffid()] = $object->getFkUserid()->getSurname()." ".$object->getFkUserid()->getFirstname();
        }
        
        $options["DEPARTMENT"] = "Allocate to another department";
        
        return $options;
    }
    
    /*
     * Fetch allocated list
     */
    public function getDepartments(){
        
        $options[""] = "--Select--";
        //Query all users(Lecturers) not assigned to other departments
        //$modules = $this->em->getRepository('\Application\Entity\Module')->findAll();
        $query  = $this->em->createQuery("SELECT D FROM \Application\Entity\Department D WHERE D.pkDepartmentid != :department")
                             ->setParameter('department', $this->department);
        
        foreach($query->getResult() as $module ){
            $options[$module->getPkDepartmentid()] = $module->getDeptName()." (".$module->getDeptCode().")";
        }
        
        return $options;
    }
    


    public function __construct($department,\Doctrine\ORM\EntityManager $em = null)
    {
        $this->em         = $em;
        $this->department = $department;
         // we want to ignore the name passed
         parent::__construct('modulelecturer');
	
         $this->add(array(
             'name'         => 'fkStaffid',
             'type' => 'Zend\Form\Element\Select',
             'attributes'   => array('class'=> 'form-control','id'=>'fkStaffid'),
              'options' => array(
                'label' => 'Lecturer:*',
                'value_options' => $this->getLecturers()
              )
         )); 
         
         $this->add(array(
             'name'         => 'fkCcid',
             'type'         => 'hidden',
             'attributes'   => array('class'=> 'form-control','id'=>'fkCcid'),
             'options' => array(
                'label' => ' '
            )
         ));
         
         $this->add(array(
             'name'         => 'servicingDept',
             'type' => 'Zend\Form\Element\Select',
             'attributes'   => array('class'=> 'form-control','id'=>'servicingDept'),
              'options' => array(
                'label' => 'Servicing department:*',
                'value_options' => $this->getDepartments()
              )
         )); 
         
         $this->add(array(
             'name'         => 'fkDeptid',
             'type'         => 'hidden',
             'attributes'   => array('class'=> 'form-control','id'=>'fkDeptid','value' => $this->department),
              
         ));
         
         
         
//         $this->add(array(
//            'type' => 'Zend\Form\Element\Select',
//            'name' => 'iscore',
//            'options' => array(
//                'label' => 'Is core:*',
//                'value_options' => array("1"=>"Yes","0"=>"No")
//            ),
//            'attributes' => array(
//                'class'    => 'form-control',
//                
//            )
//        ));
	  
     }
 }