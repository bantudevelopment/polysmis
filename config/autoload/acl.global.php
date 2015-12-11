<?php
/**
 * Coolcsn Zend Framework 2 Authorization Module
 * 
 * @link https://github.com/coolcsn/CsnAuthorization for the canonical source repository
 * @copyright Copyright (c) 2005-2012 LightSoft 2005 Ltd. Bulgaria
 * @license https://github.com/coolcsn/CsnAuthorization/blob/master/LICENSE BSDLicense
 * @author Stoyan Cheresharov <stoyan@coolcsn.com>, Stoyan Revov <st.revov@gmail.com>
*/

return array(
    'acl' => array(
        /**
         * By default the ACL is stored in this config file.
         * If you activate the database_storage ACL will be constructed from the database via Doctrine
         * and the roles and resources defined in this config wil be ignored.
         * 
         * Defaults to false.
         */
        'use_database_storage' => false,
        /**
         * The route where users are redirected if access is denied.
         * Set to empty array to disable redirection.
         */
        'redirect_route' => array(
            'params' => array(
                'controller' => 'Error',
                'action' => 'accessdenied',
                //'id' => '1',
            ),
            'options' => array(
				// We should redirect to an action Controller accessable for everyone. And this is "home" route
				// There should be a rule in the Acl allowing every role access to the action and controller
				// Usually this is the homepage action in our case CsnCms\Controller\Index action frontPageAction
				// the route 'home' = '/' should be overriden by CsnCms
				// In the case we are using login we enter an endless redirect. If you are loged in in the system as a member
				// to hide from the navigation the login action the coleagues are using Acl to deny access to login.
				// The CsnAuthorisation trys to redirect to not accessable action loginAction and it gets redirected back to it.
				// Much better is to redirect to an action for sure accessable from everyone and there is no better candidate than the homepage
				// the landing page for the requests to the domain.
                'name' => 'error', // 'login', 
            ),
        ),
        /**
         * Access Control List
         * -------------------
         */
        'roles' => array(
            '2'   => null,
            '3'   => '2',
            '1'   => '2',
        ),
        'resources' => array(
            'allow' => array(
				'Application\Controller\Admission' => array(
					'captureapplication'=>'1',
                                        'classlist'=>'2',
					'index'	=> '2',
					'verifyrecord' => '2',
					'selection' => '2',
					'candidates' => '2',
					'applicationform' => '2',
                                        'applicantprofile' => '2',
                                        'colleges' => '1',
                                        'studentlisting'=>'3',
                                        'completeapplication' => '2',
					'candidateprofile' => '2',
                                        'upload' => '1',
                                        'loadcandidateresults' => '2',
                                        'cumulativeresults' => '2',
                                        'viewcandidateresults'=>'2',
                                        'resultsuploadconfirmation'=>'2',
                                        'saveresultsupload'=>'2',
					'logout' => '2',
					'captureapplication'=>'2',
					'candidatesupload'=>'2',
                                        'all'=>'1'
				),
                                'Application\Controller\Index' => array(
					'all'   => '2',
				),
                                'Application\Controller\Accommodation' => array(
					'all'   => '2',
				),
                                'Application\Controller\Administration' => array(
					'all'   => '2',
				),
                                'Application\Controller\Login' => array(
					'all'   => '2',
				),
                                'Datacapture\Controller\Error' => array(
					'all'   => '2',
				),
                                'Application\Controller\Examination' => array(
					//'all'   => '2',
                                        'exammanagement'=>'3',
                                        'capturegrades'=>'3',
                                        'importassessments'=>'3',
                                        'confirmimport'=>'3',
                                        'saveassessmentimport'=>'3',
                                        'discardimport'=>'3',
                                        'grades'=>'3',
                                        'computegrades'=>'3',
                                        'index'=>'2',
                                        'results'=>'2',
                                        'createassessment'=>'3',
                                        'deleteassessment'=>'3',
                                        'computeaverage'=>'3'
				),
                                'Application\Controller\Finance' => array(
					'index'   => '2',
                                        'entrycategory'   => '2',
                                        'subjects'=>'2',
                                        'entities'=>'2',
                                        'colleges'=>'2',
                                        'newentity'=>'2',
                                        'roles'=>'2',
                                        'users'=>'2',
                                        'newsubject'=>'2',
                                        'formdistrict'=>'2',
                                        'formprogram'=>'2',
                                        'setprogramcapacity'=>'2',
                                        'newrole'=>'2',
                                        'newcollege'=>'2',
                                        'newuser'=>'2',
                                        'districts'=>'2',
                                        'centers'=>'2',
                                        'deleteentity'=>'2',
                                        'deletesubject'=>'2',
                                        'deleterole'=>'2',
                                        'security'=>'2',
                                        'centercodes'=>'2'
                                        
				),
                                'Datacapture\Controller\Reports' => array(
					'all'   => '2',
                                        
				),
				
            ),
            /*'deny' => array(
                'CsnUser\Controller\Index' => array(
                'login'   => 'member'
                ),
                'CsnUser\Controller\Registration' => array(
                'index'   => 'member',
                ),
            ) */
        )
    )
);
