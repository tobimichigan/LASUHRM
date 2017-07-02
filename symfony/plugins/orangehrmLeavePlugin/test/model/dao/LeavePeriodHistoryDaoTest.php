<?php
/*
 ** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
*/

/**
 * Test for LeavePeriodDao class
 * 
 * @group Leave 
 */

class LeavePeriodHistoryDaoTest extends PHPUnit_Framework_TestCase {
    
    public $leavePeriodDao;

    protected function setUp() {

        $this->leavePeriodDao = new LeavePeriodDao();
        TestDataService::populate(sfConfig::get('sf_plugins_dir') . '/orangehrmLeavePlugin/test/fixtures/LeavePeriodHistoryDao.yml');

    }
    
    public function testSaveLeavePeriodHistory(){
        $leavePeriodHistory = new LeavePeriodHistory();
        $leavePeriodHistory->setLeavePeriodStartMonth(1);
        $leavePeriodHistory->setLeavePeriodStartDay(1);
        $leavePeriodHistory->setCreatedAt('2012-01-01');
        
        $result = $this->leavePeriodDao->saveLeavePeriodHistory( $leavePeriodHistory );
        $this->assertEquals(1,$result->getLeavePeriodStartMonth());
        $this->assertEquals(1,$result->getLeavePeriodStartDay());
        $this->assertEquals('2012-01-01',$result->getCreatedAt());
    }
    
    public function testGetCurrentLeavePeriodStartDateAndMonth(){
        $result = $this->leavePeriodDao->getCurrentLeavePeriodStartDateAndMonth( );
        $this->assertEquals(1,$result->getLeavePeriodStartMonth());
        $this->assertEquals(3,$result->getLeavePeriodStartDay());
        $this->assertEquals('2012-01-02',$result->getCreatedAt());
    }
    
    public function testGetLeavePeriodHistoryList(){
        $result = $this->leavePeriodDao->getLeavePeriodHistoryList( );
        $this->assertEquals(1,$result[0]->getLeavePeriodStartMonth());
        $this->assertEquals(4,$result[0]->getLeavePeriodStartDay());
        $this->assertEquals('2012-01-01',$result[0]->getCreatedAt());
        
        $this->assertEquals(1,$result[1]->getLeavePeriodStartMonth());
        $this->assertEquals(1,$result[1]->getLeavePeriodStartDay());
        $this->assertEquals('2012-01-02',$result[1]->getCreatedAt());
        
        $this->assertEquals(1,$result[2]->getLeavePeriodStartMonth());
        $this->assertEquals(2,$result[2]->getLeavePeriodStartDay());
        $this->assertEquals('2012-01-02',$result[2]->getCreatedAt());
        
        $this->assertEquals(4,count($result));
    }
}
