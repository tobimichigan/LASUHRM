<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
require_once sfConfig::get('sf_test_dir') . '/util/TestDataService.php';

/**
 *  @group Admin
 */
class LocationDaoTest extends PHPUnit_Framework_TestCase {
	
	private $locationDao;
	protected $fixture;

	/**
	 * Set up method
	 */
	protected function setUp() {

		$this->locationDao = new LocationDao();
		$this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmAdminPlugin/test/fixtures/LocationDao.yml';
		TestDataService::populate($this->fixture);
	}
	
	public function testGetLocationById(){
		$result = $this->locationDao->getLocationById(1);
		$this->assertTrue($result instanceof Location);
                $this->assertEquals($result->getName(), 'location 1');
	}
	
	public function testGetNumberOfEmplyeesForLocation(){
		$result = $this->locationDao->getNumberOfEmplyeesForLocation(1);
		$this->assertEquals($result, 3);
	}
	
	public function testGetLocationList(){
		$result = $this->locationDao->getLocationList();
		$this->assertEquals(count($result), 3);
	}
		
	public function testSearchLocationsForNullArray() {
		$srchClues = array();
		$result = $this->locationDao->searchLocations($srchClues);
		$this->assertEquals(count($result), 3);
	}

	public function testSearchLocationsForLocationName() {
		$srchClues = array(
		    'name' => 'location 1'
		);
		$result = $this->locationDao->searchLocations($srchClues);
		$this->assertEquals(count($result), 1);
		$this->assertEquals($result[0]->getId(), 1);
	}

	public function testSearchLocationsForCity() {
		$srchClues = array(
		    'city' => 'city 1'
		);
		$result = $this->locationDao->searchLocations($srchClues);
		$this->assertEquals(count($result), 1);
	}

	public function testSearchLocationsForCountry() {
		$srchClues = array(
		    'country' => 'LK'
		);
		$result = $this->locationDao->searchLocations($srchClues);
		$this->assertEquals(count($result), 2);
		$this->assertEquals($result[0]->getId(), 1);
	}
        
	public function testSearchLocationsForCountryArray() {
		$srchClues = array(
		    'country' => array('LK')
		);
		$result = $this->locationDao->searchLocations($srchClues);
		$this->assertEquals(count($result), 2);
		$this->assertEquals($result[0]->getId(), 1);
                
		$srchClues = array(
		    'country' => array('LK', 'US')
		);
		$result = $this->locationDao->searchLocations($srchClues);
		$this->assertEquals(count($result), 3);
		$this->assertEquals($result[0]->getId(), 1);                
	}        
	
	public function testGetSearchLocationListCount() {
		$srchClues = array(
		    'country' => 'LK'
		);
		$result = $this->locationDao->getSearchLocationListCount($srchClues);
		$this->assertEquals($result, 2);
	}
}

?>
