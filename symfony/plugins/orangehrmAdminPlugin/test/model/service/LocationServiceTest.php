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
class LocationServiceTest extends PHPUnit_Framework_TestCase {
	
	private $locationService;
	private $fixture;

	/**
	 * Set up method
	 */
	protected function setUp() {
		$this->locationService = new LocationService();
		$this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmAdminPlugin/test/fixtures/LocationDao.yml';
		TestDataService::populate($this->fixture);
	}
	
	public function testgetLocationById() {

		$locationList = TestDataService::loadObjectList('Location', $this->fixture, 'Location');

		$locationDao = $this->getMock('LocationDao');
		$locationDao->expects($this->once())
			->method('getLocationById')
			->with(1)
			->will($this->returnValue($locationList[0]));

		$this->locationService->setLocationDao($locationDao);

		$result = $this->locationService->getLocationById(1);
		$this->assertEquals($result,$locationList[0]);
	}
	
	public function testSearchLocations() {

		$locationList = TestDataService::loadObjectList('Location', $this->fixture, 'Location');
		$srchClues = array(
		    'name' => 'location 1'
		);
		
		$locationDao = $this->getMock('LocationDao');
		$locationDao->expects($this->once())
			->method('searchLocations')
			->with($srchClues)
			->will($this->returnValue($locationList[0]));

		$this->locationService->setLocationDao($locationDao);

		$result = $this->locationService->searchLocations($srchClues);
		$this->assertEquals($result,$locationList[0]);
	}
	
	public function testGetSearchLocationListCount() {

		$locationList = TestDataService::loadObjectList('Location', $this->fixture, 'Location');
		$srchClues = array(
		    'name' => 'location 1'
		);
		
		$locationDao = $this->getMock('LocationDao');
		$locationDao->expects($this->once())
			->method('getSearchLocationListCount')
			->with($srchClues)
			->will($this->returnValue(1));

		$this->locationService->setLocationDao($locationDao);

		$result = $this->locationService->getSearchLocationListCount($srchClues);
		$this->assertEquals($result,1);
	}
	
	public function testGetNumberOfEmplyeesForLocation() {

		$locationList = TestDataService::loadObjectList('Location', $this->fixture, 'Location');

		$locationDao = $this->getMock('LocationDao');
		$locationDao->expects($this->once())
			->method('getNumberOfEmplyeesForLocation')
			->with(1)
			->will($this->returnValue(2));

		$this->locationService->setLocationDao($locationDao);

		$result = $this->locationService->getNumberOfEmplyeesForLocation(1);
		$this->assertEquals($result,2);
	}
	
	public function testGetLocationList() {

		$locationList = TestDataService::loadObjectList('Location', $this->fixture, 'Location');

		$locationDao = $this->getMock('LocationDao');
		$locationDao->expects($this->once())
			->method('getLocationList')
			->will($this->returnValue($locationList));

		$this->locationService->setLocationDao($locationDao);

		$result = $this->locationService->getLocationList();
		$this->assertEquals($result,$locationList);
	}
}
