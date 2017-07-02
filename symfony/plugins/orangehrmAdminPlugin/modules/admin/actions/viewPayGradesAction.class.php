<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class viewPayGradesAction extends sfAction {

	private $payGradeService;

	public function getPayGradeService() {
		if (is_null($this->payGradeService)) {
			$this->payGradeService = new PayGradeService();
			$this->payGradeService->setPayGradeDao(new PayGradeDao());
		}
		return $this->payGradeService;
	}

	public function execute($request) {

		$usrObj = $this->getUser()->getAttribute('user');
		if (!($usrObj->isAdmin())) {
			$this->redirect('pim/viewPersonalDetails');
		}

		$sortField = $request->getParameter('sortField');
		$sortOrder = $request->getParameter('sortOrder');

		$payGradeList = $this->getPayGradeService()->getPayGradeList($sortField, $sortOrder);
		$this->_setListComponent($payGradeList);
		$params = array();
		$this->parmetersForListCompoment = $params;
	}

	private function _setListComponent($payGradeList) {

		$configurationFactory = new PayGradeHeaderFactory();
		ohrmListComponent::setConfigurationFactory($configurationFactory);
		ohrmListComponent::setListData($payGradeList);
	}

}

?>
