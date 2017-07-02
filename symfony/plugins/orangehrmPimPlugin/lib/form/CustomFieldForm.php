<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Form class for Custom fields
 */
class CustomFieldForm extends BaseForm {

    
    public function configure() {
        
        $screens = $this->getScreens();
        
        $types = $this->getFieldTypes();
    
        $this->setWidgets(array(
            'field_num' => new sfWidgetFormInputHidden(),
            'name' => new sfWidgetFormInputText(),
            'type' => new sfWidgetFormSelect(array('choices' => $types)),
            'screen' => new sfWidgetFormSelect(array('choices' => $screens)),            
            'extra_data' => new sfWidgetFormInputText(),
        ));

        //
        // Remove default -- select -- option from valid values
        unset($types['']);
        unset($screens['']);
        
        $this->setValidators(array(
            'field_num' => new sfValidatorNumber(array('required' => false, 'min'=> 1, 'max'=>10)),
            'name' => new sfValidatorString(array('required' => true, 'max_length'=>250)),
            'type' => new sfValidatorChoice(array('choices' => array_keys($types))),
            'screen' => new sfValidatorChoice(array('choices' => array_keys($screens))),
            'extra_data' => new sfValidatorString(array('required' => false, 'trim'=>true, 'max_length'=>250))
        ));
       
        $this->widgetSchema->setNameFormat('customField[%s]');
    }
    
    public function getFieldTypes() {
        $types = array('' => '-- ' . __('Select') . ' --',
                      CustomField::FIELD_TYPE_STRING => __('Text or Number'),
                      CustomField::FIELD_TYPE_SELECT => __('Drop Down'));        
        
        return $types;
    }
    
    public function getScreens() {
        $screens = array('' =>  '-- ' . __('Select') . ' --',
                         CustomField::SCREEN_PERSONAL_DETAILS => __('Personal Details'),
                         CustomField::SCREEN_CONTACT_DETAILS => __('Contact Details'),
                         CustomField::SCREEN_EMERGENCY_CONTACTS => __('Emergency Contacts'),
                         CustomField::SCREEN_DEPENDENTS => __('Dependents'),
                         CustomField::SCREEN_IMMIGRATION => __('Immigration'),
                         CustomField::SCREEN_JOB => __('Job'),
                         CustomField::SCREEN_SALARY => __('Salary'),
                         CustomField::SCREEN_TAX_EXEMPTIONS => __('Tax Exemptions'),
                         CustomField::SCREEN_REPORT_TO => __('Report-to'),
                         CustomField::SCREEN_QUALIFICATIONS => __('Qualifications'),
                         CustomField::SCREEN_MEMBERSHIP => __('Memberships')
                        );
        return $screens;
    }

}