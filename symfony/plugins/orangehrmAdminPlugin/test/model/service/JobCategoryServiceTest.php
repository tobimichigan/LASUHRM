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
class JobCategoryServiceTest extends PHPUnit_Framework_TestCase {
	
	private $jobCatService;
	private $fixture;

	/**
	 * Set up method
	 */
	protected function setUp() {
		$this->jobCatService = new JobCategoryService();
		$this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmAdminPlugin/test/fixtures/JobCategoryDao.yml';
		TestDataService::populate($this->fixture);
	}
	
	public function testGetJobCategoryList() {

		$jobCatList = TestDataService::loadObjectList('JobCategory', $this->fixture, 'JobCategory');

		$jobCatDao = $this->getMock('JobCategoryDao');
		$jobCatDao->expects($this->once())
			->method('getJobCategoryList')
			->will($this->returnValue($jobCatList));

		$this->jobCatService->setJobCategoryDao($jobCatDao);

		$result = $this->jobCatService->getJobCategoryList();
		$this->assertEquals($result, $jobCatList);
	}
	
	public function testGtJobCategoryById() {

		$jobCatList = TestDataService::loadObjectList('JobCategory', $this->fixture, 'JobCategory');

		$jobCatDao = $this->getMock('JobCategoryDao');
		$jobCatDao->expects($this->once())
			->method('getJobCategoryById')
			->with(1)
			->will($this->returnValue($jobCatList[0]));

		$this->jobCatService->setJobCategoryDao($jobCatDao);

		$result = $this->jobCatService->getJobCategoryById(1);
		$this->assertEquals($result, $jobCatList[0]);
	}
}

?>
