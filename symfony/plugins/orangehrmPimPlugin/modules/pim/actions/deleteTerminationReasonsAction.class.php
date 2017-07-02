<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

class deleteTerminationReasonsAction extends sfAction {
    
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
        
        $toDeleteIds = $request->getParameter('chkListRecord');
        
        $this->_checkReasonsInUse($toDeleteIds);
        
        if (!empty($toDeleteIds) && $request->isMethod('post')) {
            $form = new DefaultListForm(array(), array(), true);
            $form->bind($request->getParameter($form->getName()));
            if ($form->isValid()) {
                $result = $this->getTerminationReasonConfigurationService()->deleteTerminationReasons($toDeleteIds);
            }
            if ($result) {
                $this->getUser()->setFlash('success', __(TopLevelMessages::DELETE_SUCCESS)); 
            }            
            $this->redirect('pim/viewTerminationReasons');
        }       
        
    }
    
    protected function _checkAuthentication() {
        
        $user = $this->getUser()->getAttribute('user');
        
		if (!$user->isAdmin()) {
			$this->redirect('pim/viewPersonalDetails');
		}
        
    }  
    
    protected function _checkReasonsInUse($toDeleteIds) {
        
        if (!empty($toDeleteIds)) {
            
            if ($this->getTerminationReasonConfigurationService()->isReasonInUse($toDeleteIds)) {
                $this->getUser()->setFlash('warning', __('Termination Reason(s) in Use'));
                $this->redirect('pim/viewTerminationReasons');
            }
            
        }
        
    }
    
}
