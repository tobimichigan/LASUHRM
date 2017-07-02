<?php
/** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Description of TimesheetPeriodDaoTest
 *
 * @group Time
 */
class TimesheetPeriodDaoTest extends PHPUnit_Framework_TestCase {

	private $timesheetPeriodDao;

	/**
	 * Set up method
	 */
	protected function setUp() {
        TestDataService::truncateTables(array('Config'));
        TestDataService::populate(sfConfig::get('sf_plugins_dir') . '/orangehrmTimePlugin/test/fixtures/TimesheetPeriodDao.yml');
        $this->timesheetPeriodDao = new TimesheetPeriodDao();
        
        
	}

	public function testGetDefinedTimesheetPeriod() {

		$xmlString = $this->timesheetPeriodDao->getDefinedTimesheetPeriod();
		$this->assertEquals('<TimesheetPeriod><PeriodType>Weekly</PeriodType><ClassName>WeeklyTimesheetPeriod</ClassName><StartDate>1</StartDate><Heading>Week</Heading></TimesheetPeriod>', $xmlString);
	}

	public function testIsTimesheetPeriodDefined() {
		$isAllowed = $this->timesheetPeriodDao->isTimesheetPeriodDefined();
		//$this->assertEquals("Yes", $isAllowed);
	}

	public function testSetTimesheetPeriod() {
		$temp = $this->timesheetPeriodDao->setTimesheetPeriod();
		$this->assertTrue($temp);
	}

	public function testSetTimesheetPeriodAndStartDate() {
		$xml = "<TimesheetPeriod><PeriodType>Weekly</PeriodType><ClassName>WeeklyTimesheetPeriod</ClassName><StartDate>3</StartDate><Heading>Week</Heading></TimesheetPeriod>";
		$temp = $this->timesheetPeriodDao->setTimesheetPeriodAndStartDate($xml);
		$this->assertTrue($temp);
	}

}

?>
