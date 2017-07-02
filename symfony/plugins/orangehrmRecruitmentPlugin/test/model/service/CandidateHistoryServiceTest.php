<?php


/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
require_once sfConfig::get('sf_test_dir') . '/util/TestDataService.php';

/**
 * @group Recruitment
 */
class CandidateHistoryServiceTest extends PHPUnit_Framework_TestCase {

    private $candidateHistoryService;
    protected $fixture;

    /**
     * Set up method
     */
    protected function setUp() {

        $this->candidateHistoryService = new CandidateHistoryService();
        $this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmRecruitmentPlugin/test/fixtures/CandidateDao.yml';
        TestDataService::populate($this->fixture);
    }
    
    /**
     * Testing getCandidateHistoryList for return type
     */
    public function testGetCandidateHistoryListForCorrectReturnObject() {
        
        $allCadidateHistoryList = TestDataService::loadObjectList('CandidateHistory', $this->fixture, 'CandidateHistory');
        
        $result = $this->candidateHistoryService->getCandidateHistoryList($allCadidateHistoryList);
        
        $this->assertTrue($result[0] instanceof CandidateHistoryDto);
        
    }
    
    /**
     * Testing getCandidateHistoryList for correct number of results
     */
    public function testGetCandidateHistoryListForCorrectNumberOfResults() {
        
        $allCadidateHistoryList = TestDataService::loadObjectList('CandidateHistory', $this->fixture, 'CandidateHistory');
        
        $result = $this->candidateHistoryService->getCandidateHistoryList($allCadidateHistoryList);
        
        $this->assertEquals(15, count($result));
        
    }
    
}