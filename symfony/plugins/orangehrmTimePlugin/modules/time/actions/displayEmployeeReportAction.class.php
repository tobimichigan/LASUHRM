<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class displayEmployeeReportAction extends displayReportAction {

    public function setParametersForListComponent() {

        $params = array(
            'empName' => $this->getRequest()->getParameter("empName"),
        );

        return $params;
    }

    public function setConfigurationFactory() {

        $confFactory = new EmployeeReportListConfigurationFactory();

        $this->setConfFactory($confFactory);
    }

    public function setListHeaderPartial() {

        ohrmListComponent::setHeaderPartial("time/employeeReportHeader");
    }

    public function setValues() {
        
    }
    
    public function setInitialActionDetails($request) {

        $initialActionName = $request->getParameter('initialActionName', '');

        if (empty($initialActionName)) {
            $request->setParameter('initialActionName', 'displayEmployeeReportCriteria');
        } else {
            $request->setParameter('initialActionName', $initialActionName);
        }        
        
    }

}

