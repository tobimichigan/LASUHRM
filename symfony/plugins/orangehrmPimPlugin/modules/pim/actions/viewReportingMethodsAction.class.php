<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

class viewReportingMethodsAction extends sfAction {
    
    private $reportingMethodConfigurationService;
    
    public function getReportingMethodConfigurationService() {
        
        if (!($this->reportingMethodConfigurationService instanceof ReportingMethodConfigurationService)) {
            $this->reportingMethodConfigurationService = new ReportingMethodConfigurationService();
        }        
        
        return $this->reportingMethodConfigurationService;
    }

    public function setReportingMethodConfigurationService($reportingMethodConfigurationService) {
        $this->reportingMethodConfigurationService = $reportingMethodConfigurationService;
    }
    
    public function execute($request) {
        
        $this->_checkAuthentication();
        
        $this->form = new ReportingMethodForm();
        $this->records = $this->getReportingMethodConfigurationService()->getReportingMethodList();
        
        if ($request->isMethod('post')) {
            
			$this->form->bind($request->getParameter($this->form->getName()));
            
			if ($this->form->isValid()) {

                $this->_checkDuplicateEntry();
                
				$templateMessage = $this->form->save();
				$this->getUser()->setFlash($templateMessage['messageType'], $templateMessage['message']);                
                $this->redirect('pim/viewReportingMethods');
                
            }
            
        }
       $this->listForm = new DefaultListForm(array(), array(), true);  
    }
    
    protected function _checkAuthentication() {
        
        $user = $this->getUser()->getAttribute('user');
        
		if (!$user->isAdmin()) {
			$this->redirect('pim/viewPersonalDetails');
		}
        
    }
    
    protected function _checkDuplicateEntry() {

        $id = $this->form->getValue('id');
        $object = $this->getReportingMethodConfigurationService()->getReportingMethodByName($this->form->getValue('name'));
        
        if ($object instanceof ReportingMethod) {
            
            if (!empty($id) && $id == $object->getId()) {
                return false;
            }
            
            $this->getUser()->setFlash('warning', __('Name Already Exists'));
            $this->redirect('pim/viewReportingMethods');            
            
        }
        
        return false;

    }    
    
}
