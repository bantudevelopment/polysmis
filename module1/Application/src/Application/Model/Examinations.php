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

class Examinations extends Commonmodel {

    protected $em;
    
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        parent::__construct($em);
        $this->em = $em;
    }  
    
    public function getSubjectSummary($period,$group){
        $allocations = $this->em->getRepository('\Application\Entity\Classmodule')->findBy(array("fkPeriodid"=>$period->getPkPeriodid(),"fkGroupid"=>$group));
        
        //Get total number of students in the class
        $currentstudents = $this->em->getRepository('\Application\Entity\Studentclass')->findBy(array("fkPeriodid"=>$period->getPkPeriodid(),"fkGroupid"=>$group));
        $received = 0;
        foreach($allocations as $allocation){
            
            //Get aggregate students
            $query = $this->em->createQuery("SELECT COUNT(M.mark) AS markcount FROM \Application\Entity\Studentmark M"
                                 . " JOIN M.fkAiid A "
                                 . " JOIN A.fkAtid T"
                                 . " WHERE T.systemGenerated = 1"
                                 . " AND A.fkCcid = :course"
                                 . " GROUP BY M.fkAiid")
                    ->setParameter('course', $allocation->getPkCcid());
            if(count($query->getArrayResult())>0){
                
                $result = $query->getOneOrNullResult();
                $received = (!empty($result['markcount'])?$result['markcount']:0);
            }
            $modules[] = array("RECEIVED"=>$received,"TOTAL"=>count($currentstudents),"SUBJECTNAME"=>$allocation->getFkModuleid()->getModuleName(),"SUBJECTCODE"=>$allocation->getFkModuleid()->getModuleCode());
            $received = 0;
            
        }
        return $modules;
    }


    public function getLecturerModules($userid,$period=null){
       $query = $this->em->createQuery("SELECT M FROM \Application\Entity\Lecturermodule M "
                                       . " JOIN M.fkStaffid S "
                                       . " JOIN M.fkCcid P"
                                       . " WHERE S.fkUserid = :user "
                                   //    . " AND   P.fkPeriodid = :period"
                                       . " ORDER BY P.fkPeriodid")
                         ->setParameter('user', $userid);
                   //$query->setParameter('period', $period);
       return $query->getResult();
    }
    
    public function getAssignedModules($period,$group){
        $query = $this->em->createQuery("SELECT L FROM \Application\Entity\Lecturermodule L JOIN L.fkCcid P WHERE P.fkPeriodid = :period AND P.fkGroupid = :group")
                         ->setParameter('period', $period)
                         ->setParameter('group', $group);
        return $query->getResult();
    }
    
    /*
     * Format imported file content
     */
    
    public function formatFileImport($row,$subject){
        $errors = array();
        
        //Get class or groupid
        $courseallocation =  $this->em->getRepository('\Application\Entity\Classmodule')->find($subject);
        
        //Validate data entered
        if(!empty($row[3])){
            
            //Check if assignment alread exists for the subject
            $assessment = $this->em->getRepository('\Application\Entity\Assessmentitem')->findBy(array('assessmentTitle'=>trim($row[0]),"fkCcid"=>$subject));
            $exists = count($assessment)>0?1:0;
           
            //Check if assessment type exists
            $type = $this->em->getRepository('\Application\Entity\Assessmenttype')->findBy(array('typeCode'=>trim($row[1])));
            
            if(!is_numeric($row[3]) || ($row[3]<0 || $row[3]>100)){
                $errors[]  = "The weighting is not numeric or is not between 0-100";
            }
            if(count($type)<=0){
                $errors[]  = "Assessment type does not exists";
            }
 
            $filecontent = array($row[0],$row[1],$row[2],$row[3],"ISHEADER"=>1,"EXISTS"=>$exists,"ERRORS"=>$errors,"ASSESSMENTOBJECT"=>$assessment);
            
        }elseif(empty($row[3])){
            $studentobject = "";
            //Check if student no exists
            $student      = $this->em->getRepository('\Application\Entity\Studentprogram')->findOneBy(array('registrationNumber'=>trim($row[0])));
            //Retrieve student class
            $studentclass = $this->em->getRepository('\Application\Entity\Studentclass')->findOneBy(array('fkGroupid'=>$courseallocation->getFkGroupid()->getPkGroupid(),"fkPeriodid"=>$courseallocation->getFkPeriodid()->getPkPeriodid()));
            //Check if mark is numeric and between 0 and 100 
            if(!is_numeric($row[1]) || ($row[1] < 0 || $row[1] > 100)){
                $errors[]  = "Student mark is not numeric or is not between 0-100";
            }
            
            if(count($student)<=0){
                $errors[]  = "Student registration number does not exist";
            }elseif(count($studentclass)<=0){
                $errors[]  = "Student not assigned module or class";
            }else{
                $studentobject = $student->getFkStudentid()->getPkStudentid();
            }
            
            $filecontent = array($row[0],$row[1],$row[2],$row[3],"ISHEADER"=>0,"EXISTS"=>0,"ERRORS"=>$errors,"STUDENT"=>$studentobject);
        }
        return $filecontent;
    }

    /*
     * Get assessment items
     * @params: courseid
     */
    public function getAssessmentitems($id,$systemgenerated='0'){
        
        $query = $this->em->createQuery("SELECT A FROM \Application\Entity\Assessmentitem A JOIN A.fkAtid I WHERE A.fkCcid = :course AND I.systemGenerated = :systemgenerated")
                         ->setParameter('course', $id)
                         ->setParameter('systemgenerated', $systemgenerated);
        //print_r($query->getSQL());
       // die();
        return $query->getResult();
    }
    
    /*
     * Get assessment items
     * @params: courseid
     */
    public function getStudentAssessmentMarks($id){
        $classstudents = array();
        //Get class module details
        $module  = $this->em->getRepository('\Application\Entity\Classmodule')->find($id);
        //Get list of students
        //$students       = $this->em->getRepository('\Application\Entity\Studentclass')->findBy(array("fkGroupid"=>$module->getFkGroupid()->getPkGroupid(),"fkPeriodid"=>$module->getFkPeriodid()->getPkPeriodid()));
        
        $searchcriteria = Criteria::create()
                              ->where(Criteria::expr()->eq('fkPeriodid', $module->getFkPeriodid()))
                              ->andWhere(Criteria::expr()->eq('fkGroupid', $module->getFkGroupid()));
        
        $students       = $this->getClasslist($searchcriteria);
        
        $assessments   = $this->getAssessmentitems($id);
        
        foreach($students as $student){
            
            //Get list of marks
            foreach($assessments as $assessment){
                //Get actual mark for student
                $mark                         = $this->em->getRepository('\Application\Entity\Studentmark')->findOneBy(array("fkAiid"=>$assessment->getPkAiid(),"fkStudentid"=>$student['CLASS']->getFkStudentid()->getPkStudentid()));
                if(count($mark)){
                   $marks[$assessment->getPkAiid()] = array("MARK"=>$mark->getMark(),"MARKID"=>$mark->getPkSmid());
                }else{
                   $marks[$assessment->getPkAiid()] = array("MARK"=>'');  
                }
            }
            
            $classstudents[] = array("REGISTRATIONNO"  =>$student['PROGRAM']->getRegistrationNumber(),
                                     "SURNAME"  =>$student['CLASS']->getFkStudentid()->getFkUserid()->getSurname(),
                                     "FIRSTNAME"=>$student['CLASS']->getFkStudentid()->getFkUserid()->getFirstname(),
                                     "STUDENTID"=>$student['CLASS']->getFkStudentid()->getPkStudentid(),
                                     "GENDER"   =>$student['CLASS']->getFkStudentid()->getFkUserid()->getGender(),
                                     "MARKS"    =>$marks);
        }        
        return $classstudents;
    }
    
    
    /*
     * 
     */
    public function saveAssessmentItem($object){
        
        if(!$object->getPkAiid()){
            $eo = new \Application\Entity\Assessmentitem();
        }else{
            $eo = $this->em->getRepository("\Application\Entity\Assessmentitem")->find($object->getPkAiid());
        }
        
        $eo->setAssessmentTitle($object->getAssessmentTitle());
        $eo->setCreatedon($object->getCreatedon());
        $eo->setShortName($object->getShortName());
        $eo->setFkAtid($object->getFkAtid());
        $eo->setFkCcid($object->getFkCcid());
        $eo->setFkStaffid($object->getFkStaffid());
        $eo->setWeighting($object->getWeighting());
      
        try{
            //Commit values set to the object 
            if(!$object->getPkAiid()){
                $this->em->persist($eo);
            }

            //Save values if just updating record
            $this->em->flush($eo);
            
            return $eo;
            
        }catch(Exception $e){
            
            throw($e->getMessages());
        }
    }
    
    /*
     * 
     */
    public function saveMarks($object){
        
        if(!$object->getPkSmid()){
            $eo = new \Application\Entity\Studentmark();
        }else{
            $eo = $this->em->getRepository("\Application\Entity\Studentmark")->find($object->getPkSmid());
        }
        
       
        $eo->setExamdate($object->getExamdate());
        $eo->setFkAiid($object->getFkAiid());
        $eo->setFkStudentid($object->getFkStudentid());
        $eo->setMark($object->getMark());
        $eo->setMarkLevel($object->getMarkLevel());
        $eo->setPublishStatus($object->getPublishStatus());
        $eo->setUploadby($object->getUploadby());
         
        try{
            
            //Commit values set to the object 
            if(!$object->getPkSmid()){
                $this->em->persist($eo);
            }

            //Save values if just updating record
            $this->em->flush($eo);
            
            return $eo;
            
        }catch(Exception $e){
            
            throw($e->getMessages());
        }
    }
    
    /*
     * 
     */
    public function saveMeanGrade($object){
        
        if(!$object->getPkSmg()){
            $eo = new \Application\Entity\Studentmeangrade();
        }else{
            $eo = $this->em->getRepository("\Application\Entity\Studentmeangrade")->find($object->getPkSmg());
        }
        
        $eo->setFg($object->getFg());
        $eo->setFkGroupid($object->getFkGroupid());
        $eo->setFkStudentid($object->getFkStudentid());
        $eo->setFkPeriodid($object->getFkPeriodid());
        $eo->setGradeComment($object->getGradeComment());
        $eo->setPreviousGradeComment($object->getPreviousGradeComment());
        try{
            
            //Commit values set to the object 
            if(!$object->getPkSmg()){
                $this->em->persist($eo);
            }

            //Save values if just updating record
            $this->em->flush($eo);
            
            return $eo;
            
        }catch(Exception $e){
            throw($e->getMessages());
        }
    }
    
    
    
    
}
