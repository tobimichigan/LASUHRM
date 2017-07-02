<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Description of DataGroupDaoTest
 * @group Core
 */
class DataGroupDaoTest extends PHPUnit_Framework_TestCase {
    
    /** @property ScreenPermissionDao $dao */
    private $dao;
    
    /**
     * Set up method
     */
    protected function setUp() {        
        $this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmCorePlugin/test/fixtures/DataGroupDao.yml';
        TestDataService::truncateSpecificTables(array('SystemUser'));
        TestDataService::populate($this->fixture);
                
        $this->dao = new DataGroupDao();
    }
    
    
    public function testGetDataGroupPermission(){ 
        $permissions = $this->dao->getDataGroupPermission('pim_1',1);
        $this->assertEquals(1, $permissions->count());
        $this->assertEquals(1,$permissions[0]->getCanRead());
    
    }
    
    public function testGetDataGroups(){
        $this->assertEquals(4,sizeof($this->dao->getDataGroups()));    
    }    
    
    public function testGetDataGroupsNoneDefined(){
        $pdo = Doctrine_Manager::connection()->getDbh();
        $pdo->exec('DELETE FROM ohrm_data_group');
        $this->assertEquals(0, sizeof($this->dao->getDataGroups()));    
    }    
    

    public function testGetDataGroup() {
        $dataGroup1 = $this->dao->getDataGroup('pim_1');
        $this->assertTrue($dataGroup1 instanceof DataGroup);
        $this->assertEquals(1, $dataGroup1->getId());
        
        $dataGroup2 = $this->dao->getDataGroup('pim_2');
        $this->assertTrue($dataGroup2 instanceof DataGroup);
        $this->assertEquals(2, $dataGroup2->getId());
        
    }
    
    public function testGetDataGroupInvalid() {
        $dataGroup = $this->dao->getDataGroup('xyz_not_exist');
        $this->assertTrue($dataGroup === false);
    }
}


