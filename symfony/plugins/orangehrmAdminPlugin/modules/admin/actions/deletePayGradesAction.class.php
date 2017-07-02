<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class deletePayGradesAction extends sfAction {
	
	private $payGradeService;


	public function getPayGradeService() {
		if (is_null($this->payGradeService)) {
			$this->payGradeService = new PayGradeService();
			$this->payGradeService->setPayGradeDao(new PayGradeDao());
		}
		return $this->payGradeService;
	}
	
	public function execute($request) {
                $form = new DefaultListForm(array(), array(), true);
                $form->bind($request->getParameter($form->getName()));
		$toBeDeletedPayGradeIds = $request->getParameter('chkSelectRow');

		if (!empty($toBeDeletedPayGradeIds)) {

			foreach ($toBeDeletedPayGradeIds as $toBeDeletedPayGradeId) {
                            if ($form->isValid()) {
				$payGrade = $this->getPayGradeService()->getPayGradeById($toBeDeletedPayGradeId);
				$payGrade->delete();
                                $this->getUser()->setFlash('success', __(TopLevelMessages::DELETE_SUCCESS));
                            }
			}			
		}

		$this->redirect('admin/viewPayGrades');
	}
}

?>
