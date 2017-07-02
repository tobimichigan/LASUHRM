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
class WorkShiftDaoTest extends PHPUnit_Framework_TestCase {

    private $workShiftDao;
    protected $fixture;

    /**
     * Set up method
     */
    protected function setUp() {

        $this->workShiftDao = new WorkShiftDao();
        $this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmAdminPlugin/test/fixtures/WorkShiftDao.yml';
        TestDataService::populate($this->fixture);
    }

    public function testGetWorkShiftList() {
        $result = $this->workShiftDao->getWorkShiftList();
        $this->assertEquals(count($result), 2);
    }

    public function testGetWorkShiftById() {
        $result = $this->workShiftDao->getWorkShiftById(1);
        $this->assertEquals($result->getName(), 'Shift 1');
    }

    public function testGetWorkShiftEmployeeListById() {
        $result = $this->workShiftDao->getWorkShiftEmployeeListById(1);
        $this->assertEquals(count($result), 2);
    }

    public function testGetWorkShiftEmployeeList() {
        $result = $this->workShiftDao->getWorkShiftEmployeeList();
        $this->assertEquals(count($result), 2);
    }

    public function testUpdateWorkShift() {
        $shift = $this->workShiftDao->getWorkShiftById(1);
        $shift->setName("edited shift");
        $this->workShiftDao->updateWorkShift($shift);
        $result = $this->workShiftDao->getWorkShiftById(1);
        $this->assertEquals($result->getName(), "edited shift");
    }

}
