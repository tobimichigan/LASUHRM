<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class undeleteCustomerAction extends orangehrmAction {

    protected $customerService;

    public function execute($request) {
        $this->form = $this->getForm();
        $fromAction = 'addCustomer';
        $undeleteId = '';
        $projectId = '';
        
        if ($request->isMethod('post')) {

            $this->form->bind($request->getParameter($this->form->getName()));

            if ($this->form->isValid()) {
                $undeleteId = $this->form->getValue('undeleteId');
                $fromAction = $this->form->getValue('fromAction');
                $projectId = $this->form->getValue('projectId');

                $this->undeleteCustomer($undeleteId);
            } else {
                // Since this form does not have any user data entry fields,
                // this is a error.
                $this->getLoggerInstance()->error($this->form);
            }
        }
        if ($fromAction == 'addCustomer') {
            $this->redirect("admin/viewCustomers");
        } else if ($fromAction == 'saveProject') {
//            $this->forward("admin", "saveProject");
            $this->redirect("admin/saveProject?custId=$undeleteId&projectId=$projectId");
        }
    }

    protected function undeleteCustomer($customerId) {
        $customerService = $this->getCustomerService();
        $customerService->undeleteCustomer($customerId);

        $message = __('Successfully Undeleted');
        $this->getUser()->setFlash('project.success', $message);
    }

    protected function getForm() {
        $form = new UndeleteCustomerForm(array(), array(), true);
        return $form;
    }

    protected function getCustomerService() {

        if (is_null($this->customerService)) {
            $this->customerService = new CustomerService();
        }

        return $this->customerService;
    }

    /**
     * Get Logger instance. Creates if not already created.
     *
     * @return Logger
     */
    protected function getLoggerInstance() {
        if (is_null($this->logger)) {
            $this->logger = Logger::getLogger('leave.undeleteCustomerAction');
        }

        return($this->logger);
    }

}