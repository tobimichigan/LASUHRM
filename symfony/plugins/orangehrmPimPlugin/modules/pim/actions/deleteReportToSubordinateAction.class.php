<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Action class for PIM module delete 
 *
 */
class deleteReportToSubordinateAction extends basePimAction {

    /**
     * Delete employee memberships
     *
     * @param int $empNumber Employee number
     *
     * @return boolean true if successfully deleted, false otherwise
     */
    public function execute($request) {

        $empNumber = $request->getParameter('empNumber', false);
        $this->form = new EmployeeReportToSubordinateDeleteForm(array(), array('empNumber' => $empNumber), true);

        $this->reportToSubordinatePermission = $this->getDataGroupPermissions('subordinates', $empNumber);

        $this->form->bind($request->getParameter($this->form->getName()));

        if ($this->form->isValid()) {

            if (!$empNumber) {
                throw new PIMServiceException("No Employee ID given");
            }
            $subToDelete = $request->getParameter('chksubdel', array());
            if ($this->reportToSubordinatePermission->canDelete()) {
                if ($subToDelete) {

                    $service = new EmployeeService();
                    $count = $service->deleteReportToObject($subToDelete);
                    $this->getUser()->setFlash('success', __(TopLevelMessages::DELETE_SUCCESS));
                }
            }
        }

        $this->getUser()->setFlash('reportTo', 'subordinates');
        $this->redirect('pim/viewReportToDetails?empNumber=' . $empNumber);
    }

}
