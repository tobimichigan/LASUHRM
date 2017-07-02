<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class editTimesheetAction extends sfAction {

    private $timesheetService;
    private $timesheetPeriodService;
    private $totalRows = 0;
    private $employeeService;

    public function getEmployeeService() {

        if (is_null($this->employeeService)) {
            $this->employeeService = new EmployeeService();
        }

        return $this->employeeService;
    }

    public function setEmployeeService($employeeService) {

        if ($employeeService instanceof EmployeeService) {
            $this->employeeService = $employeeService;
        }
    }

    public function getTimesheetService() {

        if (is_null($this->timesheetService)) {

            $this->timesheetService = new TimesheetService();
        }

        return $this->timesheetService;
    }

    public function getTimesheetPeriodService() {

        if (is_null($this->timesheetPeriodService)) {

            $this->timesheetPeriodService = new TimesheetPeriodService();
        }

        return $this->timesheetPeriodService;
    }

    public function execute($request) {
        
        $this->listForm = new DefaultListForm(array(),array(),true);

        $userObj = $this->getContext()->getUser()->getAttribute('user');
        $employeeIdOfTheUser = $userObj->getEmployeeNumber();

        /* For highlighting corresponding menu item */  
        if ($userObj->isAdmin()) {
            $request->setParameter('initialActionName', 'viewEmployeeTimesheet'); 
        } else {
            $request->setParameter('initialActionName', 'viewMyTimesheet'); 
        }
        $this->backAction = $request->getParameter('actionName');
        $this->timesheetId = $request->getParameter('timesheetId');
        $this->employeeId = $request->getParameter('employeeId');

        $this->_checkAuthentication($this->employeeId, $userObj);

        if ($this->employeeId == $employeeIdOfTheUser) {
            $this->employeeName == null;
        } else {
            $this->employeeName = $this->getEmployeeName($this->employeeId);
        }



        $timesheet = $this->getTimesheetService()->getTimesheetById($this->timesheetId);

        $this->date = $timesheet->getStartDate();
        $this->endDate = $timesheet->getEndDate();
        $this->startDate = $this->date;
        $this->noOfDays = $this->timesheetService->dateDiff($this->startDate, $this->endDate);
        $values = array('date' => $this->startDate, 'employeeId' => $this->employeeId, 'timesheetId' => $this->timesheetId, 'noOfDays' => $this->noOfDays);
        $this->timesheetForm = new TimesheetForm(array(), $values);
        $this->currentWeekDates = $this->timesheetForm->getDatesOfTheTimesheetPeriod($this->startDate, $this->endDate);
        $this->timesheetItemValuesArray = $this->timesheetForm->getTimesheet($this->startDate, $this->employeeId, $this->timesheetId);

        $this->messageData = array($request->getParameter('message[0]'), $request->getParameter('message[1]'));

        if ($this->timesheetItemValuesArray == null) {

            $this->totalRows = 0;
            $this->timesheetForm = new TimesheetForm(array(), $values);
        } else {

            $this->totalRows = sizeOf($this->timesheetItemValuesArray);
            $this->timesheetForm = new TimesheetForm(array(), $values);
        }

        if ($request->isMethod('post')) {


            if ($request->getParameter('btnSave')) {
                
                if( $this->timesheetForm->getCSRFtoken() == $request->getParameter('_csrf_token')){
                    $backAction = $this->backAction;
                    $this->getTimesheetService()->saveTimesheetItems($request->getParameter('initialRows'), $this->employeeId, $this->timesheetId, $this->currentWeekDates, $this->totalRows);
                    $this->messageData = array('success', __(TopLevelMessages::SAVE_SUCCESS));
                    $startingDate = $this->timesheetService->getTimesheetById($this->timesheetId)->getStartDate();
                    $this->redirect('time/' . $backAction . '?' . http_build_query(array('message' => $this->messageData, 'timesheetStartDate' => $startingDate, 'employeeId' => $this->employeeId)));
                 }

            }

            if ($request->getParameter('buttonRemoveRows')) {


                $this->messageData = array('success', __('Successfully Removed'));
            }
        }
    }

    protected function _checkAuthentication($empNumber, $user) {

        $logedInEmpNumber = $user->getEmployeeNumber();

        if ($logedInEmpNumber == $empNumber) {
            return;
        }

        if ($user->isAdmin()) {
            return;
        }

        $subordinateIdList = $this->getEmployeeService()->getSubordinateIdListBySupervisorId($logedInEmpNumber);

        if (empty($subordinateIdList)) {
            $this->redirect('auth/login');
        }

        if (!in_array($empNumber, $subordinateIdList)) {
            $this->redirect('auth/login');
        }
    }

    private function getEmployeeName($employeeId) {

        $employeeService = new EmployeeService();
        $employee = $employeeService->getEmployee($employeeId);

        $name = $employee->getFirstName() . " " . $employee->getLastName();

        if ($employee->getTerminationId()) {
            $name = $name . ' (' . __('Past Employee') . ')';
        }

        return $name;
    }

}

