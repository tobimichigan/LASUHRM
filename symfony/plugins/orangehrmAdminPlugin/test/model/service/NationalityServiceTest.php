<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
require_once sfConfig::get('sf_test_dir') . '/util/TestDataService.php';

/**
 *  @group Admin
 */
class NationalityServiceTest extends PHPUnit_Framework_TestCase {

    private $nationalityService;
    private $fixture;

    /**
     * Set up method
     */
    protected function setUp() {
        $this->nationalityService = new NationalityService();
        $this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmAdminPlugin/test/fixtures/NationalityDao.yml';
        TestDataService::populate($this->fixture);
    }

    public function testGetNationalityList() {

        $nationalityList = TestDataService::loadObjectList('Nationality', $this->fixture, 'Nationality');

        $nationalityDao = $this->getMock('NationalityDao');
        $nationalityDao->expects($this->once())
                ->method('getNationalityList')
                ->will($this->returnValue($nationalityList));

        $this->nationalityService->setNationalityDao($nationalityDao);

        $result = $this->nationalityService->getNationalityList();
        $this->assertEquals($result, $nationalityList);
    }

    public function testGetNationalityById() {

        $nationalityList = TestDataService::loadObjectList('Nationality', $this->fixture, 'Nationality');

        $nationalityDao = $this->getMock('NationalityDao');
        $nationalityDao->expects($this->once())
                ->method('getNationalityById')
                ->with(1)
                ->will($this->returnValue($nationalityList[0]));

        $this->nationalityService->setNationalityDao($nationalityDao);

        $result = $this->nationalityService->getNationalityById(1);
        $this->assertEquals($result, $nationalityList[0]);
    }

    public function testDeleteNationalities() {

        $nationalityList = array(1, 2, 3);

        $nationalityDao = $this->getMock('NationalityDao');
        $nationalityDao->expects($this->once())
                ->method('deleteNationalities')
                ->with($nationalityList)
                ->will($this->returnValue(3));

        $this->nationalityService->setNationalityDao($nationalityDao);

        $result = $this->nationalityService->deleteNationalities($nationalityList);
        $this->assertEquals($result, 3);
    }

}

