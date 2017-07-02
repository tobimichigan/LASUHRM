<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class addCustomerAction extends sfAction {

    /**
     * @param sfForm $form
     * @return
     */
    public function setForm(sfForm $form) {
        if (is_null($this->form)) {
            $this->form = $form;
        }
    }

    protected function getUndeleteForm() {
        return new UndeleteCustomerForm(array(), array('fromAction' => 'addCustomer', 'projectId' => ''), true);
    }

    public function execute($request) {

        /* For highlighting corresponding menu item */
        $request->setParameter('initialActionName', 'viewCustomers');
            
		$usrObj = $this->getUser()->getAttribute('user');
		if (!$usrObj->isAdmin()) {
			$this->redirect('pim/viewPersonalDetails');
		}
        
        $this->customerId = $request->getParameter('customerId');
		$values = array('customerId' => $this->customerId);
		$this->setForm(new CustomerForm(array(), $values));
		
		$this->getUser()->setAttribute('addScreen', true);

        if ($request->isMethod('post')) {

            $this->form->bind($request->getParameter($this->form->getName()));
            if ($this->form->isValid()) {
                $result = $this->form->save();
                $this->getUser()->setAttribute('addScreen', false);
				$this->getUser()->setFlash($result['messageType'], $result['message']);
                $this->redirect('admin/viewCustomers');
            }
        } else {

            $this->undeleteForm = $this->getUndeleteForm();
            $customerId = $request->getParameter('customerId'); // This comes as a GET request from Customer List page

            if (!empty($customerId)) {
                $this->form->setUpdateMode();
            }
        }

    }

}