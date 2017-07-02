<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class copyActivityAction extends sfAction {

	private $projectService;

	public function getProjectService() {
		if (is_null($this->projectService)) {
			$this->projectService = new ProjectService();
			$this->projectService->setProjectDao(new ProjectDao());
		}
		return $this->projectService;
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

	/**
	 *
	 * @param <type> $request
	 */
	public function execute($request) {

		$this->setForm(new CopyActivityForm());
		$projectId = $request->getParameter('projectId');
		$this->form->bind($request->getParameter($this->form->getName()));

		$projectActivityList = $this->getProjectService()->getActivityListByProjectId($projectId);
		if ($this->form->isValid()) {
			$activityNameList = $request->getParameter('activityNames', array());
			$activities = new Doctrine_Collection('ProjectActivity');

			$isUnique = true;
			foreach ($activityNameList as $activityName) {
				foreach ($projectActivityList as $projectActivity) {
					if (strtolower($activityName) == strtolower($projectActivity->getName())) {
						$isUnique = false;
						break;
					}
				}
			}
			if ($isUnique) {
				foreach ($activityNameList as $activityName) {

					$activity = new ProjectActivity();
					$activity->setProjectId($projectId);
					$activity->setName($activityName);
					$activity->setIsDeleted(ProjectActivity::ACTIVE_PROJECT);
					$activities->add($activity);
				}
				$activities->save();
				$this->getUser()->setFlash('success', __('Successfully Copied'));
			} else {
				$this->getUser()->setFlash('error', __('Name Already Exists'));
			}
			
			$this->redirect('admin/saveProject?projectId=' . $projectId . '#ProjectActivities');
		}
	}

}

?>
