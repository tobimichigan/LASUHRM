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
 * Leave period service test
 * @group Leave 
 */
class LeavePeriodHistoryServiceTest extends PHPUnit_Framework_TestCase {

    private $leavePeriodService;
    private $fixture;

    protected function setUp() {

        $this->leavePeriodService = new LeavePeriodService();
        $leaveEntitlementService = new LeaveEntitlementService();
        $leaveEntitlementService->setLeaveEntitlementStrategy(new FIFOEntitlementConsumptionStrategy());
        $this->leavePeriodService->setLeaveEntitlementService($leaveEntitlementService);
        
        TestDataService::truncateTables(array('LeavePeriodHistory'));
    }
    /**
     * @expectedException ServiceException
     */
    public function testGetGeneratedLeavePeriodListDateIsNotSet(){

        $result = $this->leavePeriodService->getGeneratedLeavePeriodList(null, true);
       
    }
    
    public function testGetGeneratedLeavePeriodListDefineAs2012Jan1st(){
        $leavePeriodHistory = new LeavePeriodHistory();
        $leavePeriodHistory->setLeavePeriodStartMonth(1);
        $leavePeriodHistory->setLeavePeriodStartDay(1);
        $leavePeriodHistory->setCreatedAt('2010-01-02');
        
        $this->leavePeriodService->saveLeavePeriodHistory( $leavePeriodHistory );
        
        
        $result = $this->leavePeriodService->getGeneratedLeavePeriodList(null, true);
        
        $expected = array(
            array('2010-01-01','2010-12-31'),
            array('2011-01-01','2011-12-31'),
            array('2012-01-01','2012-12-31'),
            array('2013-01-01','2013-12-31'));
        
        // extend range till next year end:
        $now = new DateTime();
        
        $nextYear = $now->format('Y') + 1;
        $this->assertTrue($nextYear > 2012, 'System clock set to past!. Test should be run with system date 2012 or later.');
        
        if ($nextYear > 2013) {
            for ($year = 2014; $year <= $nextYear; $year++) {
                $expected[] = array($year . '-01-01', $year . '-12-31');
            }
        }
        
        $this->assertEquals($expected, $result);
        
        
    }
    
     public function testGetGeneratedLeavePeriodListDefineAs2010Jan1st(){
        $leavePeriodHistory = new LeavePeriodHistory();
        $leavePeriodHistory->setLeavePeriodStartMonth(1);
        $leavePeriodHistory->setLeavePeriodStartDay(1);
        $leavePeriodHistory->setCreatedAt('2010-01-02');
        
        $this->leavePeriodService->saveLeavePeriodHistory( $leavePeriodHistory );
        
        $expected = array(
            array('2010-01-01','2010-12-31'),
            array('2011-01-01','2011-12-31'),
            array('2012-01-01','2012-12-31'),
            array('2013-01-01','2013-12-31'));
        
        // extend range till next year end:
        $now = new DateTime();
        
        $nextYear = $now->format('Y') + 1;
        $this->assertTrue($nextYear > 2012, 'System clock set to past!. Test should be run with system date 2012 or later.');
        
        if ($nextYear > 2013) {
            for ($year = 2014; $year <= $nextYear; $year++) {
                $expected[] = array($year . '-01-01', $year . '-12-31');
            }
        }
        
        $result = $this->leavePeriodService->getGeneratedLeavePeriodList(null, true);
        $this->assertEquals($expected, $result);
        
        
    }

     /* Fails if run in 2014 */
     public function testGetGeneratedLeavePeriodListForLeapYear(){
        $leavePeriodHistory = new LeavePeriodHistory();
        $leavePeriodHistory->setLeavePeriodStartMonth(3);
        $leavePeriodHistory->setLeavePeriodStartDay(1);
        $leavePeriodHistory->setCreatedAt('2010-01-02');
        
        $this->leavePeriodService->saveLeavePeriodHistory( $leavePeriodHistory );
        
        
        $result = $this->leavePeriodService->getGeneratedLeavePeriodList(null, true);
        
        $this->assertEquals(array(array('2009-03-01','2010-02-28'),array('2010-03-01','2011-02-28'),array('2011-03-01','2012-02-29'),array('2012-03-01','2013-02-28'),array('2013-03-01','2014-02-28'), array('2014-03-01','2015-02-28')),$result);                
    }
    
    public function testGetGeneratedLeavePeriodListDefineAs2010Jan1stAnd2012Jan1st(){
        $leavePeriodHistory = new LeavePeriodHistory();
        $leavePeriodHistory->setLeavePeriodStartMonth(1);
        $leavePeriodHistory->setLeavePeriodStartDay(1);
        $leavePeriodHistory->setCreatedAt('2010-10-02');
        
        $this->leavePeriodService->saveLeavePeriodHistory( $leavePeriodHistory );
        
        $leavePeriodHistory = new LeavePeriodHistory();
        $leavePeriodHistory->setLeavePeriodStartMonth(1);
        $leavePeriodHistory->setLeavePeriodStartDay(1);
        $leavePeriodHistory->setCreatedAt('2011-08-04');
        
        $this->leavePeriodService->saveLeavePeriodHistory( $leavePeriodHistory );
        
        $leavePeriodHistory = new LeavePeriodHistory();
        $leavePeriodHistory->setLeavePeriodStartMonth(1);
        $leavePeriodHistory->setLeavePeriodStartDay(1);
        $leavePeriodHistory->setCreatedAt('2012-08-02');
        
        $this->leavePeriodService->saveLeavePeriodHistory( $leavePeriodHistory );
        
        
        $result = $this->leavePeriodService->getGeneratedLeavePeriodList(null, true);
        
        $expected = array(array('2010-01-01','2010-12-31'),
                          array('2011-01-01','2011-12-31'),
                          array('2012-01-01','2012-12-31'),
                          array('2013-01-01','2013-12-31'));
        
        // extend range till next year end:
        $now = new DateTime();
        
        $nextYear = $now->format('Y') + 1;
        $this->assertTrue($nextYear > 2012, 'System clock set to past!. Test should be run with system date 2012 or later.');
        
        if ($nextYear > 2013) {
            for ($year = 2014; $year <= $nextYear; $year++) {
                $expected[] = array($year . '-01-01', $year . '-12-31');
            }
        }
        
        $this->assertEquals($expected,$result);        
        
    }
    
    /* Fails if run in 2014 */
     public function testGetGeneratedLeavePeriodListCase1(){
        $leavePeriodHistory = new LeavePeriodHistory();
        $leavePeriodHistory->setLeavePeriodStartMonth(1);
        $leavePeriodHistory->setLeavePeriodStartDay(1);
        $leavePeriodHistory->setCreatedAt('2010-10-02');
        
        $this->leavePeriodService->saveLeavePeriodHistory( $leavePeriodHistory );
        
        $leavePeriodHistory = new LeavePeriodHistory();
        $leavePeriodHistory->setLeavePeriodStartMonth(2);
        $leavePeriodHistory->setLeavePeriodStartDay(1);
        $leavePeriodHistory->setCreatedAt('2011-08-04');
        
        $this->leavePeriodService->saveLeavePeriodHistory( $leavePeriodHistory );
        
        $leavePeriodHistory = new LeavePeriodHistory();
        $leavePeriodHistory->setLeavePeriodStartMonth(3);
        $leavePeriodHistory->setLeavePeriodStartDay(1);
        $leavePeriodHistory->setCreatedAt('2012-08-02');
        
        $this->leavePeriodService->saveLeavePeriodHistory( $leavePeriodHistory );
        
        // work around for cached generated leave period list
        $newLeavePeriodService = new LeavePeriodService();
        $newLeavePeriodService->setLeaveEntitlementService($this->leavePeriodService->getLeaveEntitlementService());                
        $result= $newLeavePeriodService->getGeneratedLeavePeriodList(null, true);
        
        $this->assertEquals(array(array('2010-01-01','2010-12-31'),array('2011-01-01','2012-01-31'),array('2012-02-01','2013-02-28'),array('2013-03-01','2014-02-28'),array('2014-03-01','2015-02-28')),$result);
        
        
    }
    
      public function testGetGeneratedLeavePeriodListCase2(){
        $leavePeriodHistory = new LeavePeriodHistory();
        $leavePeriodHistory->setLeavePeriodStartMonth(2);
        $leavePeriodHistory->setLeavePeriodStartDay(1);
        $leavePeriodHistory->setCreatedAt('2010-01-01');
        
        $this->leavePeriodService->saveLeavePeriodHistory( $leavePeriodHistory );
        
        $leavePeriodHistory = new LeavePeriodHistory();
        $leavePeriodHistory->setLeavePeriodStartMonth(1);
        $leavePeriodHistory->setLeavePeriodStartDay(1);
        $leavePeriodHistory->setCreatedAt('2010-01-02');
        
        $this->leavePeriodService->saveLeavePeriodHistory( $leavePeriodHistory );
        
        $leavePeriodHistory = new LeavePeriodHistory();
        $leavePeriodHistory->setLeavePeriodStartMonth(1);
        $leavePeriodHistory->setLeavePeriodStartDay(2);
        $leavePeriodHistory->setCreatedAt('2010-01-02');
        
        $this->leavePeriodService->saveLeavePeriodHistory( $leavePeriodHistory );
        
        // work around for cached generated leave period list
        $newLeavePeriodService = new LeavePeriodService();
        $newLeavePeriodService->setLeaveEntitlementService($this->leavePeriodService->getLeaveEntitlementService());                
        $result= $newLeavePeriodService->getGeneratedLeavePeriodList(null, true);

        $expected = array(
            array('2009-02-01','2011-01-01'),
            array('2011-01-02','2012-01-01'),
            array('2012-01-02','2013-01-01'),
            array('2013-01-02','2014-01-01'));
        
        // extend range till next year end:
        $now = new DateTime();
        
        $nextYear = $now->format('Y') + 1;
        $this->assertTrue($nextYear > 2012, 'System clock set to past!. Test should be run with system date 2012 or later.');
        
        if ($nextYear > 2013) {
            for ($year = 2014; $year <= $nextYear; $year++) {
                $expected[] = array($year . '-01-02', ($year + 1) . '-01-01');
            }
        }        
        
        $this->assertEquals($expected, $result);
        
        
    }
    
    public function testGetCurrentLeavePeriodByDate( ){
        $leavePeriodHistory = new LeavePeriodHistory();
        $leavePeriodHistory->setLeavePeriodStartMonth(1);
        $leavePeriodHistory->setLeavePeriodStartDay(1);
        $leavePeriodHistory->setCreatedAt('2010-01-02');
        
        $this->leavePeriodService->saveLeavePeriodHistory( $leavePeriodHistory );
        
        
        $result = $this->leavePeriodService->getCurrentLeavePeriodByDate('2012-01-01', true);
       
        $this->assertEquals(array('2012-01-01','2012-12-31'),$result);
        
         $result = $this->leavePeriodService->getCurrentLeavePeriodByDate('2013-01-04', true);
       
        $this->assertEquals(array('2013-01-01','2013-12-31'),$result);
     
    }
    
    
}
