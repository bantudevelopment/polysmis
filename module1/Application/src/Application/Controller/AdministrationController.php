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
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Validator;
use Zend\Di\Di;
use Zend\Authentication\AuthenticationService;

class AdministrationController extends AbstractActionController
{
    protected $em;
    protected $userid;
    protected $request;
    protected $response;
    protected $preferences;
    protected $cs;
    
    public function __construct(\Doctrine\ORM\EntityManager $em,  \Application\Service\Security $cs) {
        $this->em               = $em;
        $this->response         = $this->getResponse();
        $this->request          = $this->getRequest();
        $this->preferences      = new \Application\Model\Preferences($this->em);
        $this->cs = $cs;
    }
    
     public function onDispatch(\Zend\Mvc\MvcEvent $e) {
        
//         $this->authservice = new AuthenticationService();
//        if(!$this->authservice->hasIdentity()){
//            $this->redirect()->toRoute("login",array('action'=>'index'));
//        }
//        
//        $identity           = $this->authservice->getIdentity();
//        $this->userid       = $identity['pkUserid'];
         
        $this->layout()->setVariables(array("activemodule"=>$this->getEvent()->getRouteMatch()->getMatchedRouteName()));
        parent::onDispatch($e);
    }
    
    public function indexAction()
    {
        return new ViewModel();
    }
    
    /*
     * Redirect to faculties view
     */
    public function facultiesAction(){
        
        $successMsg = "";
        $flashMessenger = $this->flashMessenger();
        if($flashMessenger->hasSuccessMessages()){
            $successMsg = implode("<br>", $flashMessenger->getSuccessMessages());
        }
        
        $faculties = $this->em->getRepository("\Application\Entity\Faculty")->findAll();
        return new ViewModel(array("faculties"=>$faculties,"msg"=>$successMsg));
    }
    
    /*
     * Redirect to faculty form view and save faculty information
     */
    public function facultyformAction(){
        
        $facultydetails = "";
        $form = new \Application\Form\Faculty($this->em);
        $form->bind($this->request->getPost());
         //If edit faculty has been selected then select from database
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        if($id){
            $facultydetails = $this->em->getRepository("\Application\Entity\Faculty")->find($id);
        }

        if($this->request->getPost('save')){
            $form->setData($this->request->getPost());
            if($form->isValid()){
                $formdata = $form->getData();

                //Check if action is to update record
                if($formdata['Faculty']['pkFacultyid']){
                    //Get existing record information
                    $entity = $this->em->getRepository('\Application\Entity\Faculty')->find($formdata['Faculty']['pkFacultyid']);
                }else{
                    //Set new entity
                    $entity = new \Application\Entity\Faculty();
                }
                
                //Check if staff has been selected
                $staffid = ($formdata['Faculty']['fkStaffid'])?$this->em->getRepository('\Application\Entity\Staff')->find($formdata['Faculty']['fkStaffid']):NULL;

                //Initialize fields
                $entity->setFacultyName($formdata['Faculty']['facultyName']);
                $entity->setFacultyCode($formdata['Faculty']['facultyCode']);
                $entity->setFkStaffid($staffid);
                
                if($this->preferences->saveFaculty($entity)){
                    //Set success message and then redirect to view
                    $this->flashMessenger()->addSuccessMessage("Faculty information saved");
                    $this->redirect()->toRoute('administration', array('action'=>'faculties'));
                }
                
                
            }
            
        }
        return new ViewModel(array("form"=>$form,"details"=>$facultydetails));
    }
    
    
    
    
    public function departmentsAction(){

        $successMsg = "";
        $flashMessenger = $this->flashMessenger();
        if($flashMessenger->hasSuccessMessages()){
            $successMsg = implode("<br>", $flashMessenger->getSuccessMessages());
        }
        
        $facultyid = $this->getEvent()->getRouteMatch()->getParam('id');
        //Get faculty information
        $faculty   = $this->em->getRepository("\Application\Entity\Faculty")->find($facultyid);
        //Get all departments belonging to faculty
        $departments = $this->em->getRepository("\Application\Entity\Department")->findBy(array("fkFacultyid"=>$facultyid));
        return new ViewModel(array("departments"=>$departments,"msg"=>$successMsg,"faculty"=>$faculty));
    }
    
    /*
     * Redirect to faculty form view and save faculty information
     */
    public function departmentformAction(){
        
        $departmentdetails = "";
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $deptid = $this->getEvent()->getRouteMatch()->getParam('subid');
        $form = new \Application\Form\Department($this->em,$deptid);
        $form->bind($this->request->getPost());
        
         //If edit faculty has been selected then select from database
        
        if($deptid){
            $departmentdetails = $this->em->getRepository("\Application\Entity\Department")->find($deptid);
        }
        
        //Get faculty details
        $faculty = $this->em->getRepository("\Application\Entity\Faculty")->find($id);
        
        if($this->request->getPost('save')){
            $form->setData($this->request->getPost());
            if($form->isValid()){
                $formdata = $form->getData();
               
                //Check if action is to update record
                if($formdata['Department']['pkDeptid']){
                    //Get existing record information
                    $entity = $this->em->getRepository('\Application\Entity\Department')->find($formdata['Department']['pkDeptid']);
                }else{
                    //Set new entity
                    $entity = new \Application\Entity\Department();
                }
                
                //Check if staff has been selected
                $staffid = (!empty($formdata['Department']['fkStaffid']))?$this->em->getRepository('\Application\Entity\Staff')->find($formdata['Department']['fkStaffid']):NULL;
                
                //Get faculty entity
                $facultyentity = $this->em->getRepository('\Application\Entity\Faculty')->find($formdata['Department']['fkFacultyid']);
                
                //Initialize fields
                $entity->setDeptName($formdata['Department']['deptName']);
                $entity->setDeptCode($formdata['Department']['deptCode']);
                $entity->setFkFacultyid($facultyentity);
                $entity->setFkStaffid($staffid);
                
                if($this->preferences->saveDepartment($entity)){
                    //Set success message and then redirect to view
                    $this->flashMessenger()->addSuccessMessage("Department saved");
                    $this->redirect()->toRoute('administration', array('action'=>'departments',"id"=>$formdata['Department']['fkFacultyid']));
                }
                
                
            }
            
        }
        
        return new ViewModel(array("form"=>$form,"details"=>$departmentdetails,"faculty"=>$faculty));
    }
    
     public function departmentprogramsAction(){

        $successMsg = "";
        $classes = array();
        $flashMessenger = $this->flashMessenger();
        if($flashMessenger->hasSuccessMessages()){
            $successMsg = implode("<br>", $flashMessenger->getSuccessMessages());
        }
        
        $deptid = $this->getEvent()->getRouteMatch()->getParam('id');
        $programid = $this->getEvent()->getRouteMatch()->getParam('subid');
        //Get faculty information
        $department   = $this->em->getRepository("\Application\Entity\Department")->find($deptid);
        //Get all departments belonging to faculty
        $searchData["fkDeptid"] = $deptid;
        if($this->request->getPost('programid') || !empty($programid)){
            $programid = (!empty($programid))?$programid:$this->request->getPost('programid');
            $searchData["pkProgramid"] = $programid;
        }
       
        //Get first program
        $initialprogram = $this->em->getRepository("\Application\Entity\Program")->findOneBy($searchData);
        if(count($initialprogram)==1){
        //Get classes assigned to project
        $classes = $this->em->getRepository("\Application\Entity\Classes")->findBy(array("fkProgramid"=>$initialprogram->getPkProgramid()));
        }
        
        //Get a pull of programs
        $programs = $this->em->getRepository("\Application\Entity\Program")->findBy(array("fkDeptid"=>$deptid));
        return new ViewModel(array("programs"=>$programs,"msg"=>$successMsg,"department"=>$department,"initialprogram"=>$initialprogram,"classes"=>$classes));
    }
    
    /*
     * Redirect to program form view and save program information
     */
    public function programformAction(){
        
        $programdetails = "";
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $progid = $this->getEvent()->getRouteMatch()->getParam('subid');
        $form = new \Application\Form\Program($this->em);
        $form->bind($this->request->getPost());
        
         //If edit program has been selected then select from database
        
        if($progid){
            $programdetails = $this->em->getRepository("\Application\Entity\Program")->find($progid);
        }
        
        //Get faculty details
        $department = $this->em->getRepository("\Application\Entity\Department")->find($id);
        
        if($this->request->getPost('save')){
            $form->setData($this->request->getPost());
           
            if($form->isValid()){
                $formdata = $form->getData();
                //Check if action is to update record
                if($formdata['Program']['pkProgramid']){
                    //Get existing record information
                    $entity = $this->em->getRepository('\Application\Entity\Program')->find($formdata['Program']['pkProgramid']);
                }else{
                    //Set new entity
                    $entity = new \Application\Entity\Program();
                }
                
                //Get department entity
                $deptentity = $this->em->getRepository('\Application\Entity\Department')->find($formdata['Program']['fkDeptid']);
                
                //Get award entity
                $awardentity = $this->em->getRepository('\Application\Entity\Award')->find($formdata['Program']['fkAwardid']);
                
                //Initialize fields
                $entity->setProgramName($formdata['Program']['programName']);
                $entity->setProgramCode($formdata['Program']['programCode']);
                $entity->setFkDeptid($deptentity);
                $entity->setFkAwardid($awardentity);
                $entity->setProgramLongName($formdata['Program']['programLongName']);
                $entity->setDuration($formdata['Program']['duration']);
                
                if($this->preferences->saveProgram($entity)){
                    //Set success message and then redirect to view
                    $this->flashMessenger()->addSuccessMessage("Program saved");
                    $this->redirect()->toRoute('administration', array('action'=>'departmentprograms',"id"=>$formdata['Program']['fkDeptid']));
                }
                
                
            }
           
        }
        
        return new ViewModel(array("form"=>$form,"details"=>$programdetails,"department"=>$department));
    }
    
    /*
     * Redirect to program class form view and save program class information
     */
    public function programclassformAction(){
        
        $classdetails = "";
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $classid = $this->getEvent()->getRouteMatch()->getParam('subid');
        $form = new \Application\Form\Classes($this->em);
        $form->bind($this->request->getPost());
        
         //If edit program has been selected then select from database
        
        if($classid){
            $classdetails = $this->em->getRepository("\Application\Entity\Classes")->find($classid);
        }
        
        //Get faculty details
        $program = $this->em->getRepository("\Application\Entity\Program")->find($id);
        
        if($this->request->getPost('save')){
            $form->setData($this->request->getPost());
           
            if($form->isValid()){
                $formdata = $form->getData();
                //Check if action is to update record
                if($formdata['Class']['pkClassid']){
                    //Get existing record information
                    $entity = $this->em->getRepository('\Application\Entity\Classes')->find($formdata['Class']['pkClassid']);
                }else{
                    //Set new entity
                    $entity = new \Application\Entity\Classes();
                }
                
                //Get department entity
                $programentity = $this->em->getRepository('\Application\Entity\Program')->find($formdata['Class']['fkProgramid']);
                
                //Initialize fields
                $entity->setClassName($formdata['Class']['className']);
                $entity->setClassCode($formdata['Class']['classCode']);
                $entity->setFkProgramid($programentity);
                $entity->setClassYear($formdata['Class']['classYear']);
                
                if($this->preferences->saveClass($entity)){
                    //Set success message and then redirect to view
                    $this->flashMessenger()->addSuccessMessage("Class information saved");
                    $this->redirect()->toRoute('administration', array('action'=>'departmentprograms',"id"=>$programentity->getFkDeptid()->getPkDeptid(),"subid"=>$formdata['Class']['fkProgramid']));
                }
            }       
        }
        return new ViewModel(array("form"=>$form,"details"=>$classdetails,"program"=>$program));
   }
    
   public function classmodulesAction(){
       
        $successMsg = "";
        $flashMessenger = $this->flashMessenger();
        if($flashMessenger->hasSuccessMessages()){
            $successMsg = implode("<br>", $flashMessenger->getSuccessMessages());
        }
        
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        
        //Get list of class modules
        $modules = $this->preferences->getClassModules($id);
        
        //Get class details
        $classes = $this->em->getRepository("\Application\Entity\Classes")->find($id);
        
        return new ViewModel(array("modules"=>$modules,"class"=>$classes,"msg"=>$successMsg));
    } 
   
    
    /*
     * Redirect to class module form view and save class module information
     */
    public function classmoduleformAction(){
        
        $moduledetails  = "";
        $id             = $this->getEvent()->getRouteMatch()->getParam('id');
        $classmoduleid  = $this->getEvent()->getRouteMatch()->getParam('subid');
        $period         = $this->preferences->getCurrentYr();
        $form           = new \Application\Form\Classmodule($period[0]->getPkAcademicperiodid(),$this->em,$id,$classmoduleid);
        $form->bind($this->request->getPost());
        
         //If edit faculty has been selected then select from database
        
        if($classmoduleid){
            $moduledetails = $this->em->getRepository("\Application\Entity\Classmodule")->find($classmoduleid);
        }
        
        $availablemodules = $this->preferences->getAvailableModules($id);
        
        //Get faculty details
        $class = $this->em->getRepository("\Application\Entity\Classes")->find($id);
        
        if($this->request->getPost('save')){
            $form->setData($this->request->getPost());
            if($form->isValid()){
                $formdata = $form->getData();
               
                //Check if action is to update record
                if($formdata['Classmodule']['pkClassmoduleid']){
                    //Get existing record information
                    $entity = $this->em->getRepository('\Application\Entity\Classmodule')->find($formdata['Classmodule']['pkClassmoduleid']);
                }else{
                    //Set new entity
                    $entity = new \Application\Entity\Classmodule();
                }
                
                //Get class entity
                $classentity = $this->em->getRepository('\Application\Entity\Classes')->find($formdata['Classmodule']['fkClassid']);
                
                //Get module entity
                $moduleentity = $this->em->getRepository('\Application\Entity\Module')->find($formdata['Classmodule']['fkModuleid']);
                
                //Get period entity
                $periodentity = $this->em->getRepository('\Application\Entity\Academicyear')->find($formdata['Classmodule']['fkAcademicperiod']);
                
                //Initialize fields
                $entity->setCwkweight($formdata['Classmodule']['cwkweight']);
                $entity->setExweight($formdata['Classmodule']['exweight']);
                $entity->setFkAcademicperiod($periodentity);
                $entity->setFkClassid($classentity);
                $entity->setFkModuleid($moduleentity);
                $entity->setIsCore($formdata['Classmodule']['isCore']);
                $entity->setIsProject($formdata['Classmodule']['isProject']);
                
                if($this->preferences->saveClassModule($entity)){
                    //Set success message and then redirect to view
                    $this->flashMessenger()->addSuccessMessage("Module assigned to class");
                    $this->redirect()->toRoute('administration', array('action'=>'classmodules',"id"=>$formdata['Classmodule']['fkClassid']));
                }
            }   
        }
        
        return new ViewModel(array("availablemodules"=>$availablemodules,"form"=>$form,"details"=>$moduledetails,"class"=>$class));
    }
    
   
    public function academicperiodAction(){
        
        $successMsg = "";
        $flashMessenger = $this->flashMessenger();
        if($flashMessenger->hasSuccessMessages()){
            $successMsg = implode("<br>", $flashMessenger->getSuccessMessages());
        }
        
        //Get list of academic periods
        $periods = $this->em->getRepository("\Application\Entity\Academicyear")->findBy(array("parentid"=>null));
        
        return new ViewModel(array("periods"=>$periods,"msg"=>$successMsg));
    }
    
    public function semesterAction(){
        
        $successMsg = "";
        $flashMessenger = $this->flashMessenger();
        if($flashMessenger->hasSuccessMessages()){
            $successMsg = implode("<br>", $flashMessenger->getSuccessMessages());
        }
        
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        
        $academicyear = $this->em->getRepository("\Application\Entity\Academicyear")->find($id);
        
        //Get list of academic periods
        $periods = $this->em->getRepository("\Application\Entity\Academicyear")->findBy(array("parentid"=>$id));
        
        return new ViewModel(array("periods"=>$periods,"academicyear"=>$academicyear,"msg"=>$successMsg));
    }
   
   /*
     * Redirect to program class form view and save program class information
     */
    public function periodformAction(){
        
        $details = "";
        $form = new \Application\Form\Academicperiod($this->em,$this->preferences);
        $form->bind($this->request->getPost());
        
         //If edit academic year has been selected then select from database
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        if($id){
            $details = $this->em->getRepository("\Application\Entity\Academicyear")->find($id);
        }

        if($this->request->getPost('save')){
            $form->setData($this->request->getPost());
            if($form->isValid()){
                $formdata = $form->getData();

                //Check if action is to update record
                if($formdata['Academicyear']['pkAcademicperiodid']){
                    //Get existing record information
                    $entity = $this->em->getRepository('\Application\Entity\Academicyear')->find($formdata['Academicyear']['pkAcademicperiodid']);
                }else{
                    //Set new entity
                    $entity = new \Application\Entity\Academicyear();
                }
                //Initialize fields
                $entity->setStartDate(new \DateTime($formdata['Academicyear']['startDate']));
                $entity->setEndDate(new \DateTime($formdata['Academicyear']['endDate']));
                $entity->setAcyr($formdata['Academicyear']['acyr']);
                $entity->setCategory($formdata['Academicyear']['category']);

                if($this->preferences->saveAcademicPeriod($entity)){
                    //Set success message and then redirect to view
                    $this->flashMessenger()->addSuccessMessage("Academic period saved");
                    $this->redirect()->toRoute('administration', array('action'=>'academicperiod'));
                }
                
                
            }
            
        }
        return new ViewModel(array("form"=>$form,"details"=>$details));
   }
   
   /*
     * Redirect to semester form view and save program class information
     */
    public function semesterformAction(){
        
        $details = "";
        $form = new \Application\Form\Academicperiod($this->em,$this->preferences);
        $form->bind($this->request->getPost());
        
         //If edit academic year has been selected then select from database
        $semesterid = $this->getEvent()->getRouteMatch()->getParam('subid');
        if($semesterid){
            $details = $this->em->getRepository("\Application\Entity\Academicyear")->find($semesterid);
        }
        //Get parent year
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $academicyear = $this->em->getRepository("\Application\Entity\Academicyear")->find($id);

        if($this->request->getPost('save')){
            $form->setData($this->request->getPost());
            if($form->isValid()){
                $formdata = $form->getData();

                //Check if action is to update record
                if($formdata['Academicyear']['pkAcademicperiodid']){
                    //Get existing record information
                    $entity = $this->em->getRepository('\Application\Entity\Academicyear')->find($formdata['Academicyear']['pkAcademicperiodid']);
                }else{
                    //Set new entity
                    $entity = new \Application\Entity\Academicyear();
                }
                
                //Get parent entity
                
                $parent = $this->em->getRepository('\Application\Entity\Academicyear')->find($formdata['Academicyear']['parentid']);
                //Initialize fields
                $entity->setStartDate(new \DateTime($formdata['Academicyear']['startDate']));
                $entity->setEndDate(new \DateTime($formdata['Academicyear']['endDate']));
                $entity->setAcyr($formdata['Academicyear']['acyr']);
                $entity->setParentid($parent);

                if($this->preferences->saveAcademicPeriod($entity)){
                    //Set success message and then redirect to view
                    $this->flashMessenger()->addSuccessMessage("Semester saved");
                    $this->redirect()->toRoute('administration', array('action'=>'semester',"id"=>$id));
                }
                
                
            }
           
        }
        return new ViewModel(array("form"=>$form,"details"=>$details,"academicyear"=>$academicyear));
   }
    
   
   public function usersAction(){
       
        $successMsg = "";
        $flashMessenger = $this->flashMessenger();
        if($flashMessenger->hasSuccessMessages()){
            $successMsg = implode("<br>", $flashMessenger->getSuccessMessages());
        }
       
       $users =  $this->em->getRepository("\Application\Entity\User")->findAll();
       return new ViewModel(array("users"=>$users));
   }
   
   /*
     * Redirect to user form view and save user information
     */
    public function userformAction(){
        
        $userdetails = "";
        $form = new \Application\Form\User($this->em);
        $form->bind($this->request->getPost());
        
         //If edit user has been selected then select from database
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        if($id){
            $userdetails = $this->em->getRepository("\Application\Entity\User")->find($id);
        }

        if($this->request->getPost('save')){
            $form->setData($this->request->getPost());
            if($form->isValid()){
                
                $staffmodel = new \Application\Model\Staff($this->em);
                $formdata = $form->getData();
                
                if($staffmodel->registerUser($formdata)){
                    $this->flashMessenger()->addSuccessMessage("User information saved");
                    $this->redirect()->toRoute('administration', array('action'=>'users'));
                }
//                
//                if($this->preferences->saveUser($entity)){
//                    //Set success message and then redirect to view
//                    $this->flashMessenger()->addSuccessMessage("User information saved");
//                    $this->redirect()->toRoute('administration', array('action'=>'users'));
//                } 
            }

            
        }
        return new ViewModel(array("form"=>$form,"details"=>$userdetails));
    }
   
   
   public function userdetailsAction(){
       
       
        $staffdetails   = array();
        $successMsg = "";
        $flashMessenger = $this->flashMessenger();
        if($flashMessenger->hasSuccessMessages()){
            $successMsg = implode("<br>", $flashMessenger->getSuccessMessages());
        }
        
        $resetform = new \Application\Form\Resetpassword($this->em);
        
        
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        
        //Get user details in user table
       $user =  $this->em->getRepository("\Application\Entity\User")->find($id);
       
       //Determine type of account
       if($user->getAccounttype() == "STAFF"){
           $staffdetails = $this->em->getRepository("\Application\Entity\Staff")->findOneBy(array("fkUserid"=>$id));
       }
       
       return new ViewModel(array("user"=>$user,"staffdetails"=>$staffdetails,"resetform"=>$resetform));
   }
   
    
      
    
}