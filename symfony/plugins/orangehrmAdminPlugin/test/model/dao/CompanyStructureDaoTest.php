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
class CompanyStructureDaoTest extends PHPUnit_Framework_TestCase {

    private $companyStructureDao;
    protected $fixture;

    /**
     * Set up method
     */
    protected function setUp() {

        $this->companyStructureDao = new CompanyStructureDao();
        $this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmAdminPlugin/test/fixtures/CompanyStructureDao.yml';
        TestDataService::populate($this->fixture);
    }

    public function testSetOrganizationName() {
        $this->assertEquals($this->companyStructureDao->setOrganizationName("OrangeHRM"), 1);
    }

    public function testGetSubunitById() {
        $savedSubunit = $this->companyStructureDao->getSubunitById(1);
        $this->assertTrue($savedSubunit instanceof Subunit);
        $this->assertEquals($savedSubunit->getId(), 1);
        $this->assertEquals($savedSubunit->getName(), 'Organization');
    }

    public function testSaveSubunit() {
        $subunit = new Subunit();
        $subunit->setName("Open Source");
        $subunit->setDescription("Handles OrangeHRM product");
        $this->assertTrue($this->companyStructureDao->saveSubunit($subunit));
        $this->assertNotNull($subunit->getId());
    }

    public function testDeleteSubunit() {
        $subunitList = TestDataService::loadObjectList('Subunit', $this->fixture, 'Subunit');
        $subunit = $subunitList[2];
        $this->assertTrue($this->companyStructureDao->deleteSubunit($subunit));
        $result = TestDataService::fetchObject('Subunit', 3);
        $this->assertFalse($result);
    }

    public function testAddSubunit() {
        $subunitList = TestDataService::loadObjectList('Subunit', $this->fixture, 'Subunit');
        $subunit = $subunitList[2];
        $parentSubunit = new Subunit();
        $parentSubunit->setName("New Department");
        $this->assertTrue($this->companyStructureDao->addSubunit($parentSubunit, $subunit));
        $this->assertNotNull($parentSubunit->getId());
    }

    public function testGetSubunitTreeObject() {
        $treeObject = $this->companyStructureDao->getSubunitTreeObject();
        $tree = $treeObject->fetchTree();
        $this->assertNotNull($tree[0]->getLevel());
        $this->assertNotNull($tree[0]->getRgt());
        $this->assertNotNull($tree[0]->getLft());
    }

}

