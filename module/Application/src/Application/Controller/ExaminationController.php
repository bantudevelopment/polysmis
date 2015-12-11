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
   
    public function lecturermoduleAction()
    {
        return new ViewModel();
    }
   
}