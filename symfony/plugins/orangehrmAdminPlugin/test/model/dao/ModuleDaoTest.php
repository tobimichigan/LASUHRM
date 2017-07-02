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
class ModuleDaoTest extends PHPUnit_Framework_TestCase {

	private $moduleDao;
	protected $fixture;

	/**
	 * Set up method
	 */
	protected function setUp() {

		$this->moduleDao = new ModuleDao();
		$this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmAdminPlugin/test/fixtures/ModuleDao.yml';
		TestDataService::populate($this->fixture);
        
	}
    
    public function testGetDisabledModuleList() {
        
        $disabledModuleList = $this->moduleDao->getDisabledModuleList();
        
        $this->assertEquals(1, count($disabledModuleList));
        $this->assertTrue($disabledModuleList[0] instanceof Module);
        $this->assertEquals('benefits', $disabledModuleList[0]->getName());
        
    }

    public function testUpdateModuleStatusWithChange() {
        
        $moduleList = array('leave', 'time');
        $status = Module::DISABLED;
        $result = $this->moduleDao->updateModuleStatus($moduleList, $status);
        
        $this->assertEquals(2, $result);
        
        $module = TestDataService::fetchObject('Module', 3);
        $this->assertEquals(Module::DISABLED, $module->getStatus());

        $module = TestDataService::fetchObject('Module', 4);
        $this->assertEquals(Module::DISABLED, $module->getStatus());
        
    }

    public function testUpdateModuleStatusWithNoChange() {
        
        $moduleList = array('leave', 'time');
        $status = Module::ENABLED;
        $result = $this->moduleDao->updateModuleStatus($moduleList, $status);
        
        $this->assertEquals(0, $result);
        
        $module = TestDataService::fetchObject('Module', 3);
        $this->assertEquals(Module::ENABLED, $module->getStatus());

        $module = TestDataService::fetchObject('Module', 4);
        $this->assertEquals(Module::ENABLED, $module->getStatus());
        
    }
    
    
}
