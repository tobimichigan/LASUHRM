<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class deleteJobCategoryAction extends sfAction {
	
	private $jobCatService;

	public function getJobCategoryService() {
		if (is_null($this->jobCatService)) {
			$this->jobCatService = new JobCategoryService();
			$this->jobCatService->setJobCategoryDao(new JobCategoryDao());
		}
		return $this->jobCatService;
	}
	
	public function execute($request) {
                $form = new DefaultListForm(array(), array(), true);
                $form->bind($request->getParameter($form->getName()));
		$toBeDeletedJobCatIds = $request->getParameter('chkSelectRow');

		if (!empty($toBeDeletedJobCatIds)) {

			foreach ($toBeDeletedJobCatIds as $toBeDeletedJobCatId) {
                            if ($form->isValid()) {
				$status = $this->getJobCategoryService()->getJobCategoryById($toBeDeletedJobCatId);
				$status->delete();
                                $this->getUser()->setFlash('success', __(TopLevelMessages::DELETE_SUCCESS));
                            }
			}			
		}

		$this->redirect('admin/jobCategory');
	}
}

?>
