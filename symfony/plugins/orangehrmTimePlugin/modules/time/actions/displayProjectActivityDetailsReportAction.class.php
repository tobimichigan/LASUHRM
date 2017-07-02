<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class displayProjectActivityDetailsReportAction extends displayReportAction {

    public function setConfigurationFactory() {

        $confFactory = new ProjectActivityDetailsReportListConfigurationFactory();

        $this->setConfFactory($confFactory);
    }

    public function setParametersForListComponent() {

        $projectService = new ProjectService();

        $projectId = $this->getRequest()->getParameter("projectId");
        $projectName = $projectService->getProjectNameWithCustomerName($projectId);

        $activityId = $this->getRequest()->getParameter("activityId");

        $reportGeneratorService = new ReportGeneratorService();
        $activityName = $reportGeneratorService->getProjectActivityNameByActivityId($activityId);
        $params = array(
            'projectName' => $projectName,
            'activityName' => $activityName,
            'projectDateRangeFrom' => $this->getRequest()->getParameter("from"),
            'projectDateRangeTo' => $this->getRequest()->getParameter("to"),
            'total' => $this->getRequest()->getParameter("total")
        );

        return $params;
    }

    public function setListHeaderPartial() {

        ohrmListComponent::setHeaderPartial("time/projectActivityDetailsReportHeader");
    }

    public function setValues() {

        $activityId = $this->getRequest()->getParameter("activityId");
        $fromDate = $this->getRequest()->getParameter("from");
        $toDate = $this->getRequest()->getParameter("to");
        $approved = $this->getRequest()->getParameter("onlyIncludeApprovedTimesheets");
        
        $values = array("activity_name" => $activityId, "project_date_range" => array("from" => $fromDate, "to" => $toDate), "only_include_approved_timesheets" => $approved);

        return $values;
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

