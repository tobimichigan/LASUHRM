<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Actions class for PIM module memberships
 */
class viewMembershipsAction extends basePimAction {

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

        $membership = $request->getParameter('membership');
        $empNumber = (isset($membership['empNumber'])) ? $membership['empNumber'] : $request->getParameter('empNumber');
        $this->empNumber = $empNumber;
        
        $this->membershipPermissions = $this->getDataGroupPermissions('membership', $empNumber);
        $adminMode = $this->getUser()->hasCredential(Auth::ADMIN_ROLE);

        if (!$this->IsActionAccessible($empNumber)) {
            $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
        }
        
        $essMode = !$adminMode && !empty($loggedInEmpNum) && ($empNumber == $loggedInEmpNum);
        $param = array('empNumber' => $empNumber, 'ESS' => $essMode, 'membershipPermissions' => $this->membershipPermissions);

        $this->setForm(new EmployeeMembershipForm(array(), $param, true));
        $this->deleteForm = new EmployeeMembershipsDeleteForm(array(), $param, true);
        $this->membershipDetails = $this->getEmployeeService()->getEmployeeMemberships($this->empNumber);
        
    }

}
