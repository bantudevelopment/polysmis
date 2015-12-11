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
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\ArrayCollection;
use DoctrineModule\Paginator\Adapter\Collection as Adapter;
use Zend\Paginator\Paginator;
use Zend\Session\Container;
use Zend\Authentication\AuthenticationService;

class AdmissionController extends AbstractActionController
{
     protected $em;
     protected $am;
     protected $request;
     protected $admission;
     protected $userid;
     protected $admissionsession;

     public function __construct(\Doctrine\ORM\EntityManager $em,\Application\Model\Admission $am) {
        $this->admissionsession = new Container('ADMISSION');
        $this->em               = $em;
        $this->am               = $am;
        $this->request          = $this->getRequest();
        $this->admission        = new \Application\Model\Admission($this->em); 
    }
    
    public function onDispatch(\Zend\Mvc\MvcEvent $e) {
        
//        $this->authservice = new AuthenticationService();
//        if(!$this->authservice->hasIdentity()){
//            $this->redirect()->toRoute("login",array('action'=>'index'));
//        }
//        
//        $identity           = $this->authservice->getIdentity();
//        
//        $this->userid       = $identity['pkUserid'];
        
        $this->layout()->setVariables(array("activemodule"=>$this->getEvent()->getRouteMatch()->getMatchedRouteName()));
        parent::onDispatch($e);
    }
    
    public function indexAction()
    {
        return new ViewModel();
    }
    
    /*
     * Auto register students
     */
    function autoregisterAction(){ 
        $students = $this->request->getPost('chkStudentid');
        
        foreach($students as $enrollmentid){
            //Get student enrolled details
            $this->admission->autoregisterstudent($enrollmentid);
        }
        
        $this->redirect()->toRoute("admission",array("action"=>"enrollment"));
    }


    //Emrollment 
    function enrollmentAction(){  
        return new ViewModel($this->admission->getEnrolledList($this->request->getPost()));
    }
    
    function groupenrollmentAction(){
        $criteria = Criteria::create();
        
        $formfile = new \Application\Form\Groupenrollment();
        
        //Get entry manner
        $entrymanners = $this->admission->getEntity("\Application\Entity\Entrymanner",$criteria);
        //Get Study mode
        $studymodes   = $this->admission->getEntity("\Application\Entity\Studymode",$criteria);
        //Academic period
        $acperiod     = $this->admission->getEntity("\Application\Entity\Academicperiod",$criteria);
        //Class
        $classes     = $this->admission->getEntity("\Application\Entity\Programgroup",$criteria);
        
        if($this->request->getPost('btnupload')){
            $post = array_merge_recursive(
                            $this->request->getPost()->toArray(),
                            $this->request->getFiles()->toArray()
                    );
            $formfile->setData($post);
            if($formfile->isValid()){
                
                $validator = new \Zend\Validator\File\Extension('csv');
                if($validator->isValid($post['File']['filename'])){
                    
                    $uploadfile      = $formfile->getData();
                    $filecontent     = $uploadfile['File']['filename']['tmp_name'];
                    $handle          = fopen($filecontent, "r");

                    while (($rowdata = fgetcsv($handle, 1000, ",")) !== FALSE){
                        //Process validation class/group, academic period, entry manner, study mode
                        $student[]   = $this->admission->getEnrolledStudentsArray($rowdata);
                    }
                    
                    $this->admissionsession->enrolmentlist = $student;
                    //$this->admissionsession->getManager()->getStorage()->clear('ADMISSION');
                    return $this->redirect()->toRoute("admission",array("action"=>"confirmgroupenrollment"));
                }
            } 
        }
        
        
        return new ViewModel(array("classes"=>$classes,"academicperiod"=>$acperiod,"entrymanners"=>$entrymanners,"studymodes"=>$studymodes,"uploadform"=>$formfile));
    }
    
    
    function confirmgroupenrollmentAction(){
        $list = $this->admissionsession->enrolmentlist;
        return new ViewModel(array("list"=>$list));
    }
    
    function saveenrolledlistAction(){
        $list = $this->admissionsession->enrolmentlist;
        foreach ($list as $student){
           //Check errors
           if(empty($student['error'])){
               //Set enrollment object
                $studentobject = $this->admission->setEnrollmentObject($student['studentdata']);
                //Save there are no errors against record
                $this->admission->enrollstudent($studentobject);
           }
        }
         $this->admissionsession->getManager()->getStorage()->clear('ADMISSION');
         //Redirect to enrollment page
         $this->flashMessenger()->addSuccessMessage("Students successfully enrolled");
         return $this->redirect()->toRoute("admission",array("action"=>"enrollment"));
    }
    
    function individualenrollmentAction(){
        $formenrollment = new \Application\Form\Enrollment($this->em);
        
        //Bind 
        $formenrollment->bind($this->request->getPost());
        //Check if form has been submitted
        if($this->request->getPost('submit')){
            
            $formenrollment->setData($this->request->getPost());
            //Check if form validation is okay
            if($formenrollment->isValid()){
             
                $formdata = $formenrollment->getData();
                $basic = $formdata['Enrollment']['basicdetails'];
                $enrollment = $formdata['Enrollment'];
                
                $enrollment['surname'] = $basic['surname'];
                $enrollment['firstname'] = $basic['firstname'];
                $enrollment['gender'] = $basic['gender'];
                $enrollment['emailaddress'] = $basic['emailaddress'];
                $enrollment['initial'] = $basic['initial'];

                //Set enrollment object
                $studentobject = $this->admission->setEnrollmentObject($enrollment);
                
                //Save student
                $this->admission->enrollstudent($studentobject);
                
                //Redirect to enrollment page
                $this->flashMessenger()->addSuccessMessage("Student successfully enrolled");
                return $this->redirect()->toRoute("admission",array("action"=>"enrollment"));
            }

        }
        
        return new ViewModel(array("formenrollment"=>$formenrollment));
    }
    //End of enrollment 
    
    function classlistAction(){
        
        $students     = array();
        $title        = "";
        $criteria     = Criteria::create();
        //Academic period
        $acperiod     = $this->admission->getEntity("\Application\Entity\Academicperiod",$criteria);
        //Class
        $classes      = $this->admission->getEntity("\Application\Entity\Programgroup",$criteria);
        
        //If search form is submitted, query list of students
        if($this->request->getPost('period') && $this->request->getPost('group')){
            
            $period       = $this->request->getPost('period');
            $group        = $this->request->getPost('group');
            $status        = $this->request->getPost('status');
            
            //Convert ids into objects
            $periodid     = $this->em->getRepository('\Application\Entity\Academicperiod')->find($period);
            $groupid      = $this->em->getRepository('\Application\Entity\Programgroup')->find($group);
           
            //Search for students based on the criteria
            $searchcriteria = Criteria::create()
                              ->where(Criteria::expr()->eq('fkPeriodid', $periodid))
                              ->andWhere(Criteria::expr()->eq('fkGroupid', $groupid));
            
            if($status != ""){
                $searchcriteria->andWhere(Criteria::expr()->eq('isregistered', $status));
            }
            
            
            //Create title
            $title = $groupid->getGroupName()." ".$periodid->getTitle();
            
            $students     = $this->admission->getClasslist($searchcriteria);
            
        }
        
        return new ViewModel(array("periods"=>$acperiod,"classes"=>$classes,"studentlist"=>$students,"title"=>$title));
    } 
    
    public function studentlistingAction(){
        $students = $this->em->getRepository('\Application\Entity\Studentprogram')->findAll();
        return new ViewModel(array("students"=>$students));
    }
    
    function regulationsAction(){
        return new ViewModel();
    } 
    
    function registerAction(){
        $form = new \Application\Form\Registration($this->em);
        
        return new ViewModel(array("frmregister"=>$form));
    }
    
    
    function uploadregulationsAction(){
        $formupload = new \Application\Form\Enrollment($this->em);
        return new ViewModel(array("formupload"=>$formupload));
    }     
    //End Class Management    
    function studentprofileAction(){
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        
        $profile = $this->em->getRepository('\Application\Entity\Studentprogram')->findOneBy(array("fkStudentid"=>$id));
        
        return new ViewModel(array("profile"=>$profile));
    }
    
    function administrationpocketAction(){
        return new ViewModel();
    }  
    
    function classattendanceAction(){
        $exams            = new \Application\Model\Examinations($this->em);
        $modules = $exams->getLecturerModules($this->userid);
        return new ViewModel(array("modules"=>$modules));
    } 
    
    function classregisterAction(){
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $module = $this->em->getRepository("\Application\Entity\Lecturermodule")->find($id);
        return new ViewModel(array("module"=>$module));
    } 
    
    function progressionAction(){
        return new ViewModel();
    }  
    
    function reportsAction(){
        return new ViewModel();
    }      
    
}