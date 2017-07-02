<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Actions class for PIM module updateDependentAction
 */

class updateCustomFieldsAction extends basePimAction {

    /**
     * Add / update employee customFields
     *
     * @param int $empNumber Employee number
     *
     * @return boolean true if successfully assigned, false otherwise
     */
    public function execute($request) {
        
        // this should probably be kept in session?
        $screen = $request->getParameter('screen');

        $customFieldsService = new CustomFieldConfigurationService();
        $customFieldList = $customFieldsService->getCustomFieldList($screen);

        $this->form = new EmployeeCustomFieldsForm(array(), array('customFields'=>$customFieldList), true);

        if ($this->getRequest()->isMethod('post')) {


            // Handle the form submission
            $this->form->bind($request->getPostParameters());

            if ($this->form->isValid()) {

                $empNumber = $this->form->getValue('EmpID');
                if (!$this->IsActionAccessible($empNumber)) {
                    $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
                }

                $this->form->save();
                $this->getUser()->setFlash('customFieldsMessage', array('success', __(TopLevelMessages::UPDATE_SUCCESS)));                
            } else {
                $this->getUser()->setFlash('customFieldsMessage', array('warning', __('Failed to Save: Length Exceeded')));
            }
        }                    

                    
        $this->redirect($this->getRequest()->getReferer() . '#custom');
    }

}
