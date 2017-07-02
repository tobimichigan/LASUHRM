<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Action class for PIM module delete memberships
 *
 */
class deleteMembershipsAction extends basePimAction {

    /**
     * Delete employee memberships
     *
     * @param int $empNumber Employee number
     *
     * @return boolean true if successfully deleted, false otherwise
     */
    public function execute($request) {

        $empNumber = $request->getParameter('empNumber', false);
        $this->form = new EmployeeMembershipsDeleteForm(array(), array('empNumber' => $empNumber), true);

        $this->form->bind($request->getParameter($this->form->getName()));
        $membershipPermissions = $this->getDataGroupPermissions('membership', $empNumber);
        
        if ($membershipPermissions->canDelete()) {
            if ($this->form->isValid()) {

                if (!$empNumber) {
                    throw new PIMServiceException("No Employee ID given");
                }

                $membershipDetails  = $this->_getSelectedMembershipDetails($request->getParameter('chkmemdel', array()));
                $empNumber          = $membershipDetails[0];
                $membershipIds      = $membershipDetails[1];  

                if (!empty($empNumber) && !empty($membershipIds)) {

                    $service = new EmployeeService();
                    $service->deleteEmployeeMemberships($empNumber, $membershipIds);
                    $this->getUser()->setFlash('memberships.success', __(TopLevelMessages::DELETE_SUCCESS));
                
                }
            
            }
        }
        $this->redirect('pim/viewMemberships?empNumber=' . $empNumber);
        
    }
    
    private function _getSelectedMembershipDetails($records) {
        
        $empNumber = null;
        $membershipIds = array();
        
        foreach ($records as $record) {
            
            $items = explode(" ", $record);
            
            $empNumber = trim($items[0]);
            $membershipIds[] = trim($items[1]);
            
        }
        
        return array($empNumber, $membershipIds);
        
    }

}
