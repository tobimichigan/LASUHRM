<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Description of ScreenPermissionDaoTest
 * @group Core
 */
class ScreenPermissionDaoTest  extends PHPUnit_Framework_TestCase {
    
    /** @property ScreenPermissionDao $dao */
    private $dao;
    
    /**
     * Set up method
     */
    protected function setUp() {        
        $this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmCorePlugin/test/fixtures/ScreenPermissionDao.yml';
        TestDataService::truncateSpecificTables(array('SystemUser'));
        TestDataService::populate($this->fixture);
                
        $this->dao = new ScreenPermissionDao();
    }
    
    public function testGetScreenPermission() {
        $permissions = $this->dao->getScreenPermissions('pim', 'viewEmployeeList', array('Admin'));
        $this->assertNotNull($permissions);
        $this->assertEquals(1, count($permissions));
        $this->verifyPermissions($permissions[0], true, true, true, true);
       
        
        $permissions = $this->dao->getScreenPermissions('pim', 'viewEmployeeList', array('ESS'));
        $this->assertNotNull($permissions);
        $this->assertEquals(1, count($permissions));
        $this->verifyPermissions($permissions[0], false, false, false, false);
        
        $permissions = $this->dao->getScreenPermissions('pim', 'viewEmployeeList', array('Supervisor'));
        $this->assertNotNull($permissions);
        $this->assertEquals(1, count($permissions));
        $this->verifyPermissions($permissions[0], true, false, true, false);
        
        $permissions = $this->dao->getScreenPermissions('pim', 'viewEmployeeList', array('Admin', 'Supervisor', 'ESS'));
        $this->assertNotNull($permissions);
        $this->assertEquals(3, count($permissions));
        
        foreach($permissions as $permission) {
            $roleId = $permission->getUserRoleId();
            if ($roleId == 1) {
                // Admin
                $this->verifyPermissions($permission, true, true, true, true);
            } else if ($roleId == 2) {
                // Supervisor
                $this->verifyPermissions($permission, false, false, false, false);            
            } else if ($roleId == 3) {
                // ESS
                $this->verifyPermissions($permission, true, false, true, false);    
            } else {
                $this->fail("Unexpected roleId=" . $roleId);
            }
        }
        
        $permissions = $this->dao->getScreenPermissions('pim', 'viewEmployeeListNoneExisting', array('Admin', 'Supervisor', 'ESS'));
        $this->assertTrue($permissions instanceof Doctrine_Collection);
        $this->assertEquals(0, count($permissions));
        
    }
    
    protected function verifyPermissions($permission, $read, $create, $update, $delete) {
        $this->assertEquals($read, $permission->can_read);
        $this->assertEquals($create, $permission->can_create);
        $this->assertEquals($update, $permission->can_update);
        $this->assertEquals($delete, $permission->can_delete);        
    }
}

