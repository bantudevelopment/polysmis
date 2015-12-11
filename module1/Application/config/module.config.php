<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/[:action][/:id]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'login' => array(
                'type' => 'segment',
                'options' => array(
                    'route'    => '/login[/:action][/:id]',
                    'constraints' => array(
                                    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Login',
                        'action'     => 'index',
                    ),
                ),
            ),
            't' => array(
                'type' => 'segment',
                'options' => array(
                    'route'    => '/test[/:action][/:id]',
                    'constraints' => array(
                                    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Test',
                        'action'     => 'index',
                    ),
                ),
            ),
            'admission' => array(
                'type' => 'segment',
                'options' => array(
                    'route'    => '/admission[/:action][/:id]',
                    'constraints' => array(
                                    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Admission',
                        'action'     => 'index',
                    ),
                ),
            ),            
            'examination' => array(
                'type' => 'segment',
                'options' => array(
                    'route'    => '/examination[/:action][/:id]',
                    'constraints' => array(
                                    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Examination',
                        'action'     => 'index',
                    ),
                ),
            ),
            'finance' => array(
                'type' => 'segment',
                'options' => array(
                    'route'    => '/finance[/:action]',
                    'constraints' => array(
                                    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Finance',
                        'action'     => 'index',
                    ),
                ),
            ),
            'accommodation' => array(
                'type' => 'segment',
                'options' => array(
                    'route'    => '/accommodation[/:action]',
                    'constraints' => array(
                                    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Accommodation',
                        'action'     => 'index',
                    ),
                ),
            ),
            'administration' => array(
                'type' => 'segment',
                'options' => array(
                    'route'    => '/administration[/:action][/:id][/:subid]',
                    'constraints' => array(
                                    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Administration',
                        'action'     => 'index',
                    ),
                ),
            ),            
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            //'Application\Controller\Login'              => 'Application\Controller\LoginController',
            //'Application\Controller\Admission'          => 'Application\Controller\AdmissionController',
            //'Application\Controller\Examination'        => 'Application\Controller\ExaminationController',
            //'Application\Controller\Finance'            => 'Application\Controller\FinanceController',
           // 'Application\Controller\Accommodation'      => 'Application\Controller\AccommodationController',
            'Application\Controller\Test'     => 'Application\Controller\TestController',
            // 'Application\Controller\Index'             => 'Application\Controller\IndexController'
        ),
        
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'             => __DIR__ . '/../view/layout/router.phtml',
            'application/layout/login'  => __DIR__ . '/../view/layout/login.phtml',
            'application/layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index'   => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'                 => __DIR__ . '/../view/error/404.phtml',
            'error/index'               => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    
    //Doctrine config
    'doctrine' => array(
        'eventmanager' => array(
            'orm_default' => array(
                'subscribers' => array(
                
                    // pick any listeners you need
//                    'Gedmo\Tree\TreeListener',
//                    'Gedmo\Timestampable\TimestampableListener',
//                    'Gedmo\Sluggable\SluggableListener',
//                    'Gedmo\Loggable\LoggableListener',
//                    'Gedmo\Sortable\SortableListener'
                ),
            ),
        ),
        'driver' => array(
            'smis_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Application/Entity')
            ),
            'loggable_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    'vendor/gedmo/doctrine-extensions/lib/Gedmo/Loggable/Entity',
                ),
            ),
            'orm_default' => array(
                'drivers' => array(
                        'Application\Entity' =>  'smis_driver',
                        //'Gedmo\Loggable\Entity' => 'loggable_driver',
                 ),
            ),
        ),
        'authentication'=>array(
            'orm_default' => array(
            'object_manager' => 'Doctrine\ORM\EntityManager',
            'identity_class' => 'Application\Entity\User',
            'identity_property' => 'username',
            'credential_property' => 'password',
            ),
        )
        
    ),
    
    
    
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
