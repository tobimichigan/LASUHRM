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
class JobTitleServiceTest extends PHPUnit_Framework_TestCase {

    private $JobTitleService;
    protected $fixture;

    /**
     * Set up method
     */
    protected function setUp() {
        $this->JobTitleService = new JobTitleService();
        $this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmAdminPlugin/test/fixtures/JobTitleDao.yml';
        TestDataService::populate($this->fixture);
    }

    public function testGetJobTitleList() {
        
        $jobTitleList = TestDataService::loadObjectList('JobTitle', $this->fixture, 'JobTitle');

        $jobTitleDao = $this->getMock('JobTitleDao');

        $jobTitleDao->expects($this->once())
                ->method('getJobTitleList')
                ->with("", "", "")
                ->will($this->returnValue($jobTitleList));

        $this->JobTitleService->setJobTitleDao($jobTitleDao);
        $result = $this->JobTitleService->getJobTitleList("", "", "");
        $this->assertEquals($jobTitleList, $result);
    }

    public function testDeleteJobTitle() {

        $toBeDeletedJobTitleIds = array(1, 2);

        $jobTitleDao = $this->getMock('JobTitleDao');

        $jobTitleDao->expects($this->once())
                ->method('deleteJobTitle')
                ->with($toBeDeletedJobTitleIds)
                ->will($this->returnValue(2));

        $this->JobTitleService->setJobTitleDao($jobTitleDao);
        $result = $this->JobTitleService->deleteJobTitle($toBeDeletedJobTitleIds);
        $this->assertEquals(2, $result);
    }

    public function testGetJobTitleById() {

        $jobTitleList = TestDataService::loadObjectList('JobTitle', $this->fixture, 'JobTitle');
        $jobTitleDao = $this->getMock('JobTitleDao');

        $jobTitleDao->expects($this->once())
                ->method('getJobTitleById')
                ->with(1)
                ->will($this->returnValue($jobTitleList[0]));

        $this->JobTitleService->setJobTitleDao($jobTitleDao);
        $result = $this->JobTitleService->getJobTitleById(1);
        $this->assertEquals($jobTitleList[0], $result);
    }

}

