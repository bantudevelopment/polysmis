<?php
namespace Application\Model;

/**
 * Description of Admission
 *
 * @author hkumwembe
 */
use \Doctrine\Common\Collections\Criteria;
use DoctrineModule\Paginator\Adapter\Collection as Adapter;
use Zend\Paginator\Paginator;
use Zend\Di\Di;

class Preferences extends Commonmodel {

    protected $em;
    protected $facultyCode;
    protected $facultyName;
    protected $pkFacultyid;
    protected $fkStaffid;


    public function __construct(\Doctrine\ORM\EntityManager $em) {
        parent::__construct($em);
        $this->em = $em;
    }

    /*
     * Save faculty
     */
    public function saveFaculty($object) {
        
         if(!$object->getPkFacultyid()){
                $oe = new \Application\Entity\Faculty();
         }else{
                $oe = $this->em->getRepository("\Application\Entity\Faculty")->find($object->getPkFacultyid());
         }

            //Set faculty object values to be saved
            $oe->setFkStaffid($object->getFkStaffid());
            $oe->setFacultyName($object->getFacultyName());
            $oe->setFacultyCode($object->getFacultyCode());
            
            try{
                //Commit values set to the object 
                if(!$object->getPkFacultyid()){
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
     * Save department
     */
    public function saveDepartment($object) {
        
         if(!$object->getPkDeptid()){
                $oe = new \Application\Entity\Department();
         }else{
                $oe = $this->em->getRepository("\Application\Entity\Department")->find($object->getPkDeptid());
         }

            //Set faculty object values to be saved
            $oe->setFkStaffid($object->getFkStaffid());
            $oe->setDeptName($object->getDeptName());
            $oe->setDeptCode($object->getDeptCode());
            $oe->setFkFacultyid($object->getFkFacultyid());
            
            try{
                //Commit values set to the object 
                if(!$object->getPkDeptid()){
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
     * Save program
     */
    public function saveProgram($object) {
        
         if(!$object->getPkProgramid()){
                $oe = new \Application\Entity\Program();
         }else{
                $oe = $this->em->getRepository("\Application\Entity\Program")->find($object->getPkProgramid());
         }

            //Set program object values to be saved
            $oe->setFkAwardid($object->getFkAwardid());
            $oe->setProgramName($object->getProgramName());
            $oe->setProgramLongName($object->getProgramLongName());
            $oe->setProgramCode($object->getProgramCode());
            $oe->setFkDeptid($object->getFkDeptid());
            $oe->setDuration($object->getDuration());
            
            try{
                //Commit values set to the object 
                if(!$object->getPkProgramid()){
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
     * Save class
     */
    public function saveClass($object) {
        
         if(!$object->getPkClassid()){
                $oe = new \Application\Entity\Classes();
         }else{
                $oe = $this->em->getRepository("\Application\Entity\Classes")->find($object->getPkClassid());
         }

            //Set program object values to be saved
            $oe->setFkProgramid($object->getFkProgramid());
            $oe->setClassName($object->getClassName());
            $oe->setClassCode($object->getClassCode());
            $oe->setClassYear($object->getClassYear());
            
            try{
                //Commit values set to the object 
                if(!$object->getPkClassid()){
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
     * Save academic period
     */
    public function saveAcademicPeriod($object) {
        
         if(!$object->getPkAcademicperiodid()){
                $oe = new \Application\Entity\Academicyear();
         }else{
                $oe = $this->em->getRepository("\Application\Entity\Academicyear")->find($object->getPkAcademicperiodid());
         }

            //Set program object values to be saved
            $oe->setAcyr($object->getAcyr());
            $oe->setCategory($object->getCategory());
            $oe->setEndDate($object->getEndDate());
            $oe->setStartDate($object->getStartDate());
            $oe->setParentid($object->getParentid());
            
            try{
                //Commit values set to the object 
                if(!$object->getPkAcademicperiodid()){
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
     * Save class module
     */
    public function saveClassModule($object) {
        
         if(!$object->getPkClassmoduleid()){
                $oe = new \Application\Entity\Classmodule();
         }else{
                $oe = $this->em->getRepository("\Application\Entity\Classmodule")->find($object->getPkClassmoduleid());
         }

            //Set program object values to be saved
            $oe->setCwkweight($object->getCwkweight());
            $oe->setExweight($object->getExweight());
            $oe->setFkAcademicperiod($object->getFkAcademicperiod());
            $oe->setFkClassid($object->getFkClassid());
            $oe->setFkModuleid($object->getFkModuleid());
            $oe->setIsCore($object->getIsCore());
            $oe->setIsProject($object->getIsProject());
            $oe->setScheme($object->getScheme());
            
            try{
                //Commit values set to the object 
                if(!$object->getPkClassmoduleid()){
                    $this->em->persist($oe);
                }
                //Save values if just updating record
                $this->em->flush($oe);
                return $oe;

            }catch(Exception $e){
                throw($e->getMessages());
            }
    }



//    public function getUserList($criteria){
//        $users = $this->getEntity('\Application\Entity\User', $criteria);
//        return $users;
//    }
//    
//    public function getModulesWithoutLecturers($period,$group){
//       $query = $this->em->createQuery("SELECT M FROM \Application\Entity\Classmodule M "
//                                       . "WHERE M.pkCcid NOT IN(SELECT IDENTITY(L.fkCcid) FROM \Application\Entity\Lecturermodule L JOIN L.fkCcid P WHERE P.fkPeriodid = :period AND P.fkGroupid = :group )"
//                                       . " AND M.fkPeriodid = :periodid "
//                                        . "AND M.fkGroupid = :groupid")
//                         ->setParameter('period', $period)
//                         ->setParameter('group', $group)
//                         ->setParameter('periodid', $period)
//                         ->setParameter('groupid', $group);
//       return $query->getResult();
//    }
//    
//    public function getAssignedModules($period,$group){
//        $query = $this->em->createQuery("SELECT L FROM \Application\Entity\Lecturermodule L JOIN L.fkCcid P WHERE P.fkPeriodid = :period AND P.fkGroupid = :group")
//                         ->setParameter('period', $period)
//                         ->setParameter('group', $group);
//        return $query->getResult();
//    }
//    
//    public function getServicingDepartmentModules($period,$group){
//        $query = $this->em->createQuery("SELECT L FROM \Application\Entity\Lecturermodule L JOIN L.fkCcid P WHERE P.fkPeriodid = :period AND P.fkGroupid = :group")
//                         ->setParameter('period', $period)
//                         ->setParameter('group', $group);
//        return $query->getResult();
//    }
//    
//    
//    public function saveUser($formobject){
//        $di          = new Di();
//        $service     = $di->get('Application\Service\Common');
//
//        //Set date created
//        $datecreated = new \DateTime();
//        //Set role
//        
//        $role         = $this->em->getRepository('\Application\Entity\Role')->find($formobject['fkRoleid']);
//        
//        $objectarray['datecreated'] = $datecreated;
//        $objectarray['role']        = $role;
//        $objectarray['username']    = $formobject['username'];
//        $objectarray['title']       = "";
//        $objectarray['url']         = "";
//        $objectarray['firstname']   = $formobject['basicdetails']['firstname'];
//        $objectarray['surname']     = $formobject['basicdetails']['surname'];
//        $objectarray['gender']      = $formobject['basicdetails']['gender'];
//        $objectarray['initial']     = $formobject['basicdetails']['initial'];
//        $objectarray['emailaddress']= $formobject['basicdetails']['emailaddress'];
//        $objectarray['password']    = $service->_hashing($formobject['password']);
//        $objectarray['ipaddress']   = '';
//        $objectarray['logindate']   = $datecreated;
//        
//        $staffmodel = new \Application\Model\Staff($this->em);
//        $staffmodel->saveUserObject($staffmodel->setUserObject($objectarray));
//        
//    }
//    
//    /*
//     * Set department object
//     */
//    public function saveDepartment($deptobject){
//        
//        if(!$deptobject->getPkDepartmentid()){
//            $department = new \Application\Entity\Department();
//        }else{
//            $department = $this->em->getRepository("\Application\Entity\Department")->find($deptobject->getPkDepartmentid());
//        }
//        
//        //Set user object values to be saved
//        $department->setDeptName($deptobject->getDeptName());
//        $department->setDeptCode($deptobject->getDeptCode());
//        $department->setHod($deptobject->getHod());
//
//        try{
//            //Commit values set to the object 
//            if(!$deptobject->getPkDepartmentid()){
//                $this->em->persist($department);
//            }
//            
//            //Save values if just updating record
//            $this->em->flush($department);
//            return $department;
//            
//        }catch(Exception $e){
//            throw($e->getMessages());
//        }
//    }
//    
//    
//     /*
//     * Save program object
//     */
//    public function saveProgram($object){
//        
//        if(!$object->getPkProgramid()){
//            $prog = new \Application\Entity\Program();
//        }else{
//            $prog = $this->em->getRepository("\Application\Entity\Program")->find($object->getPkProgramid());
//        }
//        
//        //Set user object values to be saved
//        $prog->setProgName($object->getProgName());
//        $prog->setProgCode($object->getProgCode());
//        $prog->setFkProgramcategoryid($object->getFkProgramcategoryid());
//        $prog->setFkSchoolid($object->getFkSchoolid());
//
//        try{
//            //Commit values set to the object 
//            if(!$object->getPkProgramid()){
//                $this->em->persist($prog);
//            }
//            
//            //Save values if just updating record
//            $this->em->flush($prog);
//            return $prog;
//            
//        }catch(Exception $e){
//            throw($e->getMessages());
//        }
//    }
//    
//     /*
//     * Save department program object
//     */
//    public function saveDepartmentprogram($object){
//        
//        if(!$object->getPkDpid()){
//            $prog = new \Application\Entity\Departmentprogram();
//        }else{
//            $prog = $this->em->getRepository("\Application\Entity\Departmentprogram")->find($object->getPkDpid());
//        }
//        
//        //Set user object values to be saved
//        $prog->setFkDepartmentid($object->getFkDepartmentid());
//        $prog->setFkProgramid($object->getFkProgramid());
//        
//        try{
//            //Commit values set to the object 
//            if(!$object->getPkDpid()){
//                $this->em->persist($prog);
//            }
//            
//            //Save values if just updating record
//            $this->em->flush($prog);
//            return $prog;
//            
//        }catch(Exception $e){
//            throw($e->getMessages());
//        }
//    }
//    
//    /*
//     * Save module object
//     */
//    public function saveModule($object){
//        
//        if(!$object->getPkModuleid()){
//            $eo = new \Application\Entity\Module();
//        }else{
//            $eo = $this->em->getRepository("\Application\Entity\Module")->find($object->getPkModuleid());
//        }
//        
//        //Set user object values to be saved
//        $eo->setModuleCode($object->getModuleCode());
//        $eo->setModuleName($object->getModuleName());
//        
//        try{
//            //Commit values set to the object 
//            if(!$object->getPkModuleid()){
//                $this->em->persist($eo);
//            }
//            
//            //Save values if just updating record
//            $this->em->flush($eo);
//            return $eo;
//            
//        }catch(Exception $e){
//            throw($e->getMessages());
//        }
//    }
//    
//    
//    /*
//     * Save class object
//     */
//    public function saveClass($object){
//        
//        if(!$object->getPkGroupid()){
//            $eo = new \Application\Entity\Programgroup();
//        }else{
//            $eo = $this->em->getRepository("\Application\Entity\Programgroup")->find($object->getPkGroupid());
//        }
//        
//        
//        $eo->setGroupCode($object->getGroupCode());
//        $eo->setGroupName($object->getGroupName());
//        $eo->setLevel($object->getLevel());
//        $eo->setFkProgramid($object->getFkProgramid());
//        
//        try{
//            //Commit values set to the object 
//            if(!$object->getPkGroupid()){
//                $this->em->persist($eo);
//            }
//            
//            //Save values if just updating record
//            $this->em->flush($eo);
//            return $eo;
//            
//        }catch(Exception $e){
//            throw($e->getMessages());
//        }
//    }
//    
//    
//    /*
//     * Save class object
//     */
//    public function saveLecturerModule($object){
//        
//        if(!$object->getPkLmid()){
//            $eo = new \Application\Entity\Lecturermodule();
//        }else{
//            $eo = $this->em->getRepository("\Application\Entity\Lecturermodule")->find($object->getPkLmid());
//        }
//        
//        $eo->setFkCcid($object->getFkCcid());
//        $eo->setFkStaffid($object->getFkStaffid());
//        
//        try{
//            //Commit values set to the object 
//            if(!$object->getPkLmid()){
//                $this->em->persist($eo);
//            }
//            
//            //Save values if just updating record
//            $this->em->flush($eo);
//            return $eo;
//            
//        }catch(Exception $e){
//            throw($e->getMessages());
//        }
//    }
//    
//    /*
//     * Allocate module to class object
//     */
//    public function allocateClassModule($object){
//        
//        if(!$object->getPkCcid()){
//            $eo = new \Application\Entity\Classmodule();
//        }else{
//            $eo = $this->em->getRepository("\Application\Entity\Classmodule")->find($object->getPkCcid());
//        }
//        
//       
//        $eo->setExamweight($object->getExamweight());
//        $eo->setCwkweight($object->getCwkweight());
//        $eo->setFkGroupid($object->getFkGroupid());
//        $eo->setFkModuleid($object->getFkModuleid());
//        $eo->setFkPeriodid($object->getFkPeriodid());
//        $eo->setIscore($object->getIscore());
//        $eo->setParentid($object->getParentid());
//         
//        try{
//            
//            //Commit values set to the object 
//            if(!$object->getPkCcid()){
//                $this->em->persist($eo);
//            }
//
//            //Save values if just updating record
//            $this->em->flush($eo);
//            
//            return $eo;
//            
//        }catch(Exception $e){
//            
//            throw($e->getMessages());
//        }
//    }
    
    
}
