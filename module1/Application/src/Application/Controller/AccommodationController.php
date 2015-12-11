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

class AccommodationController extends AbstractActionController
{
     protected $em;
    // protected $cs;
    
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
        //$this->cs = $cs;
    }
    
    public function onDispatch(\Zend\Mvc\MvcEvent $e) {
        $this->layout()->setVariables(array("activemodule"=>$this->getEvent()->getRouteMatch()->getMatchedRouteName()));
        parent::onDispatch($e);
    }
    
    public function indexAction()
    {
        return new ViewModel();
    }
    
}