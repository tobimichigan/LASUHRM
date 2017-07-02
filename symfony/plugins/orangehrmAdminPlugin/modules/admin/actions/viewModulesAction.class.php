<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

class viewModulesAction extends sfAction {
    
    private $moduleService;
    
    public function getModuleService() {
        
        if (!($this->moduleService instanceof ModuleService)) {
            $this->moduleService = new ModuleService();
        }        
        
        return $this->moduleService;
    }

    public function setModuleService($moduleService) {
        $this->moduleService = $moduleService;
    }
    
    public function execute($request) {
        
        $this->_checkAuthentication();

        $this->form = new ModuleForm();
        
        if ($request->isMethod('post')) {
            
			$this->form->bind($request->getParameter($this->form->getName()));

			if ($this->form->isValid()) {
                
                $this->_resetModulesSavedInSession();                
				$result = $this->form->save();
				$this->getUser()->setFlash($result['messageType'], $result['message']);       
                $this->redirect('admin/viewModules');
                
            }
            
        }
        
    }
    
    protected function _checkAuthentication() {
        
        $user = $this->getUser()->getAttribute('user');
        
		if (!$user->isAdmin()) {
			$this->redirect('pim/viewPersonalDetails');
		}
        
    }
    
    protected function _resetModulesSavedInSession() {
        
        $this->getUser()->getAttributeHolder()->remove('admin.disabledModules'); 
        $this->getUser()->getAttributeHolder()->remove(mainMenuComponent::MAIN_MENU_USER_ATTRIBUTE);
        
    }    
    
}
