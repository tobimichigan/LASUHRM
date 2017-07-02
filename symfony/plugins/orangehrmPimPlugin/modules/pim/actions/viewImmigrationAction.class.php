<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class viewImmigrationAction extends basePimAction {

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
        $this->showBackButton = true;
        $immigration = $request->getParameter('immigration');
        $empNumber = (isset($immigration['emp_number'])) ? $immigration['emp_number'] : $request->getParameter('empNumber');
        $this->empNumber = $empNumber;

        $this->immigrationPermission = $this->getDataGroupPermissions('immigration', $empNumber);

        //hiding the back button if its self ESS view
        if ($loggedInEmpNum == $empNumber) {

            $this->showBackButton = false;
        }

        $param = array('empNumber' => $empNumber, 'immigrationPermission' => $this->immigrationPermission);
        $this->setForm(new EmployeeImmigrationDetailsForm(array(), $param, true));
        $this->empPassportDetails = $this->getEmployeeService()->getEmployeeImmigrationRecords($this->empNumber);

        if (!$this->IsActionAccessible($empNumber)) {
            $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
        }
        
        if ($this->immigrationPermission->canUpdate() || $this->immigrationPermission->canCreate()) {
            if ($request->isMethod('post')) {

                $this->form->bind($request->getParameter($this->form->getName()));

                if ($this->form->isValid()) {
                    $empPassport = $this->form->populateEmployeePassport();
                    $this->getEmployeeService()->saveEmployeeImmigrationRecord($empPassport);
                    $this->getUser()->setFlash('immigration.success', __(TopLevelMessages::SAVE_SUCCESS));
                    $this->redirect('pim/viewImmigration?empNumber=' . $empNumber);
                }
            }
            $this->listForm = new DefaultListForm(array(), array(), true);
        }
    }

}
