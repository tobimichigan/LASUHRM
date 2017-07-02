<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

class LeaveTypeForm extends orangehrmForm {

    private $updateMode = false;
    private $leaveTypeService;

    public function configure() {

        sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');
        
        $this->setWidgets(array(
            'txtLeaveTypeName' => new sfWidgetFormInput(array(), array('size' => 30)),
            'excludeIfNoEntitlement' => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1)),
            'hdnOriginalLeaveTypeName' => new sfWidgetFormInputHidden(),
            'hdnLeaveTypeId' => new sfWidgetFormInputHidden()
        ));        
        
        $this->getWidgetSchema()->setLabel('txtLeaveTypeName', __('Name') .' <em>*</em>');
        $this->getWidgetSchema()->setLabel('excludeIfNoEntitlement', '<a id="exclude_link" href="#">' . __('Is entitlement situational') . '</a>');
        
        $this->setValidators(array(
            'txtLeaveTypeName' => 
                new sfValidatorString(array(
                        'required' => true,
                        'max_length' => 50
                    ),
                    array(
                        'required' => __('Required'),
                        'max_length' => __('Leave type name should be 50 characters or less in length')
                    )),
            'excludeIfNoEntitlement' => new sfValidatorBoolean(),
            'hdnOriginalLeaveTypeName' => new sfValidatorString(array('required' => false)),
            'hdnLeaveTypeId' => new sfValidatorString(array('required' => false))          
        ));
        $this->widgetSchema->setNameFormat('leaveType[%s]');

    }

    public function setDefaultValues($leaveTypeId) {

        $leaveTypeService = $this->getLeaveTypeService();
        $leaveTypeObject = $leaveTypeService->readLeaveType($leaveTypeId);

        if ($leaveTypeObject instanceof LeaveType) {

            $this->setDefault('hdnLeaveTypeId', $leaveTypeObject->getId());
            $this->setDefault('txtLeaveTypeName', $leaveTypeObject->getName());
            $this->setDefault('excludeIfNoEntitlement', $leaveTypeObject->getExcludeInReportsIfNoEntitlement());
            $this->setDefault('hdnOriginalLeaveTypeName', $leaveTypeObject->getName());
        }
    }

    public function setUpdateMode() {
        $this->updateMode = true;
    }    

    public function isUpdateMode() {
        return $this->updateMode;
    }
    
    public function getLeaveTypeObject() {
        
        $leaveTypeId = $this->getValue('hdnLeaveTypeId');
        
        if (!empty($leaveTypeId)) {
            $leaveType = $this->getLeaveTypeService()->readLeaveType($leaveTypeId);
        } else {
            $leaveType = new LeaveType();
            $leaveType->setDeleted(0);
        }        
        
        $leaveType->setName($this->getValue('txtLeaveTypeName'));
        $leaveType->setExcludeInReportsIfNoEntitlement($this->getValue('excludeIfNoEntitlement'));

        return $leaveType;        
    }
    
    public function getDeletedLeaveTypesJsonArray() {

        $leaveTypeService = $this->getLeaveTypeService();
        $deletedLeaveTypes = $leaveTypeService->getDeletedLeaveTypeList();

        $deletedTypesArray = array();

        foreach ($deletedLeaveTypes as $deletedLeaveType) {
            $deletedTypesArray[] = array('id' => $deletedLeaveType->getId(),
                                         'name' => $deletedLeaveType->getName());
        }

        return json_encode($deletedTypesArray);
    }

    public function getLeaveTypeService() {

        if(is_null($this->leaveTypeService)) {
            $this->leaveTypeService = new LeaveTypeService();
        }

        return $this->leaveTypeService;

    }    
    
    public function setLeaveTypeService($leaveTypeService) {
        $this->leaveTypeService = $leaveTypeService;
    }
    
    public function getJavaScripts() {
        $javaScripts = parent::getJavaScripts();
        $javaScripts[] = plugin_web_path('orangehrmLeavePlugin', 'js/defineLeaveTypeSuccess.js');
        
        return $javaScripts;
    }
    
    public function getStylesheets() {
        $styleSheets = parent::getStylesheets();        
        return $styleSheets;        
    }
    
    public function getActionButtons() {

        $actionButtons = array();
        
        $actionButtons['saveButton'] = new ohrmWidgetButton('saveButton', "Save", array());
        $actionButtons['backButton'] = new ohrmWidgetButton('backButton', "Cancel", array('class' => 'cancel'));

        return $actionButtons;
    }    
}

