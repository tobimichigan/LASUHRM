<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Test class for LeaveConfigurationService
 * @group Leave
 */
class LeaveConfigurationServiceTest extends PHPUnit_Framework_TestCase {

    private $service;

    /**
     * Set up method
     */
    protected function setUp() {
        $this->service = new LeaveConfigurationService();
    }
    
    public function testGetLeaveEntitlementConsumptionStrategy() {
        
        $strategy = "FIFO";
        $mockDao = $this->getMock('ConfigDao', array('getValue'));
        $mockDao->expects($this->once())
                    ->method('getValue')
                    ->with(LeaveConfigurationService::KEY_LEAVE_ENTITLEMENT_CONSUMPTION_STRATEGY)
                    ->will($this->returnValue($strategy)); 
        
        $this->service->setConfigDao($mockDao);
        
        $this->assertEquals($strategy, $this->service->getLeaveEntitlementConsumptionStrategy());
    }
    
    public function testGetWorkScheduleImplementation() {
        $implementation = "Basic";
        $mockDao = $this->getMock('ConfigDao', array('getValue'));
        $mockDao->expects($this->once())
                    ->method('getValue')
                    ->with(LeaveConfigurationService::KEY_LEAVE_WORK_SCHEDULE_IMPLEMENTATION)
                    ->will($this->returnValue($implementation)); 
        
        $this->service->setConfigDao($mockDao);
        
        $this->assertEquals($implementation, $this->service->getWorkScheduleImplementation());        
    }
    
}

