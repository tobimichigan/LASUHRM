<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class saveDeleteLicenseAction extends basePimAction {
    
    /**
     * @param sfForm $form
     * @return
     */
    public function setLicenseForm(sfForm $form) {
        if (is_null($this->licenseForm)) {
            $this->licenseForm = $form;
        }
    }
    
    public function execute($request) {
        $form = new DefaultListForm(array(), array(), true);
        $form->bind($request->getParameter($form->getName()));
        $license = $request->getParameter('license');
        $empNumber = (isset($license['emp_number']))?$license['emp_number']:$request->getParameter('empNumber');

        if (!$this->IsActionAccessible($empNumber)) {
            $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
        }
        
        $this->licensePermissions = $this->getDataGroupPermissions('qualification_license', $empNumber);
        $this->setLicenseForm(new EmployeeLicenseForm(array(), array('empNumber' => $empNumber, 'licensePermissions' => $this->licensePermissions), true));

        if ($request->isMethod('post')) {
            if ( $request->getParameter('option') == "save") {

                $this->licenseForm->bind($request->getParameter($this->licenseForm->getName()));

                if ($this->licenseForm->isValid()) {
                    $license = $this->getLicense($this->licenseForm);
                    if (!empty($license)){
                        $this->getEmployeeService()->saveEmployeeLicense($license);
                        $this->getUser()->setFlash('license.success', __(TopLevelMessages::SAVE_SUCCESS));
                    }
                } else {
                    $this->getUser()->setFlash('license.warning', __('Form Validation Failed'));
                }
            }

            //this is to delete 
            if ($this->licensePermissions->canDelete()) {
                if ($request->getParameter('option') == "delete") {
                    $deleteIds = $request->getParameter('delLicense');

                    if(count($deleteIds) > 0) {
                        if ($form->isValid()) {
                            $this->getEmployeeService()->deleteEmployeeLicenses($empNumber, $request->getParameter('delLicense'));
                            $this->getUser()->setFlash('license.success', __(TopLevelMessages::DELETE_SUCCESS));
                        }
                    }
                }
            }
        }
        $this->getUser()->setFlash('qualificationSection', 'license');
        $this->redirect('pim/viewQualifications?empNumber='. $empNumber . '#license');
    }

    private function getLicense(sfForm $form) {

        $post = $form->getValues();

        $license = $this->getEmployeeService()->getEmployeeLicences($post['emp_number'], $post['code']);
        
        $isAllowed = FALSE;
        if (!$license instanceof EmployeeLicense) {
            if($this->licensePermissions->canCreate()){
                $license = new EmployeeLicense();
                $isAllowed = TRUE;
            }
        } else {
            if($this->licensePermissions->canUpdate()){
                $isAllowed = TRUE;                
            }
        }
        if ($isAllowed) {
            $license->empNumber = $post['emp_number'];
            $license->licenseId = $post['code'];
            $license->licenseNo = $post['license_no'];
            $license->licenseIssuedDate = $post['date'];
            $license->licenseExpiryDate = $post['renewal_date'];
            return $license;
        } else {
            return NULL;
        }       
                
    }
}