<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Action class for PIM module delete emergency contacts
 *
 */
class deleteEmergencyContactsAction extends basePimAction {

    /**
     * Delete employee emergencyContacts
     *
     * @param int $empNumber Employee number
     *
     * @return boolean true if successfully deleted, false otherwise
     */
    public function execute($request) {

        $empNumber = $request->getParameter('empNumber', false);
    	$this->form = new EmployeeEmergencyContactsDeleteForm(array(), array('empNumber' => $empNumber), true);
        
    	$this->form->bind($request->getParameter($this->form->getName()));        
        
        if (!$this->IsActionAccessible($empNumber)) {
            $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
        }
        
        if ($this->form->isValid()) {
                
                if (!$empNumber) {
                    throw new PIMServiceException("No Employee ID given");
                }
                $emergencyContactsToDelete = $request->getParameter('chkecontactdel', array());

                if ($emergencyContactsToDelete) {
                    $service = new EmployeeService();
                    $count = $service->deleteEmployeeEmergencyContacts($empNumber, $emergencyContactsToDelete);
                    $this->getUser()->setFlash('viewEmergencyContacts.success', __(TopLevelMessages::DELETE_SUCCESS));
                }
        }

        $this->redirect('pim/viewEmergencyContacts?empNumber=' . $empNumber);
    }

}
