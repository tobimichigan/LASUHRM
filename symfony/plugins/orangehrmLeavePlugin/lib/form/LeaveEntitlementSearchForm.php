<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Description of LeaveEntitlementSearchForm
 *
 */
class LeaveEntitlementSearchForm extends LeaveEntitlementForm {
    
    public function configure() {
        parent::configure();
        $leaveTypeWidget = $this->getWidget('leave_type');
        
        $choices = $leaveTypeWidget->getOption('choices');
        if (!isset($choices[''])) {
            $choices = array('' => 'All') + $choices; 
            $leaveTypeWidget->setOption('choices', $choices);
            $this->setDefault('leave_type', '');
            
            $this->setValidator('leave_type', new sfValidatorChoice(array('choices' => array_keys($choices), 'required' => false)));
        }        
    }    
}

