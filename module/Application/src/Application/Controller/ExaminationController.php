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
        
        $this->authservice = new AuthenticationService();
        if(!$this->authservice->hasIdentity()){
            $this->redirect()->toRoute("login",array('action'=>'index'));
        }
        $identity           = $this->authservice->getIdentity();
        
        $this->userid       = $identity['pkUserid'];
        $this->layout()->setVariables(array("activemodule"=>$this->getEvent()->getRouteMatch()->getMatchedRouteName()));
        parent::onDispatch($e);
    }
    
    public function indexAction()
    {
        return new ViewModel(array("acl"=>  $this->acl));
    }
    /*
     * Lecturer module listing
     */
    public function lecturermoduleAction(){
        
        //Get current period
        $period = $this->exams->getCurrentPeriod();
        
        //Get user's department
        $deptentity      = $this->em->getRepository("\Application\Entity\Staff")->findOneBy(array("fkUserid"=>$this->userid));;
        $allocations     = $this->exams->getLecturerModuleAllocation($deptentity->getFkDeptid()->getPkDeptid());
        $servicedmodules = $this->exams->getServicedModules($deptentity->getFkDeptid()->getPkDeptid());
        return new ViewModel(array("allocations"=>$allocations,"period"=>$period[0],"servicedmodules"=>$servicedmodules));
    }
    
    /*
     * Lecturer module allocation form
     */
    public function lcformAction(){
        
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $subid = $this->getEvent()->getRouteMatch()->getParam('subparam');
        $lecturermodule = "";
        if($subid){
            $lecturermodule = $this->em->getRepository("\Application\Entity\Lecturermodule")->find($subid);
        }
        
        
        $deptentity      = $this->em->getRepository("\Application\Entity\Staff")->findOneBy(array("fkUserid"=>$this->userid));;
        //Get selected module information
        $module = $this->em->getRepository("\Application\Entity\Classmodule")->find($id);
        
        //Get form
        $form = new \Application\Form\Lecturermodule($this->em,$deptentity->getFkDeptid()->getPkDeptid());
        
        $form->bind($this->request->getPost());
        if($this->request->getPost('save')){
            $form->setData($this->request->getPost());
            if($form->isValid()){
                $formData = $form->getData();
                
                //If request other departments option is not selected
                if($formData['Lecturermodule']['fkStaffid'] != "-1"){
                    
                    if($subid){
                        //Get existing record information
                        $entity = $lecturermodule;
                    }else{
                        //Set new entity
                        $entity = new \Application\Entity\Lecturermodule();
                    }
                    
                    //Get selected staff entity
                    $staffentity = $this->em->getRepository('\Application\Entity\Staff')->find($formData['Lecturermodule']['fkStaffid']);
                    
                    $entity->setFkClassmoduleid($module);
                    $entity->setFkStaffid($staffentity);
                    $this->exams->saveLecturerModule($entity);
                    $this->redirect()->toRoute("examination",array("action"=>"lecturermodule"));
                }else{
                    //Define custom validation
                    $validator = new \Zend\Validator\Callback(function($formvalue){
                        //Checking if department has been selected on not
                        return empty($formvalue['fkReqdeptid'])?false:true;
                    });
                    
                    $validator->setMessage("Select department");

                    if($validator->isValid($formData)){
                        
                        //Delete any lecturer assigned to the module
                        $this->exams->deletefromdb("\Application\Entity\Lecturermodule", array("fkClassmoduleid"=>$module->getPkClassmoduleid()));
                        
                        //Get servicing department entity
                        $servicingdeptentity = $this->em->getRepository('\Application\Entity\Department')->find($formData['fkReqdeptid']);
                        
                        //If the module is already assigned update
                        $currentmodule = $this->em->getRepository('\Application\Entity\Servicedmodule')->findOneBy(array("fkClassmoduleid"=>$module->getPkClassmoduleid()));
                        if(count($currentmodule)>0){
                            $entity  = $currentmodule;
                        }else{
                            //Save serviced entity
                            $entity = new \Application\Entity\Servicedmodule();
                        }
                        
                        $entity->setFkClassmoduleid($module);
                        $entity->setReqdept($deptentity->getFkDeptid());
                        $entity->setServicingdept($servicingdeptentity);
                        $entity->setFlag("REQUESTED");
                        if($this->exams->saveServicedModule($entity)){
                            //If allocatre, send an email to hod
                        }
                        $this->redirect()->toRoute("examination",array("action"=>"lecturermodule"));
                    }else{
                        $messages = $validator->getMessages();
                        $form->get('fkReqdeptid')->setMessages(array($messages['callbackValue']));
                    }
                    
                }
                
                
                
            }
        }
        
        return new ViewModel(array("module"=>$module,"form"=>$form,"details"=>$lecturermodule));
    }
    
    
   public function servicemoduleformAction(){
       
       
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $subid = $this->getEvent()->getRouteMatch()->getParam('subparam');
        $module = $this->em->getRepository("\Application\Entity\Classmodule")->find($id);
        $lecturermodule = "";
        if($subid){
            $lecturermodule = $this->em->getRepository("\Application\Entity\Lecturermodule")->find($subid);
        }

       $deptentity      = $this->em->getRepository("\Application\Entity\Staff")->findOneBy(array("fkUserid"=>$this->userid));;
       $form = new \Application\Form\Servicedmodule($this->em,$deptentity->getFkDeptid()->getPkDeptid());
       
       $form->bind($this->request->getPost());
       if($this->request->getPost('save')){
            $form->setData($this->request->getPost());
            if($form->isValid()){
                $formdata = $form->getData();
                if($formdata['Servicedmodule']['fkStaffid']=="UNABLETOALLOCATE"){
                    //Update serviced module
                    
                    //Delete lecturer if exist
                }else{
                    
                }
                
            }
       }
       
       
       return new ViewModel(array("form"=>$form,"module"=>$module,"details"=>$lecturermodule));
   } 
    
   
}