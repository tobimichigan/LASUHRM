<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class employmentStatusAction extends sfAction {

	private $empStatusService;

	public function getEmploymentStatusService() {
		if (is_null($this->empStatusService)) {
			$this->empStatusService = new EmploymentStatusService();
			$this->empStatusService->setEmploymentStatusDao(new EmploymentStatusDao());
		}
		return $this->empStatusService;
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

	public function execute($request) {

		$usrObj = $this->getUser()->getAttribute('user');
		if (!$usrObj->isAdmin()) {
			$this->redirect('pim/viewPersonalDetails');
		}
		
		$this->setForm(new EmploymentStatusForm());

		if ($this->getUser()->hasFlash('templateMessage')) {
			list($this->messageType, $this->message) = $this->getUser()->getFlash('templateMessage');
		}

		$statusList = $this->getEmploymentStatusService()->getEmploymentStatusList();
		$this->_setListComponent($statusList);
		$params = array();
		$this->parmetersForListCompoment = $params;

		if ($request->isMethod('post')) {
			$this->form->bind($request->getParameter($this->form->getName()));
			if ($this->form->isValid()) {
				$this->form->save();
				$this->getUser()->setFlash('success', __(TopLevelMessages::SAVE_SUCCESS));
				$this->redirect('admin/employmentStatus');
			}
		}
	}
	
	private function _setListComponent($statusList) {

		$configurationFactory = new EmploymentStatusHeaderFactory();
		ohrmListComponent::setConfigurationFactory($configurationFactory);
		ohrmListComponent::setListData($statusList);
	}
}
