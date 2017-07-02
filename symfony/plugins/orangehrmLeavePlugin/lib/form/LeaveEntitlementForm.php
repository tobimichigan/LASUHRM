<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Form class for leave entitlements screen
 *
 */
class LeaveEntitlementForm extends BaseForm {

    protected $leaveTypeService;
    
    protected $leavePeriodService;
    
    public function getLeaveTypeService() {
        if (!isset($this->leaveTypeService)) {
            $this->leaveTypeService = new LeaveTypeService();
        }
        return $this->leaveTypeService;
    }

    public function setLeaveTypeService(LeaveTypeService $leaveTypeService) {
        $this->leaveTypeService = $leaveTypeService;
    }

    public function getLeavePeriodService() {
        if (!isset($this->leavePeriodService)) {
            $this->leavePeriodService = new LeavePeriodService();
        }        
        return $this->leavePeriodService;
    }

    public function setLeavePeriodService($leavePeriodService) {
        $this->leavePeriodService = $leavePeriodService;
    }

    
    
    public function configure() {

        $this->setWidget('employee', new ohrmWidgetEmployeeNameAutoFill(array('loadingMethod'=>'ajax')));

        $this->setValidator('employee', new ohrmValidatorEmployeeNameAutoFill());

        $this->setLeaveTypeWidget();
        
        $inputDatePattern = sfContext::getInstance()->getUser()->getDateFormat();
        
        $this->setWidget('date', new ohrmWidgetFormLeavePeriod(array()));
        

        $this->setValidator('date', new sfValidatorDateRange(array(
            'from_date' => new ohrmDateValidator(array('required' => true)),
            'to_date' => new ohrmDateValidator(array('required' => true))
        )));
        
        //$this->setWidget('date_from', new ohrmWidgetDatePicker(array(), array('id' => 'date_from')));
        //$this->setValidator('date_from', new ohrmDateValidator(array('date_format' => $inputDatePattern, 'required' => true)));

        //$this->setWidget('date_to', new ohrmWidgetDatePicker(array(), array('id' => 'date_to')));
        //$this->setValidator('date_to', new ohrmDateValidator(array('date_format' => $inputDatePattern, 'required' => true)));
        
        $this->setDefaultDates();    
        
                
        $formExtension = PluginFormMergeManager::instance();
        $formExtension->mergeForms($this, 'viewLeaveEntitlements','LeaveEntitlementsForm');
  
        $this->widgetSchema->setNameFormat('entitlements[%s]');
        $this->getWidgetSchema()->setLabels($this->getFormLabels());

    }

    protected function setLeaveTypeWidget() {

        $choices = array();
        
        $leaveTypeList = $this->getLeaveTypeService()->getLeaveTypeList();
        $defaultLeaveTypeId = NULL;
        
        if (count($leaveTypeList) == 0) {
            $choices[''] = __('No leave types defined');
        } else {
            foreach ($leaveTypeList as $leaveType) {
                if (is_null($defaultLeaveTypeId)) {
                    $defaultLeaveTypeId = $leaveType->getId();
                }
                $choices[$leaveType->getId()] = $leaveType->getName();            
            }
        }

        $this->setWidget('leave_type', new sfWidgetFormChoice(array('choices' => $choices)));
        $this->setValidator('leave_type', new sfValidatorChoice(array('choices' => array_keys($choices))));
        
        if (!is_null($defaultLeaveTypeId)) {
            $this->setDefault('leave_type', $defaultLeaveTypeId);
        }        
        
    }

    /**
     *
     * @return array
     */
    protected function getFormLabels() {

        $labels = array(
            'employee' => __('Employee'),
            'leave_type' => __('Leave Type')
            
            
        );
        if( LeavePeriodService::getLeavePeriodStatus() == LeavePeriodService::LEAVE_PERIOD_STATUS_FORCED){
             $labels['date'] = __('Leave Period');
        }else{
            $labels['date'] = __('Earned Between');
        }
        return $labels;
    }
    
    protected function setDefaultDates() {
        $now = time();
        
        // If leave period defined, use leave period start and end date
        $leavePeriod = $this->getLeavePeriodService()->getCurrentLeavePeriodByDate(date('Y-m-d', $now));        
        if (!empty($leavePeriod)) {
            $fromDate   = $leavePeriod[0];
            $toDate     = $leavePeriod[1];
        } else {
            // else use this year as the period
            $year = date('Y', $now);
            $fromDate = $year . '-1-1';
            $toDate = $year . '-12-31';
        }        
        
        $this->setDefault('date', array(
            'from' => set_datepicker_date_format($fromDate),
            'to' => set_datepicker_date_format($toDate)));

    }
    
}

