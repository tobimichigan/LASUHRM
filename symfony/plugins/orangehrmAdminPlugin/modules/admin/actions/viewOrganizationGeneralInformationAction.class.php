<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */
class viewOrganizationGeneralInformationAction extends sfAction {

    public function setForm(sfForm $form) {
        if (is_null($this->form)) {
            $this->form = $form;
        }
    }

    public function execute($request) {

        $usrObj = $this->getUser()->getAttribute('user');
        if (!($usrObj->isAdmin())) {
            $this->redirect('pim/viewPersonalDetails');
        }

        $this->setForm(new OrganizationGeneralInformationForm());
        $employeeService = new EmployeeService();
        $this->employeeCount = $employeeService->getEmployeeCount();

        if ($request->isMethod('post')) {

            $this->form->bind($request->getParameter($this->form->getName()));
            if ($this->form->isValid()) {
                $result = $this->form->save();
                $name = $this->form->getValue('name');
                $organizationName = (!empty($name)) ? $name : __("Organization");
                $companyStructureService = new CompanyStructureService();
                $companyStructureService->setOrganizationName($organizationName);
                $this->getUser()->setFlash('generalinformation.success', __(TopLevelMessages::SAVE_SUCCESS));
            }
        }
    }

}

