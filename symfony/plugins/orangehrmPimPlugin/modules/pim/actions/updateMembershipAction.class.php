<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Actions class for PIM module updateMembership
 */

class updateMembershipAction extends basePimAction {

    /**
     * Add / update employee membership
     *
     * @param int $empNumber Employee number
     *
     * @return boolean true if successfully assigned, false otherwise
     */
    public function execute($request) {

        $memberships = $request->getParameter('memberships');
        $empNumber = (isset($memberships['empNumber']))?$memberships['empNumber']:$request->getParameter('empNumber');
        $this->empNumber = $empNumber;


        if (!$this->IsActionAccessible($empNumber)) {
            $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
        }
        
        $loggedInEmpNum = $this->getUser()->getEmployeeNumber();
        $adminMode = $this->getUser()->hasCredential(Auth::ADMIN_ROLE);
        $essMode = !$adminMode && !empty($loggedInEmpNum) && ($empNumber == $loggedInEmpNum);
        $this->membershipPermissions = $this->getDataGroupPermissions('membership', $empNumber);
        $param = array('empNumber' => $empNumber, 'ESS' => $essMode, 'membershipPermissions' => $this->membershipPermissions);

        $this->form = new EmployeeMembershipForm(array(), $param, true);
        if ($this->membershipPermissions->canUpdate() || $this->membershipPermissions->canCreate()){
            if ($this->getRequest()->isMethod('post')) {

                $this->form->bind($request->getParameter($this->form->getName()));
                if ($this->form->isValid()) {
                    $this->form->save();
                    $this->getUser()->setFlash('memberships.success', __(TopLevelMessages::SAVE_SUCCESS));
                }
            }
        }
        $empNumber = $request->getParameter('empNumber');

        $this->redirect('pim/viewMemberships?empNumber='. $empNumber);
    }

}
