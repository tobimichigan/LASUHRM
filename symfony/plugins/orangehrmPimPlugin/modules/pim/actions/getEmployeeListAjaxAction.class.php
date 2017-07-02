<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Description of getEmployeeListAjaxAction
 *
 * @author samantha
 */
class getEmployeeListAjaxAction  extends sfAction{
    
    	/**
	 * get Red hat location by country
	 * 
	 */
	public function execute($request){

        $jsonArray = array();

        $properties = array("empNumber","firstName", "middleName", "lastName", "termination_id");
        $employeeNameList = UserRoleManagerFactory::getUserRoleManager()->getAccessibleEntityProperties('Employee', $properties);

        foreach ($employeeNameList as $id => $attributes) {
            $name = trim(trim($attributes['firstName'] . ' ' . $attributes['middleName'],' ') . ' ' . $attributes['lastName']);
            if ($attributes['termination_id']) {
                $name = $name. ' ('.__('Past Employee') .')';
            }
            $jsonArray[$attributes['empNumber']] = array('name' => $name, 'id' => $attributes['empNumber']);
        }
        usort($jsonArray, array($this, 'compareByName'));
        $jsonString = json_encode($jsonArray);

        echo $jsonString;
        exit;

	}
    
    protected function compareByName($employee1, $employee2) {
        return strcmp($employee1['name'], $employee2['name']);
    }
}

?>
