<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

class deleteEmploymentStatusAction extends sfAction {
	
	public function getEmploymentStatusService() {
		if (is_null($this->empStatusService)) {
			$this->empStatusService = new EmploymentStatusService();
			$this->empStatusService->setEmploymentStatusDao(new EmploymentStatusDao());
		}
		return $this->empStatusService;
	}
	
	public function execute($request) {
                $form = new DefaultListForm(array(), array(), true);
                $form->bind($request->getParameter($form->getName()));
		$toBeDeletedStausIds = $request->getParameter('chkSelectRow');

		if (!empty($toBeDeletedStausIds)) {

			foreach ($toBeDeletedStausIds as $toBeDeletedStausId) {
                            if ($form->isValid()) {
				$status = $this->getEmploymentStatusService()->getEmploymentStatusById($toBeDeletedStausId);
				$status->delete();
                                $this->getUser()->setFlash('success', __(TopLevelMessages::DELETE_SUCCESS));
                            }
			}			
		}

		$this->redirect('admin/employmentStatus');
	}
}

?>
