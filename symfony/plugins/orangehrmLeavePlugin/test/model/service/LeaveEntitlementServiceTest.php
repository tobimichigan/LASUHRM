<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * LeaveEntitlementServiceTest
 * 
 * @group Leave 
 */
class LeaveEntitlementServiceTest extends PHPUnit_Framework_TestCase {

    private $service;
    protected $fixture;

    /**
     * Set up method
     */
    protected function setUp() {
        $this->service = new LeaveEntitlementService();
        $this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmLeavePlugin/test/fixtures/LeaveEntitlement.yml';        
    }
    
    public function testSearchLeaveEntitlements() {
        $leaveEntitlements  = TestDataService::loadObjectList('LeaveEntitlement', $this->fixture, 'LeaveEntitlement');
        $parameterHolder = new LeaveEntitlementSearchParameterHolder();

        $mockDao = $this->getMock('LeaveEntitlementDao', array('searchLeaveEntitlements'));
        $mockDao->expects($this->once())
                    ->method('searchLeaveEntitlements')
                    ->with($parameterHolder)
                    ->will($this->returnValue($leaveEntitlements));

        $this->service->setLeaveEntitlementDao($mockDao);
        $results = $this->service->searchLeaveEntitlements($parameterHolder);      
        
        $this->assertEquals($leaveEntitlements, $results);
    }
    
    public function testSaveLeaveEntitlement() {
        $leaveEntitlements  = TestDataService::loadObjectList('LeaveEntitlement', $this->fixture, 'LeaveEntitlement');
        $leaveEntitlement = $leaveEntitlements[0];

        $mockDao = $this->getMock('LeaveEntitlementDao', array('saveLeaveEntitlement'));
        $mockDao->expects($this->once())
                    ->method('saveLeaveEntitlement')
                    ->with($leaveEntitlement)
                    ->will($this->returnValue($leaveEntitlement));

        $this->service->setLeaveEntitlementDao($mockDao);
        $result = $this->service->saveLeaveEntitlement($leaveEntitlement);      
        
        $this->assertEquals($leaveEntitlement, $result);        
    }
    
    public function testDeleteLeaveEntitlements() {
        $ids = array(2, 33, 12);

        $leaveEntitlement1 = new LeaveEntitlement();
        $leaveEntitlement1->fromArray(array('id' => 2, 'emp_number' => 1, 'no_of_days' => 3, 'days_used' => 0));
        
        $leaveEntitlement2 = new LeaveEntitlement();
        $leaveEntitlement2->fromArray(array('id' => 33, 'emp_number' => 1, 'no_of_days' => 3, 'days_used' => 0));
        
        $leaveEntitlement3 = new LeaveEntitlement();
        $leaveEntitlement3->fromArray(array('id' => 12, 'emp_number' => 1, 'no_of_days' => 3, 'days_used' => 0));   
        
        $leaveEntitlements = array($leaveEntitlement1, $leaveEntitlement2, $leaveEntitlement3);
        
        
        $mockDao = $this->getMock('LeaveEntitlementDao', array('deleteLeaveEntitlements', 'searchLeaveEntitlements'));
        $mockDao->expects($this->once())
                    ->method('deleteLeaveEntitlements')
                    ->with($ids)
                    ->will($this->returnValue(count($ids)));
        
        $mockDao->expects($this->once())
                    ->method('searchLeaveEntitlements')
                    ->will($this->returnValue($leaveEntitlements));
        

        $this->service->setLeaveEntitlementDao($mockDao);
        $result = $this->service->deleteLeaveEntitlements($ids);      
        
        $this->assertEquals(count($ids), $result);            
    }
    
    public function testGetLeaveEntitlement() {
        $id = 2;
        $leaveEntitlements = TestDataService::loadObjectList('LeaveEntitlement', $this->fixture, 'LeaveEntitlement');
        $leaveEntitlement = $leaveEntitlements[0];

        $mockDao = $this->getMock('LeaveEntitlementDao', array('getLeaveEntitlement'));
        $mockDao->expects($this->once())
                ->method('getLeaveEntitlement')
                ->with($id)
                ->will($this->returnValue($leaveEntitlement));

        $this->service->setLeaveEntitlementDao($mockDao);
        $result = $this->service->getLeaveEntitlement($id);

        $this->assertEquals($leaveEntitlement, $result);
    }

    public function testGetMatchingEntitlements() {

        $leaveEntitlements = TestDataService::loadObjectList('LeaveEntitlement', $this->fixture, 'LeaveEntitlement');
        $leaveEntitlement = $leaveEntitlements[0];
        $empNumber = $leaveEntitlement->getEmpNumber();
        $leaveTypeId = $leaveEntitlement->getLeaveTypeId();
        $fromDate = $leaveEntitlement->getFromDate();
        $toDate = $leaveEntitlement->getToDate();
        
        $mockDao = $this->getMock('LeaveEntitlementDao', array('getMatchingEntitlements'));
        $mockDao->expects($this->once())
                ->method('getMatchingEntitlements')
                ->with($empNumber, $leaveTypeId, $fromDate, $toDate)
                ->will($this->returnValue($leaveEntitlement));

        $this->service->setLeaveEntitlementDao($mockDao);
        $result = $this->service->getMatchingEntitlements($empNumber, $leaveTypeId, $fromDate, $toDate);

        $this->assertEquals($leaveEntitlement, $result);        
    }
    
}
