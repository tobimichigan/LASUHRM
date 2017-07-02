<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

class deleteSkillsAction extends sfAction {
    
    private $skillService;
    
    public function getSkillService() {
        
        if (!($this->skillService instanceof SkillService)) {
            $this->skillService = new SkillService();
        }        
        
        return $this->skillService;
    }

    public function setSkillService($skillService) {
        $this->skillService = $skillService;
    }
    
    public function execute($request) {
        
        $this->_checkAuthentication();
        
        $toDeleteIds = $request->getParameter('chkListRecord');
        
        if (!empty($toDeleteIds) && $request->isMethod('post')) {
            $form = new DefaultListForm(array(), array(), true);
            $form->bind($request->getParameter($form->getName()));
            if ($form->isValid()) {
                $result = $this->getSkillService()->deleteSkills($toDeleteIds);
            }
            if ($result) {
                $this->getUser()->setFlash('success', __(TopLevelMessages::DELETE_SUCCESS)); 
            }            
            $this->redirect('admin/viewSkills');
        }       
        
    }
    
    protected function _checkAuthentication() {
        
        $user = $this->getUser()->getAttribute('user');
        
		if (!$user->isAdmin()) {
			$this->redirect('pim/viewPersonalDetails');
		}
        
    }  
    
}
