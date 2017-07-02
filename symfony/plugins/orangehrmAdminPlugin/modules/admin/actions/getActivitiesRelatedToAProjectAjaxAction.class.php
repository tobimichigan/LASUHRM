<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class getActivitiesRelatedToAProjectAjaxAction extends sfAction {

    public function execute($request) {

        $projectId = $request->getParameter("projectId");
        $timesheetDao = new TimesheetDao();
        $this->noProjectActivity = "no";

        if ($projectId == -1) {
            $this->activityList = "All";
        } else {
            $this->activityList = $timesheetDao->getProjectActivitiesByPorjectId($projectId);
            $this->allActivityList = $timesheetDao->getProjectActivitiesByPorjectId($projectId, true);
            if ($this->allActivityList == null) {
                $this->noProjectActivity = "yes";
            }
        }
    }

}