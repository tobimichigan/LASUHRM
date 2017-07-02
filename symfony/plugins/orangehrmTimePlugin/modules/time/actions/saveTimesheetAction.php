<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class saveTimesheetAction extends sfAction {

    private $timesheetForm;

    public function execute(sfWebRequest $request) {

        if ($request->isMethod('post')) {
            
            $this->getTimesheetForm()->bind($request->getParameterHolder()->getAll());

            if ($request->getParameter('btnSave')) {
                if ($this->numberOfRows == null) {
                    $this->getTimesheetService()->saveTimesheetItems($request->getParameter('initialRows'), 1, 1, $this->currentWeekDates, $this->totalRows);
                    $this->messageData = array('SUCCESS', __(TopLevelMessages::SAVE_SUCCESS));
                    $this->redirect('time/editTimesheet');
                } else {
                    $this->getTimesheetService()->saveTimesheetItems($request->getParameter('initialRows'), $this->employeeId, $this->timesheetId, $this->currentWeekDates, $this->totalRows);
                    $this->messageData = array('SUCCESS', __(TopLevelMessages::SAVE_SUCCESS));
                    $this->redirect('time/editTimesheet');
                }
            }
            if ($request->getParameter('btnRemoveRows')) {
                if ($this->numberOfRows == null) {
                    $this->messageData = array('WARNING', __("Can not delete an empty row"));
                    $this->redirect('time/editTimesheet');
                } else {
                    $this->getTimesheetService()->deleteTimesheetItems($request->getParameter('initialRows'), $this->employeeId, $this->timesheetId);
                    $this->messageData = array('SUCCESS', __(TopLevelMessages::DELETE_SUCCESS));
                    $this->redirect('time/editTimesheet');
                }
            }
        }
    }

    public function getTimesheetForm() {

        if (is_null($this->timesheetForm)) {
            $this->timesheetForm = new TimesheetForm();
        }

        return $this->timesheetForm;
    }

}

