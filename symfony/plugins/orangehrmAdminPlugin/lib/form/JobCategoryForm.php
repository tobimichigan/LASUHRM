<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

class JobCategoryForm extends BaseForm {
	
	private $jobCatService;

	public function getJobCategoryService() {
		if (is_null($this->jobCatService)) {
			$this->jobCatService = new JobCategoryService();
			$this->jobCatService->setJobCategoryDao(new JobCategoryDao());
		}
		return $this->jobCatService;
	}
	
	public function configure() {

		$this->setWidgets(array(
		    'jobCategoryId' => new sfWidgetFormInputHidden(),
		    'name' => new sfWidgetFormInputText(),
		));

		$this->setValidators(array(
		    'jobCategoryId' => new sfValidatorNumber(array('required' => false)),
		    'name' => new sfValidatorString(array('required' => true, 'max_length' => 52, 'trim' => true)),
		));

		$this->widgetSchema->setNameFormat('jobCategory[%s]');
				
	}
	
	public function save(){
		
		$jobCatId = $this->getValue('jobCategoryId');
		if(!empty ($jobCatId)){
			$jobCat = $this->getJobCategoryService()->getJobCategoryById($jobCatId);
		} else {
			$jobCat = new JobCategory();
		}
		$jobCat->setName($this->getValue('name'));
		$jobCat->save();
	}
	
	public function getJobCategoryListAsJson() {
		
		$list = array();
		$jobCatList = $this->getJobCategoryService()->getJobCategoryList();
		foreach ($jobCatList as $jobCat) {
			$list[] = array('id' => $jobCat->getId(), 'name' => $jobCat->getName());
		}
		return json_encode($list);
	}
}

?>
