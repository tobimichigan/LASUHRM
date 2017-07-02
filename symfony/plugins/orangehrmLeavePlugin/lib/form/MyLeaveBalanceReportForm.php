<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Description of MyLeaveBalanceReportForm
 */
class MyLeaveBalanceReportForm extends LeaveBalanceReportForm {
    
    
    public function configure() {
        parent::configure();
        
        unset($this['report_type']);
        unset($this['employee']);
        unset($this['leave_type']);
        unset($this['job_title']);
        unset($this['location']);
        unset($this['sub_unit']);
        unset($this['include_terminated']);        
    }
    
    public function getValue($field) {
        if ($field == 'report_type') {
            return LeaveBalanceReportForm::REPORT_TYPE_EMPLOYEE;
        } 
        
        return parent::getValue($field);
    }
    
    public function getValues() {
        $values = parent::getValues();
        
        $empNumber = $this->getOption('empNumber');
        $employee = array('empId' => $empNumber);
                
        $values['employee'] = $employee;
        return $values;
    }

}
