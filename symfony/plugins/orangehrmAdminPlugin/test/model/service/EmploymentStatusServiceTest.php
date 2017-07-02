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
class EmploymentStatusServiceTest extends PHPUnit_Framework_TestCase {
	
	private $empStatService;
	private $fixture;

	/**
	 * Set up method
	 */
	protected function setUp() {
		$this->empStatService = new EmploymentStatusService();
		$this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmAdminPlugin/test/fixtures/EmploymentStatusDao.yml';
		TestDataService::populate($this->fixture);
	}
	
	public function testGetEmploymentStatusList() {

		$empStatusList = TestDataService::loadObjectList('EmploymentStatus', $this->fixture, 'EmploymentStatus');

		$empStatusDao = $this->getMock('EmploymentStatusDao');
		$empStatusDao->expects($this->once())
			->method('getEmploymentStatusList')
			->will($this->returnValue($empStatusList));

		$this->empStatService->setEmploymentStatusDao($empStatusDao);

		$result = $this->empStatService->getEmploymentStatusList();
		$this->assertEquals($result, $empStatusList);
	}
	
	public function testGetEmploymentStatusById() {

		$empStatusList = TestDataService::loadObjectList('EmploymentStatus', $this->fixture, 'EmploymentStatus');

		$empStatusDao = $this->getMock('EmploymentStatusDao');
		$empStatusDao->expects($this->once())
			->method('getEmploymentStatusById')
			->with(1)
			->will($this->returnValue($empStatusList[0]));

		$this->empStatService->setEmploymentStatusDao($empStatusDao);

		$result = $this->empStatService->getEmploymentStatusById(1);
		$this->assertEquals($result, $empStatusList[0]);
	}
}

?>
