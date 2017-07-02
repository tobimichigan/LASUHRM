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
 * Leave Type rule service
 * @group Leave 
 */
 class LeaveTypeServiceTest extends PHPUnit_Framework_TestCase{
    
    private $leaveTypeService;
    protected $fixture;

    /**
     * PHPUnit setup function
     */
    public function setup() {
            
        $this->leaveTypeService =   new LeaveTypeService();
        $this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmLeavePlugin/test/fixtures/LeaveTypeService.yml';
            
    }
    
    /* Tests for getLeaveTypeList() */

    public function testGetLeaveTypeList() {

        $leaveTypeList = TestDataService::loadObjectList('LeaveType', $this->fixture, 'set1');

        $leaveTypeDao = $this->getMock('LeaveTypeDao', array('getLeaveTypeList'));
        $leaveTypeDao->expects($this->once())
                     ->method('getLeaveTypeList')
                     ->will($this->returnValue($leaveTypeList));

        $this->leaveTypeService->setLeaveTypeDao($leaveTypeDao);
        $returnedLeaveTypeList = $this->leaveTypeService->getLeaveTypeList();
        
        $this->assertEquals(5, count($returnedLeaveTypeList));
        
        foreach ($returnedLeaveTypeList as $leaveType) {
            $this->assertTrue($leaveType instanceof LeaveType);
        }

    }

    public function testGetLeaveTypeListWithOperationalCountryId() {

        $leaveTypeList = TestDataService::loadObjectList('LeaveType', $this->fixture, 'set1');

        $leaveTypeDao = $this->getMock('LeaveTypeDao', array('getLeaveTypeList'));
        $leaveTypeDao->expects($this->once())
                     ->method('getLeaveTypeList')
                     ->with($this->equalTo(2))
                     ->will($this->returnValue($leaveTypeList));

        $this->leaveTypeService->setLeaveTypeDao($leaveTypeDao);
        $returnedLeaveTypeList = $this->leaveTypeService->getLeaveTypeList(2);
        
        $this->assertEquals(5, count($returnedLeaveTypeList));
        
        foreach ($returnedLeaveTypeList as $leaveType) {
            $this->assertTrue($leaveType instanceof LeaveType);
        }            
    }
    
    /* Tests for saveLeaveType() */

    public function testSaveLeaveType() {

        $leaveTypeList = TestDataService::loadObjectList('LeaveType', $this->fixture, 'set1');
        $leaveType = $leaveTypeList[0];

        $leaveTypeDao = $this->getMock('LeaveTypeDao', array('saveLeaveType'));
        $leaveTypeDao->expects($this->once())
                     ->method('saveLeaveType')
                     ->with($leaveType)
                     ->will($this->returnValue(true));

        $this->leaveTypeService->setLeaveTypeDao($leaveTypeDao);

        $this->assertTrue($this->leaveTypeService->saveLeaveType($leaveType));

    }

    /* Tests for readLeaveType */

    public function testReadLeaveType() {

        $leaveTypeList = TestDataService::loadObjectList('LeaveType', $this->fixture, 'set1');
        $leaveType = $leaveTypeList[0];

        $leaveTypeDao = $this->getMock('LeaveTypeDao', array('readLeaveType'));
        $leaveTypeDao->expects($this->once())
                     ->method('readLeaveType')
                     ->with('LTY001')
                     ->will($this->returnValue($leaveType));

        $this->leaveTypeService->setLeaveTypeDao($leaveTypeDao);

        $leaveType = $this->leaveTypeService->readLeaveType('LTY001');

        $this->assertTrue($leaveType instanceof LeaveType);

    }


    
 }