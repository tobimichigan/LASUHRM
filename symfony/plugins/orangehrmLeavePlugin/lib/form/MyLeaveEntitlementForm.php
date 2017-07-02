<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Leave Entitlement form for my entitlements
 */
class MyLeaveEntitlementForm extends LeaveEntitlementSearchForm {
    public function configure() {
        parent::configure();
        
        /* 
         * Replace employee auto complete with an hidden field with logged in emp number
         */
        unset($this['employee']);
        $empNumber = $this->getOption('empNumber');
        $this->setWidget('empNumber', new sfWidgetFormInputHidden(array(), array('value' => $empNumber)));
        $this->setValidator('empNumber', new sfValidatorChoice(array('choices' => array($empNumber), 'required' => true)));    

        $this->validatorSchema->setPostValidator(
          new sfValidatorCallback(array(
            'callback' => array($this, 'postValidate')
          ))
        );        
    }

    public function postValidate($validator, $values) {

        /* Format empnumber correctly for use by super class */
        $employee = array('empId' => $values['empNumber']);
        $values['employee'] = $employee;
        unset($values['empNumber']);
        
        return $values;
    }
    
}
