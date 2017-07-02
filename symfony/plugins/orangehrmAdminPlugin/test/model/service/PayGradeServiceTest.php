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
class PayGradeServiceTest extends PHPUnit_Framework_TestCase {
	
	private $payGradeService;
	protected $fixture;

	/**
	 * Set up method
	 */
	protected function setUp() {

		$this->payGradeService = new PayGradeService();
		$this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmAdminPlugin/test/fixtures/PayGradeDao.yml';
		TestDataService::populate($this->fixture);
	}
	
	public function testGetPayGradeList() {

		$payGradeList = TestDataService::loadObjectList('PayGrade', $this->fixture, 'PayGrade');

		$payGradeDao = $this->getMock('PayGradeDao');
		$payGradeDao->expects($this->once())
			->method('getPayGradeList')
			->will($this->returnValue($payGradeList));

		$this->payGradeService->setPayGradeDao($payGradeDao);

		$result = $this->payGradeService->getPayGradeList();
		$this->assertEquals($result, $payGradeList);
	}
	
	public function testGetPayGradeById() {

		$payGradeList = TestDataService::loadObjectList('PayGrade', $this->fixture, 'PayGrade');

		$payGradeDao = $this->getMock('PayGradeDao');
		$payGradeDao->expects($this->once())
			->method('getPayGradeById')
			->with(1)
			->will($this->returnValue($payGradeList[0]));

		$this->payGradeService->setPayGradeDao($payGradeDao);

		$result = $this->payGradeService->getPayGradeById(1);
		$this->assertEquals($result, $payGradeList[0]);
	}
	
	public function testGetCurrencyListByPayGradeId() {

		$payGradeCurrencyList = TestDataService::loadObjectList('PayGradeCurrency', $this->fixture, 'PayGradeCurrency');
		$payGradeCurrencyList = array($payGradeCurrencyList[0], $payGradeCurrencyList[1]);

		$payGradeDao = $this->getMock('PayGradeDao');
		$payGradeDao->expects($this->once())
			->method('getCurrencyListByPayGradeId')
			->with(1)
			->will($this->returnValue($payGradeCurrencyList));

		$this->payGradeService->setPayGradeDao($payGradeDao);

		$result = $this->payGradeService->getCurrencyListByPayGradeId(1);
		$this->assertEquals($result, $payGradeCurrencyList);
	}
	
	public function testGetCurrencyByCurrencyIdAndPayGradeId() {

		$payGradeCurrencyList = TestDataService::loadObjectList('PayGradeCurrency', $this->fixture, 'PayGradeCurrency');

		$payGradeDao = $this->getMock('PayGradeDao');
		$payGradeDao->expects($this->once())
			->method('getCurrencyByCurrencyIdAndPayGradeId')
			->with('USD', 1)
			->will($this->returnValue($payGradeCurrencyList[0]));

		$this->payGradeService->setPayGradeDao($payGradeDao);

		$result = $this->payGradeService->getCurrencyByCurrencyIdAndPayGradeId('USD', 1);
		$this->assertEquals($result, $payGradeCurrencyList[0]);
	}
}
