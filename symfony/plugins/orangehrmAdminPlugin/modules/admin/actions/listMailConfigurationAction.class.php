<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class listMailConfigurationAction extends sfAction {
    
    public function setForm(sfForm $form) {
        if (is_null($this->form)) {
            $this->form = $form;
        }
    }

    public function execute($request) {
        
        $this->_checkAuthentication();
        
        $this->setForm(new EmailConfigurationForm());
        
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter($this->form->getName()));      
            if ($this->form->isValid()) {
                $this->form->save();
                
                if ($this->form->getValue('chkSendTestEmail') == 'on') {
                    $emailService = new EmailService();
                    $result = $emailService->sendTestEmail($this->form->getValue('txtTestEmail'));
                    if ($result) {
                        $this->getUser()->setFlash('success', __('Successfully Saved. Test Email Sent'));
                    } else {
                        $this->getUser()->setFlash('warning', __("Successfully Saved. Test Email Not Sent"));
                    }
                } else {
                    $this->getUser()->setFlash('success', __(TopLevelMessages::SAVE_SUCCESS));
                }
                $this->redirect('admin/listMailConfiguration');
            }
        }
    }
    
    protected function _checkAuthentication() {
        
        $user = $this->getUser()->getAttribute('user');
        
		if (!$user->isAdmin()) {
			$this->redirect('auth/login');
		}
        
    }    

}