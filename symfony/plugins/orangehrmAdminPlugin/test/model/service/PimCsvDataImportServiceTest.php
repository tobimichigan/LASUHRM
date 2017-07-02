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
class PimCsvDataImportServiceTest extends PHPUnit_Framework_TestCase {

	private $pimDataImportService;

	/**
	 * Set up method
	 */
	protected function setUp() {
		$this->pimDataImportService = new PimCsvDataImportService();
	}
	
	public function testGetCsvDataImportService(){
		
		$result = $this->pimDataImportService->getCsvDataImportService();
		$this->assertTrue($result instanceof CsvDataImportService);
	}
	
}

?>
