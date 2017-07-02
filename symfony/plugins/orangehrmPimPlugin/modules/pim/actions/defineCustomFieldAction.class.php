<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * defineCustomFieldAction action
 */
class defineCustomFieldAction extends sfAction {

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
     * Delete custom fields
     * @param $request
     * @return unknown_type
     */
    public function execute($request) {
        $admin = $this->getUser()->hasCredential(Auth::ADMIN_ROLE);
        
        if (!$admin) {
            $this->forward("auth", "unauthorized");
            return;
        } 
        
        $form = new CustomFieldForm(array(), array(), true);
        $customFieldsService = $this->getCustomFieldService();
        
        if ($request->isMethod('post')) {

            $form->bind($request->getParameter($form->getName()));
            if ($form->isValid()) {
                
                $fieldNum = $form->getValue('field_num');
                $customField = null;
                
                if (isset($fieldNum)) {
                    $customField = $customFieldsService->getCustomField($fieldNum);
                }
                
                if (empty($customField)) {
                    $customField = new CustomField();
                }
                
                $customField->setName($form->getValue('name'));
                $customField->setType($form->getValue('type'));
                $customField->setScreen($form->getValue('screen'));
                $customField->setExtraData($form->getValue('extra_data'));
                $customFieldsService->saveCustomField($customField);
                $this->getUser()->setFlash('success', __(TopLevelMessages::SAVE_SUCCESS));

            }
        }
        $this->redirect('pim/listCustomFields');        
    }

}