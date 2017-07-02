<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

class AddProjectActivityForm extends BaseForm {
	
	private $projectService;
	public $edited = false;

	public function getProjectService() {
		if (is_null($this->projectService)) {
			$this->projectService = new ProjectService();
			$this->projectService->setProjectDao(new ProjectDao());
		}
		return $this->projectService;
	}
	
	public function configure() {

		$this->setWidgets(array(
		    'projectId' => new sfWidgetFormInputHidden(),
		    'activityId' => new sfWidgetFormInputHidden(),
		    'activityName' => new sfWidgetFormInputText(),
		    
		));

		$this->setValidators(array(
		    'projectId' => new sfValidatorNumber(array('required' => true)),
		    'activityId' => new sfValidatorNumber(array('required' => false)),
		    'activityName' => new sfValidatorString(array('required' => true, 'max_length' => 102)),
		    
		));

		$this->widgetSchema->setNameFormat('addProjectActivity[%s]');

	}
	
	public function save(){
		
		$projectId = $this->getValue('projectId');
		$activityId = $this->getValue('activityId');
		
		if(!empty ($activityId)){
			$activity = $this->getProjectService()->getProjectActivityById($activityId);
			$this->edited = true;
		} else {
			$activity = new ProjectActivity();
		}
		
		$activity->setProjectId($projectId);
		$activity->setName($this->getValue('activityName'));
		$activity->setIsDeleted(ProjectActivity::ACTIVE_PROJECT);
		$activity->save();
		return $projectId;
	}

}

?>
