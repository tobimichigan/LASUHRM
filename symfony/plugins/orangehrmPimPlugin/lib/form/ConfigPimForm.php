<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * ConfigPimForm
 *
 */
class ConfigPimForm extends sfForm {

    private $formWidgets = array();

    public function configure() {
        $orangeConfig = $this->getOption('orangeconfig');
        
        $showDeprecatedFields = $orangeConfig->getAppConfValue(ConfigService::KEY_PIM_SHOW_DEPRECATED);
        $showSSN = $orangeConfig->getAppConfValue(ConfigService::KEY_PIM_SHOW_SSN);
        $showSIN = $orangeConfig->getAppConfValue(ConfigService::KEY_PIM_SHOW_SIN);
        $showTax = $orangeConfig->getAppConfValue(ConfigService::KEY_PIM_SHOW_TAX_EXEMPTIONS);
        
        $this->formWidgets['chkDeprecateFields'] = new sfWidgetFormInputCheckbox(array(), array('value' => 'on'));
        $this->formWidgets['chkShowSSN'] = new sfWidgetFormInputCheckbox(array(), array('value' => 'on'));
        $this->formWidgets['chkShowSIN'] = new sfWidgetFormInputCheckbox(array(), array('value' => 'on'));
        $this->formWidgets['chkShowTax'] = new sfWidgetFormInputCheckbox(array(), array('value' => 'on'));
        
        
        if ($showDeprecatedFields) {
            $this->formWidgets['chkDeprecateFields']->setAttribute('checked', 'checked');
        }
        if ($showSSN) {
            $this->formWidgets['chkShowSSN']->setAttribute('checked', 'checked');
        }
        if ($showSIN) {
            $this->formWidgets['chkShowSIN']->setAttribute('checked', 'checked');
        }
        if ($showTax) {
            $this->formWidgets['chkShowTax']->setAttribute('checked', 'checked');
        }
            
        $this->setWidgets($this->formWidgets);

        $this->setValidators(array(
                'chkDeprecateFields' => new sfValidatorString(array('required' => false)),
                'chkShowSSN' => new sfValidatorString(array('required' => false)),
                'chkShowSIN' => new sfValidatorString(array('required' => false)),
                'chkShowTax' => new sfValidatorString(array('required' => false)),            
            ));

        $this->widgetSchema->setNameFormat('configPim[%s]');
    }
}
?>
