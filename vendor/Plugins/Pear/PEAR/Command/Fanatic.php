<?php
//
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2003 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.02 of the PHP license,      |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Author: Alexander Merz <alexmerz@php.net>                            |
// |                                                                      |
// +----------------------------------------------------------------------+
//
// $Id$

require_once "PEAR/Command/Common.php";
require_once "PEAR/Command.php";
require_once "PEAR/Remote.php";
require_once "PEAR.php";

/**
 * PEAR commands for installing all packages 
 *
 */
class PEAR_Command_Fanatic extends PEAR_Command_Common
{
    // {{{ properties

    var $commands = array(
        'install-all' => array(
            'summary' => 'install all packages from package server',
            'function' => 'doInstallAll',
            'shortcut' => 'ia',
            'options' => array(
	    	"nobuild"=>array(
			"shortopt"=>'B',
			"doc"=>'don\'t build C extensions')
		),
            'doc' => '	  
	    Request a list of avaible Packages from the Package-Server
	    (master-server) and downloads them and install all'
            ),
        );

    // }}}

    // {{{ constructor

    /**
     * PEAR_Command_Fanatic constructor.
     *
     * @access public
     * @param object PEAR_Frontend a reference to an frontend
     * @param object PEAR_Config a reference to the configuration data
     */
    function PEAR_Command_Fanatic(&$ui, &$config)
    {
        parent::PEAR_Command_Common($ui, $config);
    }

    // }}}

    // {{{ doInstallAll()
    /**
    * do the install
    *
    * @access public
    * @param string $command the command
    * @param array $options the command options before the command
    * @param array $params the stuff after the command name
    * @return bool true if succesful
    * @throw PEAR_Error 
    */
    function doInstallAll($command, $options, $params)
    {	

	$remote = &new PEAR_Remote($this->config);
	$remoteInfo = $remote->call("package.listAll");
	if(PEAR::isError($remoteInfo)) {
		return $remoteInfo;
	}
	$cmd = &PEAR_Command::factory("install", $this->config);
	if(PEAR::isError($cmd)) {
		return $cmd;
	}	
	
	foreach($remoteInfo as $pkgn=>$pkg) {   
		// error handling not neccesary, because
		// already done by the install command
		$options=array(
			"nodeps"=>true,
			"force"=>true,
			"nobuild"=>$options['nobuild']
			);
		$cmd->run("install", $options, array($pkgn));       
  	} 

        return true;

    }

    // }}}
}
