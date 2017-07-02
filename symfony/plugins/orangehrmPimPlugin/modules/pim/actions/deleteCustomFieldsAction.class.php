<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * deleteCustomFieldsAction action
 */
class deleteCustomFieldsAction extends basePimAction {

    protected $customFieldService;

    /**
     * Get CustomFieldsService
     * @returns CustomFieldsService
     */
    public function getCustomFieldService() {
        if (is_null($this->customFieldService)) {
            $this->customFieldService = new CustomFieldConfigurationService();
            $this->customFieldService->setCustomFieldsDao(new CustomFieldConfigurationDao());
        }
        return $this->customFieldService;
    }

    /**
     * Set Country Service
     */
    public function setCustomFieldService(CustomFieldConfigurationService $customFieldsService) {
        $this->customFieldService = $customFieldsService;
    }

    /**
     * Delete Customer fields
     * @param sfWebRequest $request
     * @return unknown_type
     */
    public function execute($request) {
        
        $admin = $this->getUser()->hasCredential(Auth::ADMIN_ROLE);
        
        if (!$admin) {
            $this->forward("auth", "unauthorized");
        } else {
            $this->form = new CustomFieldDeleteForm(array(), array(), true);
            $this->form->bind($request->getParameter($this->form->getName()));
            if ($this->form->isValid()) {
                if (count($request->getParameter('chkLocID')) > 0) {
                    $customFieldsService = $this->getCustomFieldService();
                    $customFieldsService->deleteCustomFields($request->getParameter('chkLocID'));
                    $this->getUser()->setFlash('success', __(TopLevelMessages::DELETE_SUCCESS));
                } else {
                    $this->getUser()->setFlash('notice', __(TopLevelMessages::SELECT_RECORDS));
                }
            }
            $this->redirect('pim/listCustomFields');
        }
    }

}

