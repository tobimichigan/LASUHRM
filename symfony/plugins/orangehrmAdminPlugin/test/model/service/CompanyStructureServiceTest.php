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
class CompanyStructureServiceTest extends PHPUnit_Framework_TestCase {

    private $companyStructureService;
    protected $fixture;

    /**
     * Set up method
     */
    protected function setUp() {
        $this->companyStructureService = new CompanyStructureService();
        $this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmAdminPlugin/test/fixtures/CompanyStructureDao.yml';
        TestDataService::populate($this->fixture);
    }

    public function testGetSubunitById() {

        $subunit = TestDataService::fetchObject('Subunit', 1);

        $compStructureDao = $this->getMock('CompanyStructureDao');

        $compStructureDao->expects($this->once())
                ->method('getSubunitById')
                ->with($subunit->getId())
                ->will($this->returnValue($subunit));

        $this->companyStructureService->setCompanyStructureDao($compStructureDao);
        $result = $this->companyStructureService->getSubunitById($subunit->getId());
        $this->assertEquals($subunit, $result);
    }

    public function testSaveSubunit() {

        $subunit = new Subunit();
        $subunit->setName("subunit name");

        $compStructureDao = $this->getMock('CompanyStructureDao');

        $compStructureDao->expects($this->once())
                ->method('saveSubunit')
                ->with($subunit)
                ->will($this->returnValue(true));

        $this->companyStructureService->setCompanyStructureDao($compStructureDao);
        $result = $this->companyStructureService->saveSubunit($subunit);
        $this->assertTrue($result);
    }
    
    public function testAddSubunit() {

        $subunit = TestDataService::fetchObject('Subunit', 1);

        $parentSubunit = new Subunit();
        $parentSubunit->setName("new subunit");

        $compStructureDao = $this->getMock('CompanyStructureDao');

        $compStructureDao->expects($this->once())
                ->method('addSubunit')
                ->with($parentSubunit, $subunit)
                ->will($this->returnValue(true));

        $this->companyStructureService->setCompanyStructureDao($compStructureDao);
        $result = $this->companyStructureService->addSubunit($parentSubunit, $subunit);
        $this->assertTrue($result);
    }

    public function testDeleteSubunit() {

        $subunit = TestDataService::fetchObject('Subunit', 1);

        $parentSubunit = new Subunit();
        $parentSubunit->setName("new subunit");

        $compStructureDao = $this->getMock('CompanyStructureDao');

        $compStructureDao->expects($this->once())
                ->method('deleteSubunit')
                ->with($subunit)
                ->will($this->returnValue(true));

        $this->companyStructureService->setCompanyStructureDao($compStructureDao);
        $result = $this->companyStructureService->deleteSubunit($subunit);
        $this->assertTrue($result);
    }
    
    public function testSetOrganizationName() {

        $name = "Company Name";
        $returnvalue = 1;

        $compStructureDao = $this->getMock('CompanyStructureDao');

        $compStructureDao->expects($this->once())
                ->method('setOrganizationName')
                ->with($name)
                ->will($this->returnValue($returnvalue));

        $this->companyStructureService->setCompanyStructureDao($compStructureDao);
        $result = $this->companyStructureService->setOrganizationName($name);
        $this->assertEquals($returnvalue, $result);
    }
    
    public function testGetSubunitTreeObject() {

        $treeObject = Doctrine::getTable('Subunit')->getTree();

        $compStructureDao = $this->getMock('CompanyStructureDao');

        $compStructureDao->expects($this->once())
                ->method('getSubunitTreeObject')
                ->will($this->returnValue($treeObject));

        $this->companyStructureService->setCompanyStructureDao($compStructureDao);
        $result = $this->companyStructureService->getSubunitTreeObject();
        $this->assertEquals($treeObject, $result);
    }

}

