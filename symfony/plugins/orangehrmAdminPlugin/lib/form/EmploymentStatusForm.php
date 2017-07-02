<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */
class EmploymentStatusForm extends BaseForm {

    protected $empStatusService;
    
	public function getEmploymentStatusService() {
		if (is_null($this->empStatusService)) {
			$this->empStatusService = new EmploymentStatusService();
			$this->empStatusService->setEmploymentStatusDao(new EmploymentStatusDao());
		}
		return $this->empStatusService;
	}

	public function configure() {

		$this->setWidgets(array(
		    'empStatusId' => new sfWidgetFormInputHidden(),
		    'name' => new sfWidgetFormInputText(),
		));

		$this->setValidators(array(
		    'empStatusId' => new sfValidatorNumber(array('required' => false)),
		    'name' => new sfValidatorString(array('required' => true, 'max_length' => 52)),
		));

		$this->widgetSchema->setNameFormat('empStatus[%s]');
		
	}

	public function save() {

		$empStatusId = $this->getValue('empStatusId');
		if (!empty($empStatusId)) {
			$empStatus = $this->getEmploymentStatusService()->getEmploymentStatusById($empStatusId);
		} else {
			$empStatus = new EmploymentStatus();
		}
		$empStatus->setName($this->getValue('name'));
		$empStatus->save();
	}

	public function getEmploymentStatusListAsJson() {

		$list = array();
		$empStatusList = $this->getEmploymentStatusService()->getEmploymentStatusList();
		foreach ($empStatusList as $empStatus) {
			$list[] = array('id' => $empStatus->getId(), 'name' => $empStatus->getName());
		}
		return json_encode($list);
	}

}

?>
