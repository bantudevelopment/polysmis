<?php
namespace Application\Model;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Staff
 *
 * @author hkumwembe
 */
class Staff extends Usermodel {
      
    protected $cs;
    
    public function __construct(\Doctrine\ORM\EntityManager $em, \Application\Service\Security $cs = null) {
          parent::__construct($em);
          $this->cs = $cs;
      }

      public function registerUser($formdata){

        $entity = new \Application\Entity\User();

        $roleid = $this->em->getRepository('\Application\Entity\Role')->find($formdata['User']['fkRoleid']);

        //Initialize fields
        $entity->setUsername($formdata['User']['username']);
        $entity->setFirstname($formdata['User']['basicdetails']['firstname']);
        $entity->setSurname($formdata['User']['basicdetails']['surname']);
        $entity->setOthernames($formdata['User']['basicdetails']['othernames']);
        $entity->setGender($formdata['User']['basicdetails']['gender']);
        $entity->setPassword($this->cs->_hashing($formdata['password']));
        $entity->setTitle($formdata['User']['basicdetails']['title']);
        $entity->setAccounttype("STAFF");
        $entity->setEmailaddress($formdata['User']['emailaddress']);
        $entity->setFkRoleid($roleid);  
        $fkUserid = $this->saveUser($entity);  
        
        //Save user in user table
        if($fkUserid){
            //Set staff entity
            $staffentity = new \Application\Entity\Staff();
            
            $fkDeptid    = $this->em->getRepository('\Application\Entity\Department')->find($formdata['Staff']['fkDeptid']);
            
            $staffentity->setFkDeptid($fkDeptid);
            $staffentity->setFkUserid($fkUserid);
            $staffentity->setWorkmode($formdata['Staff']['workmode']);
            
            //Save in staff table
            $staffid = $this->saveStaff($staffentity);  
            //Assign to department as head
            if($formdata['ishead']){
                $departmentModel = new \Application\Model\Preferences($this->em);
                // Update is head
                $deptEntity = $fkDeptid->setFkStaffid($staffid);
                $departmentModel->saveDepartment($deptEntity); 
            }
        }
        
        return $fkUserid;
      }
    
    /*
     * Save staff
     */
    public function saveStaff($object) {
        
         if(!$object->getPkStaffid()){
                $oe = new \Application\Entity\Staff();
         }else{
                $oe = $this->em->getRepository("\Application\Entity\Staff")->find($object->getPkStaffid());
         }

        //Set staff object values to be saved
        $oe->setFkDeptid($object->getFkDeptid());
        $oe->setFkUserid($object->getFkUserid());
        $oe->setWorkmode($object->getWorkmode());
            
        try{
            //Commit values set to the object 
            if(!$object->getPkStaffid()){
                $this->em->persist($oe);
            }
            //Save values if just updating record
            $this->em->flush($oe);
            return $oe;

        }catch(Exception $e){
            throw($e->getMessages());
        }
    }
    
    
    /*
     * Allocate user staff to department
     */
    public function allocate($object) {
        
        if(!$object->getPkStaffid()){
            $staff = new \Application\Entity\Staff();
        }else{
            $criteria = Criteria::create()
                        ->where(Criteria::expr()->eq("pkStaffid", $object->getPkStaffid()));
            $staff = $this->getEntity("\Application\Entity\Staff", $criteria);
        }
        
        //Set user object values to be saved
        $staff->setFkUserid($object->getFkUserid());
        $staff->setFkDeptid($object->getFkDeptid());
        $staff->setMode($object->getMode());
        
        try{
            //Commit values set to the object 
            if(!$object->getPkStaffid()){
                $this->em->persist($staff);
            }
            
            //Save values if just updating record
            $this->em->flush($staff);
            return $staff;
            
        }catch(Exception $e){
            throw($e->getMessages());
        }
    }
    
    /*
     * Assign lecturer module
     */
    public function assignModule($moduleparams) {
        
    }
}
