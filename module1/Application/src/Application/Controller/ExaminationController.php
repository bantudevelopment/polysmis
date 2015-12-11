<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Doctrine\Common\Collections\Criteria;
use Zend\Session\Container;

class ExaminationController extends AbstractActionController
{
    protected $em;
    //protected $am;
    protected $request;
    protected $response;
    protected $exams;
    protected $userid;
    protected $examsession;
    protected $acl;


    public function __construct(\Doctrine\ORM\EntityManager $em) {
        $this->examsession = new Container('EXAM');
        $this->em               = $em;
        $this->response         = $this->getResponse();
        $this->request          = $this->getRequest();
        $this->exams            = new \Application\Model\Examinations($em);
        
    }
    
    public function onDispatch(\Zend\Mvc\MvcEvent $e) {
        
//        $this->authservice = new AuthenticationService();
//        if(!$this->authservice->hasIdentity()){
//            $this->redirect()->toRoute("login",array('action'=>'index'));
//        }
//        $identity           = $this->authservice->getIdentity();
//        
//        $this->userid       = $identity['pkUserid'];
        $this->layout()->setVariables(array("activemodule"=>$this->getEvent()->getRouteMatch()->getMatchedRouteName()));
        parent::onDispatch($e);
    }
    
    public function indexAction()
    {
        return new ViewModel(array("acl"=>  $this->acl));
    }
    public function exammanagementAction()
    {
        $modules = $this->exams->getLecturerModules($this->userid);
        return new ViewModel(array("modules"=>$modules,"acl"=>  $this->acl));
    } 
    
    public function capturegradesAction()
    {
        $frm           = new \Application\Form\Assessment($this->em);
        $formimport    = new \Application\Form\Groupenrollment();
        
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        
        //Get modules details
        $module = $this->em->getRepository('\Application\Entity\Classmodule')->find($id);
        
        //Get staff information
        $staff = $this->em->getRepository('\Application\Entity\Staff')->findOneBy(array('fkUserid'=>$this->userid));
        
        //Get assessments
        $assessments = $this->em->getRepository('\Application\Entity\Assessmentitem')->findBy(array('fkCcid'=>$id));
        
        $viewModel = new ViewModel();
        
        //Disable layout if request by ajax
        $viewModel->setTerminal($this->request->isXmlHttpRequest());
        $is_xmlhttprequest = 1;
        
        return new ViewModel(array("module"=>$module,
                                   "is_xmlhttprequest" =>$is_xmlhttprequest,
                                   "staff"  => $staff,
                                   "assessments"=>$assessments,
                                   "form"=>$frm,
                                   "formimport"=>$formimport,
                                   "action"=>"createassessment",
                                   "confirmaction"=>"deleteassessment",
                                   "controller"=>"examination"));
    } 
    
    public function importassessmentsAction() {
       $formimport    = new \Application\Form\Groupenrollment();
       $id = $this->getEvent()->getRouteMatch()->getParam('id');
       //Get modules details
       $module = $this->em->getRepository('\Application\Entity\Classmodule')->find($id);
       
       //Get assessment types
       $types = $this->em->getRepository('\Application\Entity\Assessmenttype')->findBy(array("systemGenerated"=>0));
       
       
       if($this->request->getPost('btnupload')){
            $post = array_merge_recursive(
                            $this->request->getPost()->toArray(),
                            $this->request->getFiles()->toArray()
                    );
            $formimport->setData($post);
            
            if($formimport->isValid()){
                $validator = new \Zend\Validator\File\Extension('csv');
                if($validator->isValid($post['File']['filename'])){
                    
                    $uploadfile      = $formimport->getData();
                    $filecontent     = $uploadfile['File']['filename']['tmp_name'];
                    $handle          = fopen($filecontent, "r");

                    while (($rowdata = fgetcsv($handle, 1000, ",")) !== FALSE){
                        //Process validation class/group, academic period, entry manner, study mode
                        $contents[]   = $this->exams->formatFileImport($rowdata,$post['fkCcid']);
                    }
                    
                    $this->examsession->importlist = $contents;
                    
                    return $this->redirect()->toRoute("examination",array("action"=>"confirmimport","id"=>$post['fkCcid']));
                }
               
            }
            
       }
       
       return new ViewModel(array("uploadform"=>$formimport,"module"=>$module,"assessmenttypes"=>$types));
    }
    
    public function confirmimportAction(){
        $list = $this->examsession->importlist;
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        return new ViewModel(array("list"=>$list,"id"=>$id));
    }
    
    public function discardimportAction(){
        $this->examsession->getManager()->getStorage()->clear('EXAM');
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        return $this->redirect()->toRoute("examination",array("action"=>"capturegrades","id"=>$id));
    }
    
    function saveassessmentimportAction(){
        $list = $this->examsession->importlist;
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        foreach ($list as $content){
           //Check errors
           if($content['ISHEADER'] && empty($content['ERRORS'])){
               //Assign item object
               $assessmentitem = $content['ASSESSMENTOBJECT'];
               //If assessment item doesnt exist, create one
               if(!$content['EXISTS']){
                   
                    $item = new \Application\Entity\Assessmentitem(); 
                    
                    //Get staff object
                    $staff              = $this->em->getRepository('\Application\Entity\Staff')->findOneBy(array('fkUserid'=>$this->userid));
                    //Get course object
                    $course             = $this->em->getRepository('\Application\Entity\Classmodule')->find($id);
                    //Get assessment type object
                    $assessmenttype     = $this->em->getRepository('\Application\Entity\Assessmenttype')->findOneBy(array("typeCode"=>$content[1]));
                      //Save entity object
                    $item->setAssessmentTitle($content[0]);
                    $item->setShortName($content[2]);
                    $item->setCreatedon(new \DateTime());
                    $item->setFkAtid($assessmenttype);
                    $item->setFkCcid($course);
                    $item->setFkStaffid($staff);
                    $item->setWeighting($content[3]);

                    $assessmentitem  =  $this->exams->saveAssessmentItem($item); 
               }
           }elseif($content['ISHEADER'] && !empty($content['ERRORS'])){
               $assessmentitem = "";
           }elseif(!$content['ISHEADER'] && empty($content['ERRORS']) && !empty($assessmentitem)){
                //Get student object 
             
                $fkStudentid   =  $this->em->getRepository('\Application\Entity\Student')->find($content['STUDENT']);
                 //Get user object 
                $Userid   =  $this->em->getRepository('\Application\Entity\User')->find($this->userid);
                
                $marks = new \Application\Entity\Studentmark();
                //Save as marks
                $marks->setExamdate(new \DateTime());
                $marks->setFkAiid($assessmentitem);
                $marks->setFkStudentid($fkStudentid);
                $marks->setMark($content[1]);
                $marks->setMarkLevel(1);
                $marks->setPublishStatus('0');
                $marks->setUploadby($Userid);

                $this->exams->saveMarks($marks);  
           }
        }
         $this->examsession->getManager()->getStorage()->clear('EXAM');
         //Redirect to enrollment page
         $this->flashMessenger()->addSuccessMessage("Students successfully enrolled");
         return $this->redirect()->toRoute("examination",array("action"=>"capturegrades","id"=>$id));
    }

    public function resultsAction(){
        $subjects = array();
        $module = "";
        //This is just a dummy form to enable the view access form elements
        $frm           = new \Application\Form\Assessment($this->em);
        
        //Get all current academic periods
        $groups = $this->em->getRepository('\Application\Entity\Programgroup')->findAll();
        $selectedgroup = $this->request->getPost('group');
        
         $viewModel = new ViewModel();
        
        //Disable layout if request by ajax
        $viewModel->setTerminal($this->request->isXmlHttpRequest());
        $is_xmlhttprequest = 1;

        if($selectedgroup){
            //Get module details
            $module = $this->em->getRepository('\Application\Entity\Programgroup')->find($selectedgroup);
            //Get current period for the class
            $period = $this->exams->getCurrentPeriod($selectedgroup);

            //Get aggregate students
            $subjects = $this->exams->getSubjectSummary($period,$selectedgroup);
        }
        
        return new ViewModel(array("groups"=>$groups,
                                   "modules"=>$subjects,
                                   "selectedgroup"=>$module,
                                   "is_xmlhttprequest"=>$is_xmlhttprequest,
                                   "form"=>$frm,
                                   "period"=>$period,
                                   "controller"=>"examination",
                                   "confirmaction"=>"computeaverage"));
    }
    
    public function publishexamsAction(){
        
        return new ViewModel();
    }
    
    public function computeaverageAction(){
        //sleep(5);
        $post = $this->request->getPost();
        // Get class list
        $students = $this->em->getRepository('\Application\Entity\Studentclass')->findBy(array("fkGroupid"=>$post['itemid'],"fkPeriodid"=>$post['periodid']));
        // Get modules
        $modules  = $this->em->getRepository('\Application\Entity\Classmodule')->findBy(array("fkGroupid"=>$post['itemid'],"fkPeriodid"=>$post['periodid']));
        foreach($students as $student){
            $total = 0;
            $activemodules =0;
            
            //Get class courses
            foreach($modules as $module){
                //Get all assessments
                $assessments = $this->em->getRepository('\Application\Entity\Assessmentitem')->findBy(array("fkCcid"=>$module->getPkCcid()));
                foreach($assessments as $assessment){
                    if( $assessment->getFkAtid()->getSystemGenerated()== 1){
                        //Get one student mark for the course
                        $studentmark = $this->em->getRepository('\Application\Entity\Studentmark')->findOneBy(array("fkAiid"=>$assessment->getPkAiid(),"fkStudentid"=>$student->getFkStudentid()->getPkStudentid()));
                        if(count($studentmark) == 1){
                            $total += $studentmark->getMark();
                            $activemodules++;
                        }
                    }
                }
            }
            if($total!=0){
                $average = round(($total/$activemodules),0);
                //Set mean entity object
                $averageEntity = new \Application\Entity\Studentmeangrade();
                
                //Check existance of average mark
                $entityExist   = $this->em->getRepository('\Application\Entity\Studentmeangrade')->findOneBy(array("fkStudentid"=>$student->getFkStudentid()->getPkStudentid(),"fkPeriodid"=>$student->getFkPeriodid()->getPkPeriodid(),"fkGroupid"=>$student->getFkGroupid()->getPkGroupid())); 
                if(count($entityExist) == 1){
                    $averageEntity = $entityExist;
                }
                
                $averageEntity->setFg($average);
                $averageEntity->setFkGroupid($student->getFkGroupid());
                $averageEntity->setFkPeriodid($student->getFkPeriodid());
                $averageEntity->setGradeComment('PASS');
                $averageEntity->setFkStudentid($student->getFkStudentid());
                $averageEntity->setPreviousGradeComment("");
                //Save average
                $this->exams->saveMeanGrade($averageEntity);
            }
            
        }
        
        echo json_encode(array("processed"=>1,"msg"=>"Process completed successfully"));
        //echo "Here";
        die();
    }
    
    public function deleteassessmentAction()
    {
        $post      = $this->request->getPost();
        if(!empty($post['itemid'])){
            $examModel = new \Application\Model\Examinations($this->em);

            $items = $this->em->getRepository('\Application\Entity\Studentmark')->findBy(array("fkAiid"=>$post['itemid']));
            if(count($items) > 0){
                foreach($items as $item){
                    $examModel->deletefromdb('\Application\Entity\Studentmark', $item->getPkSmid());
                }
            }

            $examModel->deletefromdb('\Application\Entity\Assessmentitem', $post['itemid']);
            echo json_encode(array("success"=>1,"msg"=>"Item successfully deleted"));
        }else{
            echo json_encode(array("success"=>0,"msg"=>"Action failed. Please try again.."));
        }
        die();
    }
    
    
    
    public function createassessmentAction()
    {
        //Instatiate department form
        $frmassessment = new \Application\Form\Assessment($this->em);
        
        $frmassessment->bind($this->request->getPost());
        
        if ($this->request->isPost()) {
             $data['Assessment']['assessmentTitle']  = $this->request->getPost('assessmentTitle');
             $data['Assessment']['fkStaffid']        = $this->request->getPost('fkStaffid');
             $data['Assessment']['fkAtid']           = $this->request->getPost('fkAtid');
             $data['Assessment']['pkAiid']           = $this->request->getPost('pkAiid');
             $data['Assessment']['fkCcid']           = $this->request->getPost('fkCcid');
             $data['Assessment']['weighting']        = $this->request->getPost('weighting');
            
            $frmassessment->setData($data);

            if($frmassessment->isValid()){
                //Save department
                $post = $frmassessment->getData();
                $item = new \Application\Entity\Assessmentitem();
                
                //Check if action is to modify department
                if($post['pkAiid']){
                    $item = $this->em->getRepository('\Application\Entity\Assessmentitem')->find($post['pkAiid']);
                }
                
                //Get staff object
                $staff              = $this->em->getRepository('\Application\Entity\Staff')->find($post['fkStaffid']);
                //Get course object
                $course             = $this->em->getRepository('\Application\Entity\Classmodule')->find($post['fkCcid']);
                //Get assessment type object
                $assessmenttype     = $this->em->getRepository('\Application\Entity\Assessmenttype')->find($post['fkAtid']);
                
                
                //Save entity object
                $item->setAssessmentTitle($post['assessmentTitle']);
                $item->setCreatedon(new \DateTime());
                $item->setFkAtid($assessmenttype);
                $item->setFkCcid($course);
                $item->setFkStaffid($staff);
                $item->setWeighting($post['weighting']);
                
                $obj  =  $this->exams->saveAssessmentItem($item);
                if(count($obj)){
                    echo json_encode(array("success"=>1,"msg"=>"Item successfully created"));
                }else{
                    echo json_encode(array("success"=>0,"msg"=>"Action failed"));
                }
            }else{
                
                $messages = $this->exams->formatErrorMessage($frmassessment->getMessages());
                echo json_encode(array("success"=>0,"msg"=> $messages));
            }
        }
        die();
    }
    
    public function computegradesAction()
    {
        $frm = new \Application\Form\Assessment($this->em);
        
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        
        //Get list of assessment items for the subject
        $assessmentitems = $this->exams->getAssessmentitems($id);
        $assignmentid    = $this->request->getPost('fkAiid');
        $saveaverage     = $this->request->getPost('saveaverage');

           foreach($assessmentitems as $assessment){ 
            $weighting      = (!empty($assignmentid) && $assessment->getFkAtid()->getTypeCode() !='EXAM')?
                                    $assignmentid[$assessment->getPkAiid()]:
                                    $assessment->getWeighting();
            $assessments[]  = array("WEIGHTING"     =>$weighting,
                                    "TYPECODE"      =>$assessment->getFkAtid()->getTypeCode(),
                                    "CWKWEIGHT"     =>$assessment->getFkCcid()->getCwkweight(),
                                    "EXAMWEIGHT"    =>$assessment->getFkCcid()->getExamweight(),
                                    "SHORTNAME"     =>$assessment->getShortName(),
                                    "ASSESSMENTID"  =>$assessment->getPkAiid(),
                                   ); 
           }  
        
         //Get subject details
        $module = $this->em->getRepository('\Application\Entity\Classmodule')->find($id);  
           
         if($saveaverage){
             //Save changed weightings for each assignment
             foreach($assignmentid as $assessmentitem=>$weight){
                 $assessment = $this->em->getRepository('\Application\Entity\Assessmentitem')->find($assessmentitem);
                 $assessment->setWeighting($weight);
                 $this->exams->saveAssessmentItem($assessment);
             }
             
             $students       = $this->request->getPost('studentaveragemark');
             
             $item           = new \Application\Entity\Assessmentitem();
             
             //Get assignment type code where system generated value is 1
             $assessmenttype = $this->em->getRepository('\Application\Entity\Assessmenttype')->findOneBy(array("systemGenerated"=>1));
             
             //Get satffid
             $staff          = $this->em->getRepository('\Application\Entity\Staff')->findOneBy(array("fkUserid"=>  $this->userid));

             //Save assessment entity object
             $item->setAssessmentTitle('Average');
             $item->setCreatedon(new \DateTime());
             $item->setFkAtid($assessmenttype);
             $item->setFkCcid($module);
             $item->setFkStaffid($staff);
             $item->setWeighting(100);
                
             $obj  =  $this->exams->saveAssessmentItem($item);
             
             //Save each student mark
             foreach($students as $student=>$mark){
                 
                //Get student object 
                $fkStudentid   =  $this->em->getRepository('\Application\Entity\Student')->find($student);
                
                 //Get user object 
                $Userid   =  $this->em->getRepository('\Application\Entity\User')->find($this->userid);
                
                $marks = new \Application\Entity\Studentmark();
                //Save as marks
                $marks->setExamdate(new \DateTime());
                $marks->setFkAiid($obj);
                $marks->setFkStudentid($fkStudentid);
                $marks->setMark($mark);
                $marks->setMarkLevel(1);
                $marks->setPublishStatus('0');
                $marks->setUploadby($Userid);

                $this->exams->saveMarks($marks);
             } 
             
             $this->redirect()->toRoute("examination",array("action"=>"exammanagement"));
         }  
        
        //Get students and marks allocated
        $students    = $this->exams->getStudentAssessmentMarks($id);
        
        return new ViewModel(array("assessments"=>$assessments,
                                   "module"     =>$module,
                                   "students"=>$students,
                                   "action"=>"createassessment",
                                   "controller"=>"examination"));
    }
    
    
    public function gradesAction()
    {
        
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $assessmentitem  = $this->em->getRepository('\Application\Entity\Assessmentitem')->find($id);
        $assessmentmarks = $this->em->getRepository('\Application\Entity\Studentmark')->findBy(array('fkAiid'=>$assessmentitem->getPkAiid()));
        $period          = $assessmentitem->getFkCcid()->getFkPeriodid()->getPkPeriodid();
        $group           = $assessmentitem->getFkCcid()->getFkGroupid()->getPkGroupid();
        
        //Create criteria and get list of students
        $searchcriteria = Criteria::create()
                              ->where(Criteria::expr()->eq('fkPeriodid', $assessmentitem->getFkCcid()->getFkPeriodid()))
                              ->andWhere(Criteria::expr()->eq('fkGroupid', $assessmentitem->getFkCcid()->getFkGroupid()));
        
        $students       = $this->exams->getClasslist($searchcriteria); //$this->em->getRepository('\Application\Entity\Studentclass')->findBy(array("fkGroupid"=>$group,"fkPeriodid"=>$period));
        
        $studentmarks   = array();
        
        if($this->request->isPost()){
            
            $mark           = $this->request->getPost('mark');
            $assessmentid   = $this->request->getPost('fkAiid');
            $pkSmid        = $this->request->getPost('pkSmid');
            foreach($this->request->getPost('student') as $key=>$student){
                if(!empty($mark[$key]['mark'])){
                    $marks = new \Application\Entity\Studentmark();
                    if($pkSmid[$key]){
                        $marks = $this->em->getRepository('\Application\Entity\Studentmark')->find($pkSmid[$key]);
                    }

                    $fkStudentid  = $this->em->getRepository('\Application\Entity\Student')->find($student);
                    $fkAiid       = $this->em->getRepository('\Application\Entity\Assessmentitem')->find($assessmentid);
                    $fkUserid     = $this->em->getRepository('\Application\Entity\User')->find($this->userid);

                    $marks->setExamdate(new \DateTime());
                    $marks->setFkAiid($fkAiid);
                    $marks->setFkStudentid($fkStudentid);
                    $marks->setMark($mark[$key]['mark']);
                    $marks->setMarkLevel(1);
                    $marks->setPublishStatus('0');
                    $marks->setUploadby($fkUserid);

                    $this->exams->saveMarks($marks);
                }
            }
            $this->redirect()->toRoute("examination",array("action"=>"capturegrades","id"=>$assessmentitem->getFkCcid()->getPkCcid()));
        }
        
        
        foreach($assessmentmarks as $assessmentmark){
            $studentmarks[$assessmentmark->getFkStudentid()->getPkStudentid()]   =  array("mark"=>$assessmentmark->getMark(),"id"=>$assessmentmark->getPkSmid()); 
        }
    
        //Get form
        $frmgrades      = new \Application\Form\Grades(count($students),  $this->em);
        return new ViewModel(array("students"=>$students,
                                   "frmgrades"=>$frmgrades,
                                   "marks"    =>$studentmarks,
                                   "assessment"=>$assessmentitem));
    }
    public function uploadgradesAction()
    {
        return new ViewModel();
    }      
}