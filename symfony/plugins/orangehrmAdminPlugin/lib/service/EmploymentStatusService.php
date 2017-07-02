<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class EmploymentStatusService extends BaseService {

	private $empStatusDao;

	/**
	 * Construct
	 */
	public function __construct() {
		$this->empStatusDao = new EmploymentStatusDao();
	}

	/**
	 *
	 * @return <type>
	 */
	public function getEmploymentStatusDao() {
		return $this->empStatusDao;
	}

	/**
	 *
	 * @param EmploymentStatusDao $employmentStatusDao 
	 */
	public function setEmploymentStatusDao(EmploymentStatusDao $employmentStatusDao) {
		$this->empStatusDao = $employmentStatusDao;
	}
	
	public function getEmploymentStatusList(){
		return $this->empStatusDao->getEmploymentStatusList();
	}
	
	public function getEmploymentStatusById($id){
		return $this->empStatusDao->getEmploymentStatusById($id);
	}
	
	
}