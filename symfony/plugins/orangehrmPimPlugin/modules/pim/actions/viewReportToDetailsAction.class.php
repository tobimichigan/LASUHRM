<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Actions class for PIM module ReportTo
 */
class viewReportToDetailsAction extends basePimAction {

    private $employeeService;

    /**
     * Get EmployeeService
     * @returns EmployeeService
     */
    public function getEmployeeService() {
        if (is_null($this->employeeService)) {
            $this->employeeService = new EmployeeService();
            $this->employeeService->setEmployeeDao(new EmployeeDao());
        }
        return $this->employeeService;
    }

    /**
     * Set EmployeeService
     * @param EmployeeService $employeeService
     */
    public function setEmployeeService(EmployeeService $employeeService) {
        $this->employeeService = $employeeService;
    }

    /**
     * @param sfForm $form
     * @return
     */
    public function setForm(sfForm $form) {
        if (is_null($this->form)) {
            $this->form = $form;
        }
    }

    public function execute($request) {

        $loggedInEmpNum = $this->getUser()->getEmployeeNumber();

        $reportTo = $request->getParameter('reportto');
        $empNumber = (isset($membership['empNumber'])) ? $membership['empNumber'] : $request->getParameter('empNumber');
        $this->empNumber = $empNumber;
        $this->essUserMode = !$this->isAllowedAdminOnlyActions($loggedInEmpNum, $empNumber);
        
        $this->reportToPermissions = $this->getDataGroupPermissions(array('supervisor','subordinates'), $empNumber);
        $this->reportToSupervisorPermission = $this->getDataGroupPermissions('supervisor', $empNumber);
        $this->reportToSubordinatePermission = $this->getDataGroupPermissions('subordinates', $empNumber);
        
        $adminMode = $this->getUser()->hasCredential(Auth::ADMIN_ROLE);

        if (!$this->IsActionAccessible($empNumber)) {
            $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
        }

        if ($this->getUser()->hasFlash('templateMessage')) {
            list($this->messageType, $this->message) = $this->getUser()->getFlash('templateMessage');
        }

        $essMode = !$adminMode && !empty($loggedInEmpNum) && ($empNumber == $loggedInEmpNum);
        $param = array('empNumber' => $empNumber, 'ESS' => $essMode, 'reportToPermissions'=>$this->reportToPermissions);

        $this->setForm(new EmployeeReportToForm(array(), $param, true));

        $this->deleteSupForm = new EmployeeReportToSupervisorDeleteForm(array(), $param, true);
        $this->deleteSubForm = new EmployeeReportToSubordinateDeleteForm(array(), $param, true);
        $this->supDetails = $this->getEmployeeService()->getImmediateSupervisors($this->empNumber);
        $this->subDetails = $this->getEmployeeService()->getSubordinateListForEmployee($this->empNumber);

        $this->_setMessage();
    }
    
    protected function _setMessage() {
        $this->section = '';
        if ($this->getUser()->hasFlash('reportTo')) {
            $this->section = $this->getUser()->getFlash('reportTo');
        } 
    }

}
