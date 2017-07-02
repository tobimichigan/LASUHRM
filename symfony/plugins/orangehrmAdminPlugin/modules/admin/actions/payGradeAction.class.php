<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

class payGradeAction extends sfAction {
	
	/**
	 * @param sfForm $form
	 * @return
	 */
	public function setForm(sfForm $form) {
		if (is_null($this->form)) {
			$this->form = $form;
		}
	}
	
	public function getPayGradeService() {
		if (is_null($this->payGradeService)) {
			$this->payGradeService = new PayGradeService();
			$this->payGradeService->setPayGradeDao(new PayGradeDao());
		}
		return $this->payGradeService;
	}
	
	public function execute($request) {
        
        /* For highlighting corresponding menu item */
        $request->setParameter('initialActionName', 'viewPayGrades');

		$usrObj = $this->getUser()->getAttribute('user');
		if (!$usrObj->isAdmin()) {
			$this->redirect('pim/viewPersonalDetails');
		}
		$this->payGradeId = $request->getParameter('payGradeId');
		if(!empty($this->payGradeId)){
			$this->currencyForm = new PayGradeCurrencyForm();
			$this->deleteForm = new DeletePayGradeCurrenciesForm();
			$this->currencyList = $this->getPayGradeService()->getCurrencyListByPayGradeId($this->payGradeId);
		}		
		$values = array('payGradeId' => $this->payGradeId);
		$this->setForm(new PayGradeForm(array(), $values));
		
		if ($this->getUser()->hasFlash('templateMessage')) {
			list($this->messageType, $this->message) = $this->getUser()->getFlash('templateMessage');
		}
		
		if ($request->isMethod('post')) {

			$this->form->bind($request->getParameter($this->form->getName()));
			if ($this->form->isValid()) {
				$payGradeId = $this->form->save();
				$this->getUser()->setFlash('paygrade.success', __(TopLevelMessages::SAVE_SUCCESS));
				$this->redirect('admin/payGrade?payGradeId='.$payGradeId);
			}
		}
	}
	
}

?>
