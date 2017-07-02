<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Description of ScreenDaoTest
 * @group Core
 */
class ScreenDaoTest extends PHPUnit_Framework_TestCase {
    
    /** @property ScreenPermissionDao $dao */
    private $dao;
    
    /**
     * Set up method
     */
    protected function setUp() {        
        $this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmCorePlugin/test/fixtures/ScreenDao.yml';
        TestDataService::truncateSpecificTables(array('SystemUser'));
        TestDataService::populate($this->fixture);
                
        $this->dao = new ScreenDao();
    }
    
    public function testGetScreen() {
        
        $screen = $this->dao->getScreen('pim', 'viewEmployeeList');
        $this->assertNotNull($screen);
        $this->assertEquals(1, $screen->getId());
        $this->assertEquals('employee list', $screen->getName());
        $this->assertEquals(3, $screen->getModuleId());
        $this->assertEquals('viewEmployeeList', $screen->getActionUrl()); 
        
        // non existing action
        $screen = $this->dao->getScreen('pim', 'viewNoneNone');
        $this->assertFalse($screen);               
    }

}


