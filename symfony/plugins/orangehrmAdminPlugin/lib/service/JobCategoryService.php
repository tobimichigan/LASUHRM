<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class JobCategoryService extends BaseService {

	private $jobCatDao;

	/**
	 * Construct
	 */
	public function __construct() {
		$this->jobCatDao = new JobCategoryDao();
	}

	/**
	 *
	 * @return <type>
	 */
	public function getJobCategoryDao() {
		return $this->jobCatDao;
	}

	/**
	 * @param JobCategoryDao $jobCategoryDao 
	 */
	public function setJobCategoryDao(JobCategoryDao $jobCategoryDao) {
		$this->jobCatDao = $jobCategoryDao;
	}
	
	public function getJobCategoryList(){
		return $this->jobCatDao->getJobCategoryList();
	}
	
	public function getJobCategoryById($jobCatId){
		return $this->jobCatDao->getJobCategoryById($jobCatId);
	}
	
}

?>
