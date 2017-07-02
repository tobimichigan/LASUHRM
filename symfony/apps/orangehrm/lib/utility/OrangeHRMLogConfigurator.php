<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Customized logger configurator to correctly set the log directory.
 */
class OrangeHRMLogConfigurator extends LoggerConfiguratorIni {

        const ROOT_DIR_MARKER = '{ROOT_PATH}';
        
	public function configure(LoggerHierarchy $hierarchy, $url = '') {
		$properties = @parse_ini_file($url);
		if ($properties === false || count($properties) == 0) {
			$error = error_get_last();
		    throw new LoggerException("LoggerConfiguratorIni: ".$error['message']);
		}
		return $this->doConfigureProperties($properties, $hierarchy);
	}
}
