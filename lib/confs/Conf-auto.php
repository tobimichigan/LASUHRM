<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */


/**
 * This is Configuration-File Loader. In case of the hosted solution
 * this should be used to automaitcally select the appropriate configuration
 * file.
 *
 * Requirements:
 *
 * R1)
 * all instances of configuration files should reside within directory path
 * given by CONF_PATH. In this path you should create a sub-directory named
 * exacty as the instance name with the Configuration file named Conf.php
 * This configuration file remains unchanged from the format of Ordinary
 * OrangeHRM Configuration files.
 *
 * ex: for instance 'xyz' and main directory of configuration files (CONF_PATH)
 *     being /var/www/hosted/configurations then you create a sub-directory
 *     called 'xyz' within it and create appropriate Conf.php within it.
 *
 * R2)
 * when setup, when you take the complete URL it should be broken down into
 * 3 regions. They are in sequence 1) prefix to instance name
 * 2) Instance name 3) postfix to instance name
 *
 * ex: for URL form http://xyz.lasu.edu.ng (then the instance name is 'xyz')
 *     the below defined constants should read as
 *
 * 			define('URL_PREFIX_TO_INSTANCE_NAME',"http://");
 * 			define('URL_POSTFIX_TO_INSTANCE_NAME',".lasu.edu.ng");
 *
 * R3)
 * Installation of OrangeHRM would mean simply creating the database with
 * with appropriate database users, and modifying a standard OrangeHRM Conf.php
 * with all those details and keepin the file in appropriate directory as discussed
 * in (R1).
 *
 * R4)
 * This file should be renamed from Conf-auto.php to Conf.php in the existing
 * directory (<OrangeHRM-directory>/lib/confs)
 *
 */

ob_start();

define('CONF_PATH', "/var/www/hosted/configurations");
//define('URL_PREFIX_TO_INSTANCE_NAME',"http://");
define('URL_POSTFIX_TO_INSTANCE_NAME',".lasu.edu.ng");


$selectedInstance = preg_replace("/".URL_POSTFIX_TO_INSTANCE_NAME."$/", "", $_SERVER['SERVER_NAME']);

if(is_file(CONF_PATH . "/" .$selectedInstance . "/Conf.php")) {
	require_once CONF_PATH . "/" .$selectedInstance . "/Conf.php";
} else {
	header("Location: ./expired/");		//expired
	exit(0);
}

?>