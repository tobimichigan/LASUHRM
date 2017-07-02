<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Actions class for PIM module deleteAttachmentAction
 */
class deleteAttachmentsAction extends basePimAction {

    /**
     * Delete employee attachments
     *
     * @param int $empNumber Employee number
     *
     * @return boolean true if successfully deleted, false otherwise
     */
    public function execute($request) {
        $this->form = new EmployeeAttachmentDeleteForm(array(), array(), true);

        $this->form->bind($request->getParameter($this->form->getName()));
        if ($this->form->isValid()) {
            $empId = $request->getParameter('EmpID', false);
            if (!$empId) {
                throw new PIMServiceException("No Employee ID given");
            }
            
            if (!$this->IsActionAccessible($empId)) {
                $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
            }
            
            $attachmentsToDelete = $request->getParameter('chkattdel', array());
            if ($attachmentsToDelete) {
                $service = new EmployeeService();
                $service->deleteEmployeeAttachments($empId, $attachmentsToDelete);
                $this->getUser()->setFlash('listAttachmentPane.success', __(TopLevelMessages::DELETE_SUCCESS));
            }
        }

        $this->redirect($this->getRequest()->getReferer(). '#attachments');
    }

}
