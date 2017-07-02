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
class RecruitmentAttachmentDaoTest extends PHPUnit_Framework_TestCase {

    private $recruitmentAttachmentDao;
    protected $fixture;

    /**
     * Set up method
     */
    protected function setUp() {

        $this->recruitmentAttachmentDao = new RecruitmentAttachmentDao();
        $this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmRecruitmentPlugin/test/fixtures/CandidateDao.yml';
        TestDataService::populate($this->fixture);
    }

    /**
     * 
     */
    public function testSaveVacancyAttachment() {

        $file = tmpfile();
        fwrite($file, "writing to tempfile");
        fseek($file, 0);
        $resume = new JobVacancyAttachment();
        $resume->id = 5;
        $resume->vacancyId = 1;
        $resume->fileName = "abc.txt";
        $resume->fileType = ".txt";
        $resume->fileSize = '512';
        $this->recruitmentAttachmentDao->saveVacancyAttachment($resume);

        $resume = TestDataService::fetchObject('JobVacancyAttachment', 5);
        $this->assertNotNull($resume->getId());
        $this->assertEquals($resume->getFileName(), "abc.txt");
        $this->assertEquals($resume->getFileType(), ".txt");
        $this->assertEquals($resume->getFileSize(), '512');
    }

    /**
     *
     */
    public function testSaveVacancyAttachmentForNullId() {

        TestDataService::truncateSpecificTables(array('JobVacancyAttachment'));

        $file = tmpfile();
        fwrite($file, "writing to tempfile");
        fseek($file, 0);
        $resume = new JobVacancyAttachment();
        $resume->setId(null);
        $resume->setVacancyId(1);
        $resume->setFileType('.txt');
        $resume->setFileName('xyz.txt');
        $resume->setFileSize('512');
        $return = $this->recruitmentAttachmentDao->saveVacancyAttachment($resume);
        $this->assertTrue($return);
    }

    /**
     *
     */
    public function testSaveCandidateAttachment() {

        $file = tmpfile();
        fwrite($file, "writing to tempfile");
        fseek($file, 0);
        $resume = new JobCandidateAttachment();
        $resume->id = 5;
        $resume->candidateId = 1;
        $resume->fileName = "abc.txt";
        $resume->fileType = ".txt";
        $resume->fileSize = '512';
        $this->recruitmentAttachmentDao->saveCandidateAttachment($resume);

        $resume = TestDataService::fetchObject('JobCandidateAttachment', 5);
        $this->assertNotNull($resume->getId());
        $this->assertEquals($resume->getFileName(), "abc.txt");
        $this->assertEquals($resume->getFileType(), ".txt");
        $this->assertEquals($resume->getFileSize(), '512');
    }

    /**
     * 
     */
    public function testSaveCandidateAttachmentForNullId() {
        TestDataService::truncateSpecificTables(array('JobCandidateAttachment'));

        $file = tmpfile();
        fwrite($file, "writing to tempfile");
        fseek($file, 0);
        $resume = new JobCandidateAttachment();
        $resume->setId(null);
        $resume->setCandidateId(1);
        $resume->setFileName('xyz.txt');
        $resume->setFileType('.txt');
        $resume->setFileSize('512');
        $return = $this->recruitmentAttachmentDao->saveCandidateAttachment($resume);
        $this->assertTrue($return);
    }

    /**
     * Testing getVacancyList
     */
    public function testGetVacancyAttachments() {

        $vacancyId = 1;
        $vacancyList = $this->recruitmentAttachmentDao->getVacancyAttachments($vacancyId);
        $this->assertTrue($vacancyList[0] instanceof JobVacancyAttachment);
        $this->assertEquals(sizeof($vacancyList), 2);
    }

    public function testGetInterviewAttachments() {

        $interviewId = 1;
        $attachments = $this->recruitmentAttachmentDao->getInterviewAttachments($interviewId);
        $this->assertTrue($attachments[0] instanceof JobInterviewAttachment);
        $this->assertEquals(sizeof($attachments), 2);
    }

    public function testGetVacancyAttachment() {

        $attachId = 1;
        $attachment = $this->recruitmentAttachmentDao->getVacancyAttachment($attachId);
        $this->assertTrue($attachment instanceof JobVacancyAttachment);
        $this->assertEquals($attachment->fileName, 'xyz.txt');
        $this->assertEquals($attachment->fileSize, 512);
    }

    public function testGetInterviewAttachment() {

        $attachId = 1;
        $attachment = $this->recruitmentAttachmentDao->getInterviewAttachment($attachId);
        $this->assertTrue($attachment instanceof JobInterviewAttachment);
        $this->assertEquals($attachment->fileName, 'resume.pdf');
        $this->assertEquals($attachment->fileSize, 512);
    }

    public function testGetCandidateAttachment() {

        $attachId = 1;
        $attachment = $this->recruitmentAttachmentDao->getCandidateAttachment($attachId);
        $this->assertTrue($attachment instanceof JobCandidateAttachment);
        $this->assertEquals($attachment->fileName, 'xyz.txt');
        $this->assertEquals($attachment->fileSize, 512);
    }

}

