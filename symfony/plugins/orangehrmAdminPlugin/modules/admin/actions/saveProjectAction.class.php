<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class saveProjectAction extends sfAction {

    private $projectService;
    private $customerService;

    public function getCustomerService() {
        if (is_null($this->customerService)) {
            $this->customerService = new CustomerService();
            $this->customerService->setCustomerDao(new CustomerDao());
        }
        return $this->customerService;
    }

    public function getProjectService() {
        if (is_null($this->projectService)) {
            $this->projectService = new ProjectService();
            $this->projectService->setProjectDao(new ProjectDao());
        }
        return $this->projectService;
    }

    /**
     * @param sfForm $form
     * @return
     */
    public function setForm(sfForm $form) {
        if (is_null($this->form)) {
            $this->form = $form;
        }
    }

    protected function getUndeleteForm($projectId = '') {
        return new UndeleteCustomerForm(array(), array('fromAction' => 'saveProject','projectId' => $projectId), true);
    }
        
    public function execute($request) {

        /* For highlighting corresponding menu item */
        $request->setParameter('initialActionName', 'viewProjects');
        
        $usrObj = $this->getUser()->getAttribute('user');
        if (!($usrObj->isAdmin() || $usrObj->isProjectAdmin())) {
            $this->redirect('pim/viewPersonalDetails');
        }
        $this->isProjectAdmin = false;
        if ($usrObj->isProjectAdmin()) {
            $this->isProjectAdmin = true;
        }
        $this->projectId = $request->getParameter('projectId');
        $this->custId = $request->getParameter('custId');

        $values = array('projectId' => $this->projectId);
        $this->setForm(new ProjectForm(array(), $values));
        $this->customerForm = new CustomerForm();

        if ($this->custId > 0) {
            $customer = $this->getCustomerService()->getCustomerById($this->custId);
            $customerName = $customer->getName();
            $this->form->setDefault('customerName', $customerName);
            print_r($this->customerName);
            $this->getUser()->setFlash('success', __(TopLevelMessages::SAVE_SUCCESS));
        }

        if (!empty($this->projectId)) {
            $this->activityForm = new AddProjectActivityForm();
            $this->copyActForm = new CopyActivityForm();
            //For list activities
            $this->activityList = $this->getProjectService()->getActivityListByProjectId($this->projectId);
            $this->_setListComponent($this->activityList);
            $params = array();
            $this->parmetersForListCompoment = $params;
        }

        if ($request->isMethod('post')) {

            $this->form->bind($request->getParameter($this->form->getName()));
            if ($this->form->isValid()) {

                $projectId = $this->form->save();
                if ($this->form->edited) {
					$this->getUser()->setFlash('project.success', __(TopLevelMessages::UPDATE_SUCCESS));
                } else {
					$this->getUser()->setFlash('project.success', __(TopLevelMessages::SAVE_SUCCESS));
                }
                $this->redirect('admin/saveProject?projectId=' . $projectId);
            }
        } else {
            $this->undeleteForm = $this->getUndeleteForm($this->projectId);
        }
    }

    /**
     *
     * @param <type> $customerList
     * @param <type> $noOfRecords
     * @param <type> $pageNumber
     */
    private function _setListComponent($customerList) {

        $configurationFactory = new ProjectActivityHeaderFactory();
        ohrmListComponent::setConfigurationFactory($configurationFactory);
        ohrmListComponent::setListData($customerList);
    }

}

