<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class deletePayGradeCurrencyAction extends sfAction {

	private $payGradeService;


	public function getPayGradeService() {
		if (is_null($this->payGradeService)) {
			$this->payGradeService = new PayGradeService();
			$this->payGradeService->setPayGradeDao(new PayGradeDao());
		}
		return $this->payGradeService;
	}
	
	/**
	 *
	 * @param <type> $request 
	 */
	public function execute($request) {

		$payGradeId = $request->getParameter('payGradeId');
		$this->form = new DeletePayGradeCurrenciesForm();

		$this->form->bind($request->getParameter($this->form->getName()));
		if ($this->form->isValid()) {
			$currenciesToDelete = $request->getParameter('delCurrencies', array());
			if ($currenciesToDelete) {
				for ($i = 0; $i < sizeof($currenciesToDelete); $i++) {
					$currency = $this->getPayGradeService()->getCurrencyByCurrencyIdAndPayGradeId($currenciesToDelete[$i], $payGradeId);
					$currency->delete();
				}				
			}

            $this->getUser()->setFlash('success', __(TopLevelMessages::DELETE_SUCCESS));
			
		}

		$this->redirect('admin/payGrade?payGradeId='.$payGradeId . '#Currencies');
	}

}

?>
