<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class displayProjectReportCriteriaAction extends displayReportCriteriaAction {

    public function execute($request) {
        $this->userObj = $this->getContext()->getUser()->getAttribute('user');
        $accessibleMenus = $this->userObj->getAccessibleReportSubMenus();
        $hasRight = false;

        foreach ($accessibleMenus as $menu) {
            if ($menu->getDisplayName() === __("Project Reports")) {
                $hasRight = true;
                break;
            }
        }

        if (!$hasRight) {
            return $this->renderText(__("You are not allowed to view this page").'!');
        }
        parent::execute($request);
    }

    public function setReportCriteriaInfoInRequest($formValues) {

        $projectService = new ProjectService();
        $projectId = $formValues["project_name"];
        $projectName = $projectService->getProjectNameWithCustomerName($projectId);

        $this->getRequest()->setParameter('projectName', $projectName);
        $this->getRequest()->setParameter('projectDateRangeFrom', $formValues["project_date_range"]["from"]);
        $this->getRequest()->setParameter('projectDateRangeTo', $formValues["project_date_range"]["to"]);
    }

    public function setForward() {
        $this->forward('time', 'displayProjectReport');
    }

    public function hasStaticColumns() {
        return true;
    }

    public function setStaticColumns($formValues) {

        $staticColumns["fromDate"] = "";
        $staticColumns["toDate"] = "";
        $inputDatePattern = sfContext::getInstance()->getUser()->getDateFormat();
        $datepickerDateFormat = get_datepicker_date_format($inputDatePattern);

        if (($formValues["project_date_range"]["from"] != $datepickerDateFormat) && ($formValues["project_date_range"]["to"] != $datepickerDateFormat)) {

            if ($formValues["project_date_range"]["from"] != '') {
                $staticColumns["fromDate"] = $formValues["project_date_range"]["from"];
            }
            if ($formValues["project_date_range"]["to"] != '') {
                $staticColumns["toDate"] = $formValues["project_date_range"]["to"];
            }
        } else if (($formValues["project_date_range"]["from"] != $datepickerDateFormat) && ($formValues["project_date_range"]["to"] == $datepickerDateFormat)) {

            if ($formValues["project_date_range"]["from"] != '') {
                $staticColumns["fromDate"] = $formValues["project_date_range"]["from"];
            }
        } else if (($formValues["project_date_range"]["from"] == $datepickerDateFormat) && ($formValues["project_date_range"]["to"] != $datepickerDateFormat)) {

            if ($formValues["project_date_range"]["to"] != '') {
                $staticColumns["toDate"] = $formValues["project_date_range"]["to"];
            }
        }

        $staticColumns["projectId"] = $formValues["project_name"];

        if ($formValues["only_include_approved_timesheets"] == "on") {
            $staticColumns["onlyIncludeApprovedTimesheets"] = "on";
        } else {
            $staticColumns["onlyIncludeApprovedTimesheets"] = "off";
        }

        return $staticColumns;
    }

}

