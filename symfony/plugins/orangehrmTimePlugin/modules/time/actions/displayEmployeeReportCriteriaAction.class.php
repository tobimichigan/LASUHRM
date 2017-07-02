<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class displayEmployeeReportCriteriaAction extends displayReportCriteriaAction {

    public function execute($request) {
        $this->userObj = $this->getContext()->getUser()->getAttribute('user');
        $accessibleMenus = $this->userObj->getAccessibleReportSubMenus();
        $hasRight = false;

        foreach ($accessibleMenus as $menu) {
            if ($menu->getDisplayName() === __("Employee Reports")) {
                $hasRight = true;
                break;
            }
        }

        if (!$hasRight) {
            return $this->renderText(__("You are not allowed to view this page")."!");
        }
        parent::execute($request);
    }

    public function setReportCriteriaInfoInRequest($formValues) {

        $employee = $formValues["employee"];
        $empName = $employee['empName'];
        
        $this->getRequest()->setParameter('empName', $empName);
    }

    public function setForward() {

        $this->forward('time', 'displayEmployeeReport');
    }

    public function setStaticColumns($formValues) {
        
    }

}

