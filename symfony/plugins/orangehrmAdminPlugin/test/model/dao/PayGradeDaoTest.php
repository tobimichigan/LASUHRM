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
class PayGradeDaoTest extends PHPUnit_Framework_TestCase {
	
	private $payGradeDao;
	protected $fixture;

	/**
	 * Set up method
	 */
	protected function setUp() {

		$this->payGradeDao = new PayGradeDao();
		$this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmAdminPlugin/test/fixtures/PayGradeDao.yml';
		TestDataService::populate($this->fixture);
	}
	
	public function testGetPayGradeList(){
		$result = $this->payGradeDao->getPayGradeList();
		$this->assertEquals(count($result), 3);
	}
	
	public function testGetPayGradeById(){
		$result = $this->payGradeDao->getPayGradeById(1);
		$this->assertEquals($result->getName(), 'Pay Grade 1');
	}
	
	public function testGetCurrencyListByPayGradeId(){
		$result = $this->payGradeDao->getCurrencyListByPayGradeId(1);
		$this->assertEquals(count($result), 2);
	}
	
	public function testGetCurrencyByCurrencyIdAndPayGradeId(){
		$result = $this->payGradeDao->getCurrencyByCurrencyIdAndPayGradeId('USD', 1);
		$this->assertEquals($result->getMinSalary(), 5000);
	}
}

?>
