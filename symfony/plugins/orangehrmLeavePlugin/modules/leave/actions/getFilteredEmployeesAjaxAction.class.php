<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Description of getFilteredEmployeeCountAjaxAction
 */
class getFilteredEmployeesAjaxAction  extends sfAction {
    
    protected $employeeService;
    
    public function getEmployeeService() { 
        if (empty($this->employeeService)) {
            $this->employeeService = new EmployeeService();
        }
        return $this->employeeService;
    }

    public function setEmployeeService($employeeService) {
        $this->employeeService = $employeeService;
    }
    
    protected function getMatchingEmployees($parameters) {

        $parameterHolder = new EmployeeSearchParameterHolder();
        $filters = array('location' => $parameters['location'],
            'sub_unit' => $parameters['subunit']);

        $parameterHolder->setFilters($filters);
        $parameterHolder->setLimit(NULL);
        $employees = $this->getEmployeeService()->searchEmployees($parameterHolder);


        $names = array();
        foreach($employees as $employee) {
            $names[] = $employee->getFullName();
        }        

        return $names;
    }
    
    public function execute($request) {
        sfConfig::set('sf_web_debug', false);
        sfConfig::set('sf_debug', false);
        
        $employees = $this->getMatchingEmployees($request->getGetParameters());


        $response = $this->getResponse();
        $response->setHttpHeader('Expires', '0');
        $response->setHttpHeader("Cache-Control", "must-revalidate, post-check=0, pre-check=0");
        $response->setHttpHeader("Cache-Control", "private", false);

        
        return $this->renderText(json_encode($employees))  ; 
               
    }
}
