<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Description of DataGroupServiceTest
 * @group Core
 */
class DataGroupServiceTest extends PHPUnit_Framework_TestCase {

    private $service;
    
    /**
     * Set up method
     */
    protected function setUp() {
        $this->service = new DataGroupService();        
    }
    
    public function testGetDataGroupPermission() {
        $dataGroupPermission = new DataGroupPermission();
        $dataGroupPermission->fromArray(array('id' => 2, 'user_role_id' => 1, 'data_group_id' => 1,
            'can_read' => 1, 'can_create' => 1, 'can_update' => 1, 'can_delete' => 1, 'self' => 1));

        $dao = $this->getMock('DataGroupDao', array('getDataGroupPermission'));
        $dao->expects($this->once())
                    ->method('getDataGroupPermission')
                    ->with('test', 2, true)
                    ->will($this->returnValue($dataGroupPermission));
        
        $this->service->setDao($dao);
        $result = $this->service->getDataGroupPermission('test', 2, true);
        $this->assertEquals($dataGroupPermission, $result);
        
    }
    
    public function testGetDataGroups() {
        $expected = new Doctrine_Collection('DataGroup');        

        $dao = $this->getMock('DataGroupDao', array('getDataGroups'));
        $dao->expects($this->once())
                    ->method('getDataGroups')
                    ->will($this->returnValue($expected));
        
        $this->service->setDao($dao);
        $result = $this->service->getDataGroups();
        $this->assertEquals($expected, $result);
    }    
    
    public function testGetDataGroup() {
        $expected = new DataGroup();
        $expected->fromArray(array('id' => 2, 'can_read' => 1, 'can_create' => 1, 'can_update' => 1, 'can_delete' => 1));

        $dao = $this->getMock('DataGroupDao', array('getDataGroup'));
        $dao->expects($this->once())
                    ->method('getDataGroup')
                    ->with('xyz')
                    ->will($this->returnValue($expected));
        
        $this->service->setDao($dao);
        $result = $this->service->getDataGroup('xyz');
        $this->assertEquals($expected, $result);        
    }

}
