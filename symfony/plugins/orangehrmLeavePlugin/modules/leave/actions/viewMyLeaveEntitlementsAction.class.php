<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Description of viewMyLeaveEntitlements
 */
class viewMyLeaveEntitlementsAction extends viewLeaveEntitlementsAction {
    
    const FILTERS_ATTRIBUTE_NAME = 'myentitlementlist.filters';
    
    public function execute($request) {
        parent::execute($request);
        $this->setTemplate('viewLeaveEntitlements');
    }
    
    public function getForm() {
        $options = array('empNumber' => $this->getUser()->getAttribute('auth.empNumber'));
        return new MyLeaveEntitlementForm(array(), $options);
    }
    
    protected function showResultTableByDefault() {
        return true;
    }    
    
    protected function getTitle() {
        return 'My Leave Entitlements';
    }    
    
    protected function getDataGroupPermissions() {
        return $this->getContext()->getUserRoleManager()->getDataGroupPermissions(array('leave_entitlements'), array(), array(), true);
    }
    
    protected function getDefaultFilters() {
        $filters = $this->form->getDefaults();
        
        // Form defaults are in the user date format, convert to standard date format
        $pattern = sfContext::getInstance()->getUser()->getDateFormat();        
        $localizationService = new LocalizationService();
        
        $filters['date']['from'] = $localizationService->convertPHPFormatDateToISOFormatDate($pattern, $filters['date']['from']);
        $filters['date']['to'] = $localizationService->convertPHPFormatDateToISOFormatDate($pattern, $filters['date']['to']);          
        
        $employee = array('empId' => $this->getUser()->getAttribute('auth.empNumber'));
        $filters['employee'] = $employee;
        
        return $filters;
    }    
    
    /**
     * Save search filters as user attribute
     * @param array $filters
     */
    protected function saveFilters(array $filters) {
        $this->getUser()->setAttribute(self::FILTERS_ATTRIBUTE_NAME, $filters, 'leave');
    }    
    
    /**
     * Get search filters from user attribute
     * @param array $filters
     * @return array
     */
    protected function getFilters() {
        return $this->getUser()->getAttribute(self::FILTERS_ATTRIBUTE_NAME, null, 'leave');
    }      

}
