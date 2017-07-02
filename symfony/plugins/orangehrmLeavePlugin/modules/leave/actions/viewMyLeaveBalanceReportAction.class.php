<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Description of viewMyLeaveBalanceReportAction
 */
class viewMyLeaveBalanceReportAction extends viewLeaveBalanceReportAction {
    
    public function getForm() {
        $options = array('empNumber' => $this->getUser()->getAttribute('auth.empNumber'));
        return new MyLeaveBalanceReportForm(array(), $options);        
    }
    
    protected function getFormDefaults() {
        $defaults = parent::getFormDefaults();
        
        $defaults['employee'] = array('empId' => $this->getUser()->getAttribute('auth.empNumber'));
                
        return $defaults;
    }
    
    public function getMode() {
        return "my";
    }
        
    public function execute($request) {

        parent::execute($request);
        $this->setTemplate('viewLeaveBalanceReport');
    }
    
    protected function getDataGroupPermissions() {
        return $this->getContext()->getUserRoleManager()->getDataGroupPermissions(array('leave_entitlements_usage_report'), array(), array(), true);
    }    
}
