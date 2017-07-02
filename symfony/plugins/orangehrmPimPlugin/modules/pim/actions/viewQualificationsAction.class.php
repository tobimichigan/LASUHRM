<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class viewQualificationsAction extends basePimAction {
    
    /**
     * @param sfForm $form
     * @return
     */
    public function setWorkExperienceForm(sfForm $form) {
        if (is_null($this->workExperienceForm)) {
            $this->workExperienceForm = $form;
        }
    }

    /**
     * @param sfForm $form
     * @return
     */
    public function setEducationForm(sfForm $form) {
        if (is_null($this->educationForm)) {
            $this->educationForm = $form;
        }
    }
    
    /**
     * @param sfForm $form
     * @return
     */
    public function setSkillForm(sfForm $form) {
        if (is_null($this->skillForm)) {
            $this->skillForm = $form;
        }
    }    
    
    /**
     * @param sfForm $form
     * @return
     */
    public function setLanguageForm(sfForm $form) {
        if (is_null($this->languageForm)) {
            $this->languageForm = $form;
        }
    } 
    
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
        
        $this->showBackButton = false;
        $empNumber = $request->getParameter('empNumber');
        $this->empNumber = $empNumber;
        
        $this->workExperiencePermissions = $this->getDataGroupPermissions('qualification_work', $empNumber);
        $this->educationPermissions = $this->getDataGroupPermissions('qualification_education', $empNumber);
        $this->skillPermissions = $this->getDataGroupPermissions('qualification_skills', $empNumber);
        $this->languagePermissions = $this->getDataGroupPermissions('qualification_languages', $empNumber);
        $this->licensePermissions = $this->getDataGroupPermissions('qualification_license', $empNumber);

        if (!$this->IsActionAccessible($empNumber)) {
            $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
        }
        
        $this->_setMessage();

        $this->setWorkExperienceForm(new WorkExperienceForm(array(), array('empNumber' => $empNumber, 
            'workExperiencePermissions' => $this->workExperiencePermissions), true));
        $this->setEducationForm(new EmployeeEducationForm(array(), array('empNumber' => $empNumber, 
            'educationPermissions' => $this->educationPermissions), true));
        $this->setSkillForm(new EmployeeSkillForm(array(), array('empNumber' => $empNumber, 
            'skillPermissions' => $this->skillPermissions), true));
        $this->setLanguageForm(new EmployeeLanguageForm(array(), array('empNumber' => $empNumber, 
            'languagePermissions' => $this->languagePermissions), true));
        $this->setLicenseForm(new EmployeeLicenseForm(array(), array('empNumber' => $empNumber, 
            'licensePermissions' => $this->licensePermissions), true));  
        
        $this->listForm = new DefaultListForm(array(),array(),true);
    }
    
    protected function _setMessage() {
        $this->section = '';
        if ($this->getUser()->hasFlash('qualificationSection')) {
            $this->section = $this->getUser()->getFlash('qualificationSection');
        } 
    }
}
?>