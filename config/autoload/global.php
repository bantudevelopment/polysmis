<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    // ...
    'navigation' => array(
         'default' => array(
             array(
                 'label' => 'Faculty',
                 'route' => 'home',
                 'pages' => array(
                     array(
                         'label' => 'Child #1',
                         'route' => 'home',
                     ),
                     array(
                         'label' => 'Child #1',
                         'route' => 'home',
                     ),
                 ),
             ),
             array(
                 'label' => 'Departments',
                 'route' => 'home',
             ),
         ),
     ),
     'service_manager' => array(
         'factories' => array(
             'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
         ),
     ),
);
