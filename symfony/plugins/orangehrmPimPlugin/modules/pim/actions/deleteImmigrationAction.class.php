<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class deleteImmigrationAction extends basePimAction {

    public function execute($request) {
        $form = new DefaultListForm(array(), array(), true);
        $form->bind($request->getParameter($form->getName()));
        $deleteIds = $request->getParameter('chkImmigration');
        $empNumber = $request->getParameter('empNumber');
        
        $this->immigrationPermission = $this->getDataGroupPermissions('immigration', $empNumber);

        if ($request->isMethod('post')) {
            if (!$this->IsActionAccessible($empNumber)) {
                $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
            }
            if ($this->immigrationPermission->canDelete()) {
                if ($form->isValid()) {
                    $this->getEmployeeService()->deleteEmployeeImmigrationRecords($empNumber, $deleteIds);
                    $this->getUser()->setFlash('immigration.success', __(TopLevelMessages::DELETE_SUCCESS));
                }
                $this->redirect('pim/viewImmigration?empNumber=' . $empNumber);
            }
        }
    }

}
