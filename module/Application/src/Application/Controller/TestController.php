<?php
namespace Application\Controller;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TestController
 *
 * @author hkumwembe
 */
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class TestController extends AbstractActionController {
    
    public function __construct() {
        
    }
    
    public function onDispatch(\Zend\Mvc\MvcEvent $e) {
        //$this->layout()->setVariables(array("activemodule"=>$this->getEvent()->getRouteMatch()->getMatchedRouteName()));
        parent::onDispatch($e);
    }
    
    public function indexAction() {
        $array = "Test";
        return new ViewModel(array("title"=>$array));
    }
    
    public function manageAction() {
        return new ViewModel();
    }
    
    
}
