<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

class LicenseForm extends BaseForm {
    
    private $licenseService;
    
    public function getLicenseService() {
        
        if (!($this->licenseService instanceof LicenseService)) {
            $this->licenseService = new LicenseService();
        }
        
        return $this->licenseService;
    }

    public function setLicenseService($licenseService) {
        $this->licenseService = $licenseService;
    }

    public function configure() {

        $this->setWidgets(array(
            'id' => new sfWidgetFormInputHidden(),
            'name' => new sfWidgetFormInputText()
        ));

        $this->setValidators(array(
            'id' => new sfValidatorNumber(array('required' => false)),
            'name' => new sfValidatorString(array('required' => true, 'max_length' => 120))
        ));

        $this->widgetSchema->setNameFormat('license[%s]');

        $this->setDefault('id', '');
	}
    
    public function save() {
        
        $id = $this->getValue('id');
        
        if (empty($id)) {
            $license = new License();
            $message = array('messageType' => 'success', 'message' => __(TopLevelMessages::SAVE_SUCCESS));
        } else {
            $license = $this->getLicenseService()->getLicenseById($id);
            $message = array('messageType' => 'success', 'message' => __(TopLevelMessages::UPDATE_SUCCESS));
        }
        
        $license->setName($this->getValue('name'));
        $this->getLicenseService()->saveLicense($license);        
        
        return $message;
        
    }

}
