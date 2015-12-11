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
use Zend\Session\Container;
use Zend\Http\PhpEnvironment\RemoteAddress;

class LoginController extends AbstractActionController
{
    protected $em;
    protected $cs;
    
    public function __construct(\Doctrine\ORM\EntityManager $em,  \Application\Service\Security $cs) {
        $this->em = $em;
        $this->cs = $cs;
    }
    
    public function onDispatch(\Zend\Mvc\MvcEvent $e) {
        $this->authservice = new AuthenticationService();
        if($this->authservice->hasIdentity()){
            $this->redirect()->toRoute("home",array('action'=>'index'));
        }
        
        $this->layout()->setVariables(array("activemodule"=>$this->getEvent()->getRouteMatch()->getMatchedRouteName()));
        parent::onDispatch($e);
    }
    
    public function setpasswordAction(){
        $formpassword = new \Application\Form\Resetpassword($this->em);
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        //Get student information
        $student = $this->em->getRepository('\Application\Entity\Studentprogram')->findOneBy(array("fkStudentid"=>$id));
        $formpassword->bind($this->request->getPost());
        if($this->request->isPost()){
           $formpassword->setData($this->request->getPost()); 
           
            if($formpassword->isValid()){
                $post = $formpassword->getData();
                
                $userModel = new \Application\Model\Student($this->em); 
                $user = $this->em->getRepository('\Application\Entity\User')->find($post['Password']['pkUserid']);
                $user->setPassword($this->cs->_hashing($post['Password']['password']));
                $userModel->saveUserObject($user);
                
                return $this->redirect()->toRoute("login",array("action"=>"index"));
            }
        }
        return new ViewModel(array("frmpassword"=>$formpassword,"studentinfo"=>$student));
    }


    public function indexAction()
    {
        $formlogin = new \Application\Form\Login();
        
        $formlogin->bind($this->request->getPost());
        
        $messages = array();
        
        if ($this->request->isPost()){
            $formlogin->setData($this->request->getPost());
            if ($formlogin->isValid()) {
                 $loginCredentials = $this->request->getPost('Login');

                 $messages = $this->cs->auth($loginCredentials['username'], $this->cs->_hashing($loginCredentials['password']));
                //$messages = $this->cs->auth($loginCredentials['username'],$loginCredentials['password']);
                
                if (empty($messages)) {
                    $identity           = $this->authservice->getIdentity();
                    $this->userid       = $identity['pkUserid'];
                    //If valid, check if account password requires resetting, if true direct user to renew password
                    if(!$this->cs->hasPasswordExpired($this->userid, $this->em)){
                        //Log time and ip address
                        $ipaddress = new RemoteAddress();
                        $pr        = new \Application\Model\Preferences($this->em);
                        //Get user entity
                        $userentity = $this->em->getRepository("\Application\Entity\User")->find($this->userid);
                        $userentity->setLastloginip($userentity->getIpaddress());
                        $userentity->setIpaddress($ipaddress->getIpAddress());
                        $userentity->setLastlogindate($userentity->getLogindate());
                        $userentity->setLogindate(new \Datetime());
                        $logintimes = (int)$userentity->getLogintimes() + 1;
                        $userentity->setLogintimes($logintimes);
                        //Update session information
                        $pr->saveUser($userentity);
                        
                        return $this->redirect()->toRoute('home', array('action' => 'index'));
                    }
                    $usersession = new Container('USER');
                    $usersession->userid  = $this->userid;
                    //Clear session
                    $this->authservice->clearIdentity();
                    return $this->redirect()->toRoute('login', array('action' => 'renewpassword')); 
                }else{
                    
                   //If it new student then authenticate using email address in enrolment 
//                   $enrollmentauth = $this->cs->authNewStudent($loginCredentials['username'], $loginCredentials['password'],$this->em);
//                   if(count($enrollmentauth)){
//                       $registersession = new Container('ENROLLMENT');
//                       $registersession->emailaddress = $loginCredentials['username'];
//                       return $this->redirect()->toRoute('login', array('action' => 'register'));
//                   }    
//                   //Not new student and user account does not exist 
//                   if(!empty($messages['username']))
//                        $formlogin->get('Login')->get('username')->setMessages(array($messages['username']));
//                   if(!empty($messages['password']))
//                        $formlogin->get('Login')->get('password')->setMessages(array($messages['password']));
                }
                
            }else{
                $messages = $formlogin->getMessages();
            }
            
        }

        return new ViewModel(array("frmlogin"=>$formlogin,"errormessage"=>$messages));
    }
    
    
    
    public function renewpasswordAction(){
        $form = new \Application\Form\Resetpassword($this->em);
        $usersession = new Container('USER');
        $userid      =  $usersession->userid;
 
        $form->bind($this->request->getPost());
        if($this->request->isPost()){
            $form->setData($this->request->getPost());
            if($form->isValid()){
                
                //Reset password
                $formdata = $form->getData();
                $preferences = new \Application\Model\Preferences($this->em); 
                //Get current id object
                $userEntity = $this->em->getRepository('\Application\Entity\User')->find($formdata['Password']['pkUserid']);
                $userEntity->setPassword($this->cs->_hashing($formdata['Password']['password']));
                $userEntity->setPasswordlastchanged(new \DateTime());
                $preferences->saveUser($userEntity);
                
                $usersession->getManager()->getStorage()->clear('USER');
                return $this->redirect()->toRoute('login', array('action' => 'index')); 
            }
        }
        
        return new ViewModel(array("form"=>$form,"userid"=>$userid));
    }
    
    
    function registerAction(){
        $registersession = new Container('ENROLLMENT');
        if(isset($registersession->emailaddress)){
             
            $form = new \Application\Form\Registration($this->em);
            $form->bind($this->request->getPost());
            $enrolment = $this->em->getRepository('\Application\Entity\Enrollment')->findOneBy(array("emailAddress"=>$registersession->emailaddress));
           
            if($this->request->isPost()){
                $form->setData($this->request->getPost());  
                if($form->isValid()){
                    $student    = new \Application\Model\Student($this->em);
                    $biodata    = $this->request->getPost('Student');
                    $contacts   = $this->request->getPost('Studentcontact');
                    $guardian   = $this->request->getPost('Guardian');
                    $employment = $this->request->getPost('Employment');
                    $studentemployment = array();
                    
                    $date = new \DateTime();
                    $dob  = new \DateTime($biodata['dob']);
                    /*
                     * Get all objects
                     */
                    
                    //Role
                    $role     = $this->em->getRepository('\Application\Entity\Role')->findOneBy(array("roleName"=>"STUD"));
                    //Country
                    $country  = $this->em->getRepository('\Application\Entity\Country')->find($biodata['fkCountryid']);
                    //District
                    $district = $this->em->getRepository('\Application\Entity\District')->find($biodata['fkDistrictid']);
                    
                    $userobject = array("role"=>$role,"username"=>$enrolment->getTempstudentno(),"title"=>"","url"=>"","surname"=>$biodata['basicdetails']['surname'],"firstname"=>$biodata['basicdetails']['firstname'],"gender"=>$biodata['basicdetails']['gender'],"initial"=>$biodata['basicdetails']['initial'],"datecreated"=>$date,"emailaddress"=>$biodata['basicdetails']['emailaddress'],"password"=>"","ipaddress"=>"","logindate"=>$date);
                    $arrayuser  = $student->setUserObject($userobject);
                    
                    //Set student biodata
                    $studentdata=  array("dob"=>$dob,"country"=>$country,"maritalstatus"=>$biodata['maritalStatus'],"district"=>$district);
                    
                    //Set student program data
                    $studentprogramdata     =  array("entrymanner"=>$enrolment->getFkEntrymannerid(),"entryyear"=>$enrolment->getYearjoined(),"program"=>$enrolment->getFkGroupid()->getFkProgramid(),"repeatinglevel"=>null,"registrationnumber"=>$enrolment->getTempstudentno());
                    
                    //Set student class object
                    $studentclassdata       =  array("examnumber"=>null,"campus"=>null,"class"=>$enrolment->getFkGroupid(),"period"=>$enrolment->getFkPeriodid(),"isregistered"=>"1","studymode"=>$enrolment->getFkStudymode(),"registrationdate"=>$date);
                    
                    //Set student contacts
                    $studentcontacts        =  array("postalAddress"=>$contacts['postalAddress'],"mobile"=>$contacts['cell'],"physicalAddress"=>null,"telephone"=>$contacts['telephone']);
                    
                    //Set Guardian
                    $studentguardian        =  array("surname"=>$guardian['surname'],"firstname"=>$guardian['firstname'],"title"=>$guardian['title'],"postalAddress"=>$guardian['postalAddress'],"emailAddress"=>$guardian['emailAddress'],"mobile"=>$guardian['mobile'],"telephoneNumber"=>$guardian['telephoneNumber'],"relationship"=>$guardian['relationship'],"isnextofkin"=>"1");
                    
                    //Set employment
                    if(!empty($employment['organization'])){
                        $studentemployment  =  array("designation"=>$employment['designation'],"organization"=>$employment['organization'],"startYear"=>$employment['startYear'],"endYear"=>$employment['endYear'],"isCurrent"=>$employment['isCurrent']);
                    }
                    
                    
                    $allocateobjects        = array("user"=>$arrayuser,"student"=>$studentdata,"program"=>$studentprogramdata,"class"=>$studentclassdata,"contacts"=>$studentcontacts,"guardian"=>$studentguardian,"employment"=>$studentemployment);
                    
                    
                    $studento = $student->allocate($allocateobjects);
                    
                    //Delete enrollment record
                    $student->deletefromdb('\Application\Entity\Enrollment',array('pkEnrollmentid'=>$enrolment->getPkEnrollmentid()));
                    $registersession->getManager()->getStorage()->clear('ENROLLMENT');
                    //Display password form
                    return $this->redirect()->toRoute("login",array("action"=>"setpassword","id"=>$studento->getPkStudentid()));
                }
            }
            return new ViewModel(array("frmregister"=>$form,"enrollmentinfo"=> $enrolment));
        }else{
            return $this->redirect()->toRoute('login', array('action' => 'index'));
        }
    }
    
}