<?php
namespace Application\Model;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Student
 *
 * @author hkumwembe
 */
class Student extends Usermodel {
    
    
  public function registerUser(){
      
      //Save user in user table
      
      //Save in students table
      
      //Assign to class
      
      //Assign to program  
  }


  /*
     * Allocate user student to group/class
     */
    public function allocate($object) {

        //Save user
        $user = $this->saveUserObject($object['user']);

        //Set student object
        $object['student']['user'] = $user;
        $studentobject = $this->setStudentObject($object['student']);
        //Save student object
        $student = $this->saveStudent($studentobject);
        
        //Set object
        $object['program']['student'] = $student;
        $programobject      = $this->setStudentProgramObject($object['program']);
        //Save in student program table
        $this->saveStudentProgram($programobject);
        
        //Set object
        $object['class']['student'] = $student;
        $classobject        = $this->setStudentClassObject($object['class']);
        //Save in student class table
        $this->saveStudentClass($classobject);
        
         //Set object
        
        if(!empty($object['contacts'])){
            $object['contacts']['student'] = $student;
            $contactobject        = $this->setStudentContactObject($object['contacts']);
            //Save in student contact table
            $this->saveStudentContact($contactobject);
        }
        //Set object
        if(!empty($object['guardian'])){
            $object['guardian']['student'] = $student;
            $guardianobject        = $this->setGuardianObject($object['guardian']);
            //Save in guardian table
            $this->saveGuardian($guardianobject);
        }
        
        if(!empty($object['employment'])){
            //Set object
            $object['employment']['student'] = $student;
            $employmentobject        = $this->setEmploymentObject($object['employment']);
            //Save in employment table
            $this->saveEmployment($employmentobject);
        }
        
        return $student;
    }
    
    /*
     * Save student details in student table
     */
    public function saveStudent($studentobject){
        
        if(!$studentobject->getPkStudentid()){
            $student = new \Application\Entity\Student();
        }else{
            $criteria = Criteria::create()
                        ->where(Criteria::expr()->eq("pkStudentid", $studentobject->getPkStudentid()));
            $student = $this->getEntity("\Application\Entity\Student", $criteria);
        }
        
        //Set user object values to be saved
        $student->setDob($studentobject->getDob());
        $student->setFkCountryid($studentobject->getFkCountryid());
        $student->setFkDistrictid($studentobject->getFkDistrictid());
        $student->setFkUserid($studentobject->getFkUserid()) ;
        $student->setMaritalStatus($studentobject->getMaritalStatus());
        
        try{
            //Commit values set to the object 
            if(!$studentobject->getPkStudentid()){
                $this->em->persist($student);
            }
            
            //Save values if just updating record
            $this->em->flush($student);
            return $student;
            
        }catch(Doctrine\ORM\ORMException $e){
            throw($e->getMessage());
        }
    }
    
    /*
     * Sets student object values
     */
    public function setStudentObject($arrayval){
        //Set parameters
        $object = new \Application\Entity\Student();
        
        $object->setFkUserid($arrayval['user']);
        $object->setDob($arrayval['dob']);
        $object->setFkCountryid($arrayval['country']);
        $object->setFkDistrictid($arrayval['district']);
        $object->setMaritalStatus($arrayval['maritalstatus']);
        
        return $object;
    }
    
    
    /*
     * Save student program detail in student program table
     */
    public function saveStudentProgram($programobject){
        
        if(!$programobject->getPkStudentprogramid()){
            $studentprogram = new \Application\Entity\Studentprogram();
        }else{
            $criteria = Criteria::create()
                        ->where(Criteria::expr()->eq("pkStudentprogramid", $programobject->getPkStudentprogramid()));
            $studentprogram = $this->getEntity("\Application\Entity\Studentprogram", $criteria);
        }
        
        //Set student program object values to be saved
        $studentprogram->setEntryYear($programobject->getEntryYear());
        $studentprogram->setFkEntrymannerid($programobject->getFkEntrymannerid());
        $studentprogram->setFkProgramid($programobject->getFkProgramid());
        $studentprogram->setFkStudentid($programobject->getFkStudentid());
        $studentprogram->setRegistrationNumber($programobject->getRegistrationNumber());
        $studentprogram->setRepeatingLevel($programobject->getRepeatingLevel());
        
        try{
            //Commit values set to the object 
            if(!$programobject->getPkStudentprogramid()){
                $this->em->persist($studentprogram);
            }
            
            //Save values if just updating record
            $this->em->flush($studentprogram);
            return $studentprogram;
            
        }catch(Doctrine\ORM\ORMException $e){
            throw($e->getMessage());
        }
        
    }
    
    /*
     * Sets student program object values
     */
    public function setStudentProgramObject($arrayval){
        //Set parameters
        $object = new \Application\Entity\Studentprogram();
        
        $object->setFkEntrymannerid($arrayval['entrymanner']);
        $object->setEntryYear($arrayval['entryyear']);
        $object->setFkProgramid($arrayval['program']);
        $object->setFkStudentid($arrayval['student']);
        $object->setRepeatingLevel($arrayval['repeatinglevel']);
        $object->setRegistrationNumber($arrayval['registrationnumber']);
        
        return $object;
    }
    
    /*
     * Save class detail in student class table
     */
    public function saveStudentClass($classobject){
        
         if(!$classobject->getPkStudentclassid()){
            $studentclass = new \Application\Entity\Studentclass();
        }else{
            $criteria = Criteria::create()
                        ->where(Criteria::expr()->eq("pkStudentclassid", $classobject->getPkStudentclassid()));
            $studentclass = $this->getEntity("\Application\Entity\Studentclass", $criteria);
        }
        
        //Set student class object values to be saved
       $studentclass->setExamNumber($classobject->getExamNumber());
       $studentclass->setFkCampusid($classobject->getFkCampusid());
       $studentclass->setFkGroupid($classobject->getFkGroupid());
       $studentclass->setFkPeriodid($classobject->getFkPeriodid());
       $studentclass->setFkStudentid($classobject->getFkStudentid());
       $studentclass->setIsregistered($classobject->getIsregistered());
       $studentclass->setFkStudyModeid($classobject->getFkStudyModeid());
       $studentclass->setRegistrationdate($classobject->getRegistrationdate());
        
        try{
            //Commit values set to the object 
            if(!$classobject->getPkStudentclassid()){
                $this->em->persist($studentclass);
            }
            
            //Save values if just updating record
            $this->em->flush($studentclass);
            return $studentclass;
            
        }catch(Doctrine\ORM\ORMException $e){
            throw($e->getMessage());
        }
    }
    
    
    /*
     * Sets student class object values
     */
    public function setStudentClassObject($arrayval){
        //Set parameters
        $object = new \Application\Entity\Studentclass();
        
        $object->setExamNumber($arrayval['examnumber']);
        $object->setFkCampusid($arrayval['campus']);
        $object->setFkGroupid($arrayval['class']);
        $object->setFkPeriodid($arrayval['period']);
        $object->setFkStudentid($arrayval['student']);
        $object->setIsregistered($arrayval['isregistered']);
        $object->setFkStudyModeid($arrayval['studymode']);
        $object->setRegistrationdate($arrayval['registrationdate']);
        
        return $object;
    }
    
    /*
     * Save student pocket
     */
    public function savePocket($pockectobject){
        
    }
    
    /*
     * Save student contacts
     */
    public function saveStudentContact($studentobject){
        
        if(!$studentobject->getPkScid()){
            $student = new \Application\Entity\Studentcontact();
        }else{
            $criteria = Criteria::create()
                        ->where(Criteria::expr()->eq("pkScid", $studentobject->getPkScid()));
            $student = $this->getEntity("\Application\Entity\Studentcontact", $criteria);
        }
        
        //Set user object values to be saved
        $student->setFkStudentid($studentobject->getFkStudentid());
        $student->setMobile($studentobject->getMobile());
        $student->setPhysicalAddress($studentobject->getPhysicalAddress());
        $student->setPostalAddress($studentobject->getPostalAddress()) ;
        $student->setTelephone($studentobject->getTelephone());
        
        try{
            //Commit values set to the object 
            if(!$studentobject->getPkScid()){
                $this->em->persist($student);
            }
            
            //Save values if just updating record
            $this->em->flush($student);
            return $student;
            
        }catch(Doctrine\ORM\ORMException $e){
            throw($e->getMessage());
        }
    }
    
    /*
     * Sets student contacts object values
     */
    public function setStudentContactObject($arrayval){
        //Set parameters
        $object = new \Application\Entity\Studentcontact();
        
        $object->setFkStudentid($arrayval['student']);
        $object->setMobile($arrayval['mobile']);
        $object->setPhysicalAddress($arrayval['physicalAddress']);
        $object->setPostalAddress($arrayval['postalAddress']);
        $object->setTelephone($arrayval['telephone']);
        
        return $object;
    }
    
    /*
     * Save student guardian
     */
    public function saveGuardian($studentobject){
        
        if(!$studentobject->getPkGuadianid()){
            $student = new \Application\Entity\Guardian();
        }else{
            $criteria = Criteria::create()
                        ->where(Criteria::expr()->eq("pkGuadianid", $studentobject->getPkGuadianid()));
            $student = $this->getEntity("\Application\Entity\Guardian", $criteria);
        }
        
        //Set user object values to be saved
        $student->setFkStudentid($studentobject->getFkStudentid());
        $student->setMobile($studentobject->getMobile());
        $student->setSurname($studentobject->getSurname());
        $student->setFirstname($studentobject->getFirstname());
        $student->setTitle($studentobject->getTitle());
        $student->setRelationship($studentobject->getRelationship());
        $student->setIsnextofkin($studentobject->getIsnextofkin());
        $student->setPostalAddress($studentobject->getPostalAddress()) ;
        $student->setTelephoneNumber($studentobject->getTelephoneNumber());
        $student->setEmailAddress($studentobject->getEmailAddress());
        
        try{
            //Commit values set to the object 
            if(!$studentobject->getPkGuadianid()){
                $this->em->persist($student);
            }
            
            //Save values if just updating record
            $this->em->flush($student);
            return $student;
            
        }catch(Doctrine\ORM\ORMException $e){
            throw($e->getMessage());
        }
    }
    
    /*
     * Sets student guardian object values
     */
    public function setGuardianObject($arrayval){
        //Set parameters
        $object = new \Application\Entity\Guardian();
        
        $object->setFkStudentid($arrayval['student']);
        $object->setSurname($arrayval['surname']);
        $object->setFirstname($arrayval['firstname']);
        $object->setTitle($arrayval['title']);
        $object->setMobile($arrayval['mobile']);
        $object->setPostalAddress($arrayval['postalAddress']);
        $object->setRelationship($arrayval['relationship']);
        $object->setEmailAddress($arrayval['emailAddress']);
        $object->setIsnextofkin($arrayval['isnextofkin']);
        $object->setTelephoneNumber($arrayval['telephoneNumber']);
        
        return $object;
    }
    
    
    
    
    /*
     * Set student emploment
     */
    public function saveEmployment($studentobject){
        
        if(!$studentobject->getPkEmploymentid()){
            $student = new \Application\Entity\Employment();
        }else{
            $criteria = Criteria::create()
                        ->where(Criteria::expr()->eq("pkEmploymentid", $studentobject->getPkEmploymentid()));
            $student = $this->getEntity("\Application\Entity\Employment", $criteria);
        }
        
        //Set user object values to be saved
        $student->setFkStudentid($studentobject->getFkStudentid());
        $student->setDesignation($studentobject->getDesignation());
        $student->setOrganization($studentobject->getOrganization());
        $student->setEndYear($studentobject->getEndYear());
        $student->setStartYear($studentobject->getStartYear());
        $student->setIsCurrent($studentobject->getIsCurrent());
        
        
        try{
            //Commit values set to the object 
            if(!$studentobject->getPkEmploymentid()){
                $this->em->persist($student);
            }
            
            //Save values if just updating record
            $this->em->flush($student);
            return $student;
            
        }catch(Doctrine\ORM\ORMException $e){
            throw($e->getMessage());
        }
    }
    
    /*
     * Sets student guardian object values
     */
    public function setEmploymentObject($arrayval){
        //Set parameters
        $object = new \Application\Entity\Employment();
        
        $object->setFkStudentid($arrayval['student']);
        $object->setDesignation($arrayval['designation']);
        $object->setOrganization($arrayval['organization']);
        $object->setStartYear($arrayval['startYear']);
        $object->setEndYear($arrayval['endYear']);
        $object->setIsCurrent($arrayval['isCurrent']);
        
        return $object;
    }
    
    /*
     * Save student module mark 
     */
    public function saveMark($studentmodulemark){
        
    }
    
    /*
     * Save student average 
     */
    public function saveAvearge($studentaverage){
        
    }
    
    function assignModule($moduleparams){
        
    }
}
