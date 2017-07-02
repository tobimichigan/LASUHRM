<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class displayAttendanceSummaryReportCriteriaAction extends sfAction {

    public function execute($request) {

        $userObj = $this->getContext()->getUser()->getAttribute('user');
        $accessibleMenus = $userObj->getAccessibleReportSubMenus();
        $hasRight = false;

        foreach ($accessibleMenus as $menu) {
            if ($menu->getDisplayName() === __("Attendance Summary")) {
                $hasRight = true;
                break;
            }
        }

        if (!$hasRight) {
            return $this->renderText(__("You are not allowed to view this page").'!');
        }

        $this->reportId = $request->getParameter("reportId");
        
        $employeeList = $userObj->getEmployeeListForAttendanceTotalSummaryReport();

        if (is_array($employeeList)) {
            $lastRecord = end($employeeList);
            $this->lastEmpNumber = $lastRecord->getEmpNumber();
        } else {
            
            $this->lastEmpNumber = $employeeList->getLast()->getEmpNumber();
        }

        $this->form = new AttendanceTotalSummaryReportForm();

        $this->form->emoloyeeList = $employeeList;
    }

}

