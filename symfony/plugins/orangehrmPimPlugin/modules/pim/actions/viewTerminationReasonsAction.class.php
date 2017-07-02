<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

class viewTerminationReasonsAction extends sfAction {
    
    private $terminationReasonConfigurationService;
    
    public function getTerminationReasonConfigurationService() {
        
        if (!($this->terminationReasonConfigurationService instanceof TerminationReasonConfigurationService)) {
            $this->terminationReasonConfigurationService = new TerminationReasonConfigurationService();
        }        
        
        return $this->terminationReasonConfigurationService;
    }

    public function setTerminationReasonConfigurationService($terminationReasonConfigurationService) {
        $this->terminationReasonConfigurationService = $terminationReasonConfigurationService;
    }
    
    public function execute($request) {
        
        $this->_checkAuthentication();
        
        $this->form = new TerminationReasonForm();
        $this->records = $this->getTerminationReasonConfigurationService()->getTerminationReasonList();
        
        if ($request->isMethod('post')) {
            
			$this->form->bind($request->getParameter($this->form->getName()));
            
			if ($this->form->isValid()) {

                $this->_checkDuplicateEntry();
                
				$templateMessage = $this->form->save();
				$this->getUser()->setFlash($templateMessage['messageType'], $templateMessage['message']);                
                $this->redirect('pim/viewTerminationReasons');
                
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
        $object = $this->getTerminationReasonConfigurationService()->getTerminationReasonByName($this->form->getValue('name'));
        
        if ($object instanceof TerminationReason) {
            
            if (!empty($id) && $id == $object->getId()) {
                return false;
            }
            
            $this->getUser()->setFlash('warning', __('Name Already Exists'));
            $this->redirect('pim/viewTerminationReasons');            
            
        }
        
        return false;

    }    
    
}
