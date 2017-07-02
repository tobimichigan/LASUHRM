<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class viewEmployeeTimesheetAction extends sfAction {

    private $employeeNumber;
    private $timesheetService;

    public function getTimesheetService() {

        if (is_null($this->timesheetService)) {

            $this->timesheetService = new TimesheetService();
        }

        return $this->timesheetService;
    }

    public function execute($request) {

        $this->form = new viewEmployeeTimesheetForm();


        if ($request->isMethod("post")) {


            $this->form->bind($request->getParameter('time'));

            if ($this->form->isValid()) {

                $this->employeeId = $this->form->getValue('employeeId');
                $startDaysListForm = new startDaysListForm(array(), array('employeeId' => $this->employeeId));
                $dateOptions = $startDaysListForm->getDateOptions();

                if ($dateOptions == null) {
                    $this->getContext()->getUser()->setFlash('warning.nofade', __('No Timesheets Found'));
                    $this->redirect('time/createTimesheetForSubourdinate?' . http_build_query(array('employeeId' => $this->employeeId)));
                }

                $this->redirect('time/viewTimesheet?' . http_build_query(array('employeeId' => $this->employeeId)));
            }
        }

        $userObj = $this->getContext()->getUser()->getAttribute("user");
        $this->form->employeeList = $userObj->getEmployeeNameList();

        $this->pendingApprovelTimesheets = $userObj->getActionableTimesheets();
    }

}

