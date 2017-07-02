<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Description of getFilteredEmployeeCountAjaxAction
 */
class getEmployeeEntitlementAjaxAction  extends sfAction {
    
    
    protected $entitlementService ;
    
    
    
    public function getEntitlementService() { 
        if (empty($this->entitlementService)) {
            $this->entitlementService = new LeaveEntitlementService();
        }
        return $this->entitlementService;
    }

    public function setEntitlementService($entitlementService) {
        $this->entitlementService = $entitlementService;
    }
    
    protected function getEmployeeEntitlement($parameters) {

        
            
            $leaveEntitlementSearchParameterHolder = new LeaveEntitlementSearchParameterHolder();
            $leaveEntitlementSearchParameterHolder->setEmpNumber($parameters['empId']);
            $leaveEntitlementSearchParameterHolder->setFromDate($parameters['fd']);
            $leaveEntitlementSearchParameterHolder->setLeaveTypeId($parameters['lt']);
            $leaveEntitlementSearchParameterHolder->setToDate($parameters['td']);
            
            
            $entitlementList = $this->getEntitlementService()->searchLeaveEntitlements( $leaveEntitlementSearchParameterHolder );
            $oldValue = 0;
            $newValue = $parameters['ent'];
            if(count($entitlementList) > 0){
                $existingLeaveEntitlement = $entitlementList->getFirst();
                $oldValue = $existingLeaveEntitlement->getNoOfDays();
                
            } 
            
            return array($oldValue, $newValue+$oldValue);
        
    }
    
    public function execute($request) {
        sfConfig::set('sf_web_debug', false);
        sfConfig::set('sf_debug', false);
        
        $employees = $this->getEmployeeEntitlement($request->getGetParameters());


        $response = $this->getResponse();
        $response->setHttpHeader('Expires', '0');
        $response->setHttpHeader("Cache-Control", "must-revalidate, post-check=0, pre-check=0");
        $response->setHttpHeader("Cache-Control", "private", false);

        
         return $this->renderText(json_encode($employees))  ;
          
    }
}
