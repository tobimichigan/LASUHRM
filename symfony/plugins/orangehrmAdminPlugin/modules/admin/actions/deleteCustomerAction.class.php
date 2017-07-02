<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

class deleteCustomerAction extends sfAction {

	public function getCustomerService() {
		if (is_null($this->customerService)) {
			$this->customerService = new CustomerService();
			$this->customerService->setCustomerDao(new CustomerDao());
		}
		return $this->customerService;
	}

	/**
	 *
	 * @param <type> $request
	 */
	public function execute($request) {
                $form = new DefaultListForm(array(), array(), true);
                $form->bind($request->getParameter($form->getName()));
		$toBeDeletedCustomerIds = $request->getParameter('chkSelectRow');

		if (!empty($toBeDeletedCustomerIds)) {
			$delete = true;
			foreach ($toBeDeletedCustomerIds as $toBeDeletedCustomerId) {
				$deletable = $this->getCustomerService()->hasCustomerGotTimesheetItems($toBeDeletedCustomerId);
				if ($deletable) {
					$delete = false;
					break;
				}
			}
			if ($delete) {
				foreach ($toBeDeletedCustomerIds as $toBeDeletedCustomerId) {
                                    if ($form->isValid()) {
					$customer = $this->getCustomerService()->deleteCustomer($toBeDeletedCustomerId);
                                        $this->getUser()->setFlash('success', __(TopLevelMessages::DELETE_SUCCESS));
                                    }
				}
				
			} else {
				$this->getUser()->setFlash('error', __('Not Allowed to Delete Customer(s) Which Have Time Logged Against'));
			}
		}

		$this->redirect('admin/viewCustomers');
	}

}

?>
