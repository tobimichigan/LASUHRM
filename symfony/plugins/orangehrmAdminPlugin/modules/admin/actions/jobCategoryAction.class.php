<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

class jobCategoryAction extends sfAction {
	
	private $jobCatService;

	public function getJobCategoryService() {
		if (is_null($this->jobCatService)) {
			$this->jobCatService = new JobCategoryService();
			$this->jobCatService->setJobCategoryDao(new JobCategoryDao());
		}
		return $this->jobCatService;
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
		
		$this->setForm(new JobCategoryForm());
		
		$jobCatList = $this->getJobCategoryService()->getJobCategoryList();
		$this->_setListComponent($jobCatList);
		$params = array();
		$this->parmetersForListCompoment = $params;
		
		if ($request->isMethod('post')) {
			$this->form->bind($request->getParameter($this->form->getName()));
			if ($this->form->isValid()) {
				$this->form->save();
				$this->getUser()->setFlash('success', __(TopLevelMessages::SAVE_SUCCESS));
				$this->redirect('admin/jobCategory');
			}
		}
	}
	
	private function _setListComponent($jobCatList) {

		$configurationFactory = new JobCategoryHeaderFactory();
		ohrmListComponent::setConfigurationFactory($configurationFactory);
		ohrmListComponent::setListData($jobCatList);
	}
}


