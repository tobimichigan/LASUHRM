<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Leave Entitlement add form
 */
class LeaveEntitlementAddForm extends LeaveEntitlementForm {
    protected $bulkAssignForm;
    
    public function configure() {
        $this->bulkAssignForm = new LeaveEntitlementBulkAssignFilterForm();    

        $this->embedForm('filters', $this->bulkAssignForm, '<ol id="filter">%content%</ol>');    
        
        parent::configure();
        $this->setWidget('id', new sfWidgetFormInputHidden());
        $this->setValidator('id', new sfValidatorNumber(array('required' => false, 'min' => 1)));                
        
        $this->addFilterWidgets();
    

        $this->setWidget('entitlement', new sfWidgetFormInputText());
        $this->setValidator('entitlement', new sfValidatorNumber(array('required' => true)));
        
        $this->getWidgetSchema()->setLabels($this->getFormLabels());

        $this->widgetSchema->setLabel('filters', '&nbsp;');        
    
    }    
    
    /**
     *
     * @return array
     */
    protected function getFormLabels() {
        
         $requiredMarker = ' <em>*</em>';

        $labels = array(
            'employee' => __('Employee').$requiredMarker,
            'leave_type' => __('Leave Type').$requiredMarker
            
            
        );
        if( LeavePeriodService::getLeavePeriodStatus() == LeavePeriodService::LEAVE_PERIOD_STATUS_FORCED){
             $labels['date'] = __('Leave Period').$requiredMarker;
        }else{
            $labels['date'] = __('Earned Between').$requiredMarker;
        }
        $labels['entitlement'] = __('Entitlement').$requiredMarker;
        return $labels;
    }
    
    public function setEditMode() {
        $this->getWidget('leave_type')->setAttribute('disabled', 'disabled');
        $this->getWidget('employee')->setAttribute('disabled', 'disabled');
        $this->setValidator('employee', new sfValidatorPass());
        $this->setValidator('leave_type', new sfValidatorPass());           
    }
    
    public function addFilterWidgets() {
        
    }
    
    public function getJavaScripts() {
        $javaScripts = parent::getJavaScripts();
        $javaScripts[] = plugin_web_path('orangehrmLeavePlugin', 'js/addLeaveEntitlementSuccess.js');
        

        return $javaScripts;
    }    
}
