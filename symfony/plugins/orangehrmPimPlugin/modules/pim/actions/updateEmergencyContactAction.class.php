<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Actions class for PIM module updateEmergencyContact
 */
class updateEmergencyContactAction extends basePimAction {

    /**
     * Add / update employee emergencyContact
     *
     * @param int $empNumber Employee number
     *
     * @return boolean true if successfully assigned, false otherwise
     */
    public function execute($request) {

        $contacts = $request->getParameter('emgcontacts');
        $empNumber = (isset($contacts['empNumber'])) ? $contacts['empNumber'] : $request->getParameter('empNumber');
        $this->empNumber = $empNumber;

        $this->emergencyContactPermissions = $this->getDataGroupPermissions('emergency_contacts', $empNumber);

        $loggedInEmpNum = $this->getUser()->getEmployeeNumber();
        $adminMode = $this->getUser()->hasCredential(Auth::ADMIN_ROLE);

        if (!$this->IsActionAccessible($empNumber)) {
            $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
        }

        $essMode = !$adminMode && !empty($loggedInEmpNum) && ($empNumber == $loggedInEmpNum);

        $param = array('empNumber' => $empNumber, 'ESS' => $essMode, 'emergencyContactPermissions' => $this->emergencyContactPermissions);

        $this->form = new EmployeeEmergencyContactForm(array(), $param, true);

        if ($this->emergencyContactPermissions->canUpdate() || $this->emergencyContactPermissions->canCreate()) {
            if ($this->getRequest()->isMethod('post')) {

                $this->form->bind($request->getParameter($this->form->getName()));
                if ($this->form->isValid()) {
                    $this->form->save();
                    $this->getUser()->setFlash('viewEmergencyContacts.success', __(TopLevelMessages::SAVE_SUCCESS));
                }
            }
        }

        $empNumber = $request->getParameter('empNumber');

        $this->redirect('pim/viewEmergencyContacts?empNumber=' . $empNumber);
    }

}
