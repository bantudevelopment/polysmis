<?php
namespace Application\Model;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usermodel
 *
 * @author hkumwembe
 */
use Zend\Navigation\Navigation;

class Nav extends Commonmodel {
    
    protected $container;

    public function __construct() {
        $this->container = new Navigation();
        
    }
    
    public function getAdminNav(){
        
        $pages = array(
            array(
                'label'  => 'Save',
                'action' => 'save',
            ),
            array(
                'label' =>  'Delete',
                'action' => 'delete',
            )
        );
        
        
        $this->container->addPages($pages);
        
        return $this->container;
        
        //$user = $this->em->getRepository("\Application\Entity\User")->find($userobject->getPkUserid());
    }
    
   
   
}
