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
class JobTitleDaoTest extends PHPUnit_Framework_TestCase {

    private $jobTitleDao;
    protected $fixture;

    /**
     * Set up method
     */
    protected function setUp() {

        $this->jobTitleDao = new JobTitleDao();
        $this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmAdminPlugin/test/fixtures/JobTitleDao.yml';
        TestDataService::populate($this->fixture);
    }

    public function testGetJobTitleList() {

        $result = $this->jobTitleDao->getJobTitleList();
        $this->assertEquals(count($result), 3);
    }

    public function testGetJobTitleListWithInactiveJobTitles() {

        $result = $this->jobTitleDao->getJobTitleList("", "", false);
        $this->assertEquals(count($result), 4);
    }

    public function testDeleteJobTitle() {
        
        $toBedeletedIds = array(3, 2);
        $result = $this->jobTitleDao->deleteJobTitle($toBedeletedIds);
        $this->assertEquals($result, 2);
    }

    public function testGetJobTitleById() {

        $result = $this->jobTitleDao->getJobTitleById(1);
        $this->assertTrue($result  instanceof JobTitle);
        $this->assertEquals('Software Architect', $result->getJobTitleName());
    }

//    public function testGetJobSpecAttachmentById() {
//
//        $result = $this->jobTitleDao->getJobSpecAttachmentById(1);
//        $this->assertTrue($result  instanceof JobSpecificationAttachment);
//        $this->assertEquals('Software architect spec', $result->getFileName());
//    }

}

