<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

class LanguageForm extends BaseForm {
    
    private $languageService;
    
    public function getLanguageService() {
        
        if (!($this->languageService instanceof LanguageService)) {
            $this->languageService = new LanguageService();
        }
        
        return $this->languageService;
    }

    public function setLanguageService($languageService) {
        $this->languageService = $languageService;
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

        $this->widgetSchema->setNameFormat('language[%s]');

        $this->setDefault('id', '');
	}
    
    public function save() {
        
        $id = $this->getValue('id');
        
        if (empty($id)) {
            $language = new Language();
            $message = array('messageType' => 'success', 'message' => __(TopLevelMessages::SAVE_SUCCESS));
        } else {
            $language = $this->getLanguageService()->getLanguageById($id);
            $message = array('messageType' => 'success', 'message' => __(TopLevelMessages::UPDATE_SUCCESS));
        }
        
        $language->setName($this->getValue('name'));
        $this->getLanguageService()->saveLanguage($language);        
        
        return $message;
        
    }

}
