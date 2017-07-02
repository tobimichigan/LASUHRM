<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * listCustomFields action
 */
class listCustomFieldsAction extends sfAction {

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
     * List Custom fields
     * @param sfWebRequest $request
     * @return void
     */
    public function execute($request) {

        $admin = $this->getUser()->hasCredential(Auth::ADMIN_ROLE);
        
        if (!$admin) {
            $this->forward("auth", "unauthorized");
        } else {        
            if ($this->getUser()->hasFlash('templateMessage')) {
                list($this->messageType, $this->message) = $this->getUser()->getFlash('templateMessage');
            } else if ($request->hasParameter('message')) {
                $message = $request->getParameter('message');
                
                if ($message == 'UPDATE_SUCCESS') {
                    $this->messageType = 'success';
                    $this->message = __(TopLevelMessages::UPDATE_SUCCESS);
                }
            }
            
            $this->form = new CustomFieldForm(array(), array(), true);
            $this->deleteForm = new CustomFieldDeleteForm(array(), array(), true);
            $customFieldsService = $this->getCustomFieldService();
            $this->sorter = new ListSorter('propoerty.sort', 'admin_module', $this->getUser(), array('field_num', ListSorter::ASCENDING));

            $sortBy = 'name';
            $sortOrder = 'ASC';
            
            if ($request->getParameter('sort')) {
                $sortBy = $request->getParameter('sort');
                $sortOrder = $request->getParameter('order');
                $this->sortField = $sortBy;
                $this->sortOrder = $sortOrder;
            }
            $this->sorter->setSort(array($sortBy, $sortOrder));
            $this->listCustomField = $customFieldsService->getCustomFieldList(null, $sortBy, $sortOrder);            
        }
    }

}