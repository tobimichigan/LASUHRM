<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class viewCustomersAction extends sfAction {

	private $customerService;

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

		$usrObj = $this->getUser()->getAttribute('user');
		if (!$usrObj->isAdmin()) {
			$this->redirect('pim/viewPersonalDetails');
		}
		$customerId = $request->getParameter('customerId');

		$isPaging = $request->getParameter('pageNo');
		$sortField = $request->getParameter('sortField');
		$sortOrder = $request->getParameter('sortOrder');

		$pageNumber = $isPaging;
		if ($customerId > 0 && $this->getUser()->hasAttribute('pageNumber')) {
			$pageNumber = $this->getUser()->getAttribute('pageNumber');
		}
		if ($this->getUser()->getAttribute('addScreen') && $this->getUser()->hasAttribute('pageNumber')) {
			$pageNumber = $this->getUser()->getAttribute('pageNumber');
		}

		$noOfRecords = Customer::NO_OF_RECORDS_PER_PAGE;
		$offset = ($pageNumber >= 1) ? (($pageNumber - 1) * $noOfRecords) : ($request->getParameter('pageNo', 1) - 1) * $noOfRecords;
		$customerList = $this->getCustomerService()->getCustomerList($noOfRecords, $offset, $sortField, $sortOrder);
		$this->_setListComponent($customerList, $noOfRecords, $pageNumber);
		$this->getUser()->setAttribute('pageNumber', $pageNumber);
		$params = array();
		$this->parmetersForListCompoment = $params;
        
	}

	/**
	 *
	 * @param <type> $customerList
	 * @param <type> $noOfRecords
	 * @param <type> $pageNumber
	 */
	private function _setListComponent($customerList, $noOfRecords, $pageNumber) {

		$configurationFactory = new CustomerHeaderFactory();
		ohrmListComponent::setPageNumber($pageNumber);
		ohrmListComponent::setConfigurationFactory($configurationFactory);
		ohrmListComponent::setListData($customerList);
		ohrmListComponent::setItemsPerPage($noOfRecords);
		ohrmListComponent::setNumberOfRecords($this->getCustomerService()->getCustomerCount());
	}

}

