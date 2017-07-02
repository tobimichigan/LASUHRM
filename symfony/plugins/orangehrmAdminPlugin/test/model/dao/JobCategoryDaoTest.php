<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
require_once sfConfig::get('sf_test_dir') . '/util/TestDataService.php';

/**
 * @group Admin
 */
class JobCategoryDaoTest extends PHPUnit_Framework_TestCase {
	
	private $jobCatDao;
	protected $fixture;

	/**
	 * Set up method
	 */
	protected function setUp() {

		$this->jobCatDao = new JobCategoryDao();
		$this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmAdminPlugin/test/fixtures/JobCategoryDao.yml';
		TestDataService::populate($this->fixture);
	}
	
	public function testGetJobCategoryList(){
		$result = $this->jobCatDao->getJobCategoryList();
		$this->assertEquals(count($result), 3);
	}
	
	public function testGetJobCategoryById(){
		$result = $this->jobCatDao->getJobCategoryById(1);
		$this->assertEquals($result->getName(), 'Job Category 1');
	}
}

?>
