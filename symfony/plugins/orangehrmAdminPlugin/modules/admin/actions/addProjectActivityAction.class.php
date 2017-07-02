<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class addProjectActivityAction extends sfAction {

	public function execute($request) {

		$this->form = new AddProjectActivityForm();
		if ($request->isMethod('post')) {

			$this->form->bind($request->getParameter($this->form->getName()));
			if ($this->form->isValid()) {
				
				$projectId = $this->form->save();
				if($this->form->edited){
					$this->getUser()->setFlash('success', __(TopLevelMessages::UPDATE_SUCCESS));
				} else {
					$this->getUser()->setFlash('success', __(TopLevelMessages::SAVE_SUCCESS));
				}
				$this->redirect('admin/saveProject?projectId=' . $projectId . '#ProjectActivities');
			}
		}
		$this->redirect('admin/viewProjects');
	}

}

?>
