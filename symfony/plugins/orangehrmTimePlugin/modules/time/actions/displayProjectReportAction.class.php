<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class displayProjectReportAction extends displayReportAction {

    public function setParametersForListComponent() {

        $params = array(
            'projectName' => $this->getRequest()->getParameter("projectName"),
            'projectDateRangeFrom' => $this->getRequest()->getParameter("projectDateRangeFrom"),
            'projectDateRangeTo' => $this->getRequest()->getParameter("projectDateRangeTo"),
        );

        return $params;
    }

    public function setConfigurationFactory() {

        $confFactory = new ProjectReportListConfigurationFactory();

        $this->setConfFactory($confFactory);
    }

    public function setListHeaderPartial() {

        ohrmListComponent::setHeaderPartial("time/projectReportHeader");
    }

    public function setValues() {
        
    }
    public function setInitialActionDetails($request) {

        $initialActionName = $request->getParameter('initialActionName', '');

        if (empty($initialActionName)) {
            $request->setParameter('initialActionName', 'displayProjectReportCriteria');
        } else {
            $request->setParameter('initialActionName', $initialActionName);
        }        
        
    }

}

