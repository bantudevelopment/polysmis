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
use HighRoller\ColumnChart;
use HighRoller\SeriesData;

class IndexController extends AbstractActionController
{
    protected $em;
    protected $cs;
    
    public function __construct(\Doctrine\ORM\EntityManager $em,  \Application\Service\Security $cs) {
        $this->em = $em;
        $this->cs = $cs;
    }

    public function onDispatch(\Zend\Mvc\MvcEvent $e) {
        
        $this->authservice = new AuthenticationService();
        if(!$this->authservice->hasIdentity()){
            $this->redirect()->toRoute("login",array('action'=>'index'));
        }
        
        $this->layout()->setVariables(array("activemodule"=>$this->getEvent()->getRouteMatch()->getMatchedRouteName()));
        parent::onDispatch($e);
    }
    
    public function indexAction()
    {
        //$this->em->getEventManager()->addEventSubscriber(new \Gedmo\Loggable\LoggableListener());
//        $linechart = new ColumnChart();
//        $linechart->title->text = 'Registration status';
//        $count = 5324;
//        for($i=0; $i<=3; $i++){
//        $series = new SeriesData();
//        $series->name = 'Registration'.$i;
//        
//        $chartData = array($count*$i, 7534, 6234, 7234, 8251, 10324);
//        
//            foreach ($chartData as $value){
//                $series->addData($value);
//
//            }
//            $linechart->addSeries($series);
//        }
        return new ViewModel();
    }
    
    public function formAction(){
        return new ViewModel();
    }
    
    public function logoutAction()
    {
        $this->authservice->clearIdentity();
        return $this->redirect()->toRoute('login', array(
                         'action' => 'index'
                 ));
    }
    
    
}