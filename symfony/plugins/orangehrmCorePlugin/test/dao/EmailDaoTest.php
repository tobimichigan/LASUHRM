<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Description of EmailDaoTest
 */
class EmailDaoTest extends PHPUnit_Framework_TestCase {

    private $emailDao;

    /**
     * Set up method
     */
    protected function setUp() {
        $this->emailDao = new EmailDao();
        $this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmCorePlugin/test/fixtures/EmailDao.yml';
        TestDataService::populate($this->fixture);
    }

    public function testGetEmailByName() {
        
        $name = 'leave.cancel';
        $email = $this->emailDao->getEmailByName($name);
        
        $this->assertTrue($email instanceof Email);
        $this->assertEquals(4, $email->getId());
    }
    
    public function testGetEmailByNameNonExisting() {
        
        $name = 'leave.test';
        $email = $this->emailDao->getEmailByName($name);
        
        $this->assertFalse($email);
    }    
    
    public function testGetEmailTemplateMatchesSubscriber() {
        $name = 'leave.apply';
        $templateMatches = $this->emailDao->getEmailTemplateMatches($name, 'en_US', 'subscriber', NULL);
        $this->assertEquals(1, count($templateMatches));
        $this->assertEquals(2, $templateMatches[0]->getId());        
    }
    
    public function testGetEmailTemplateMatchesNonExistingLocale() {
        $name = 'leave.apply';
        $templateMatches = $this->emailDao->getEmailTemplateMatches($name, 'en_GB', 'subscriber', NULL);
        $this->assertEquals(0, count($templateMatches));    
    }    
    
    public function testGetEmailTemplateMatchesNotExistingRole() {
        $name = 'leave.apply';
        $templateMatches = $this->emailDao->getEmailTemplateMatches($name, 'en_US', 'ess', NULL);
        $this->assertEquals(0, count($templateMatches));    
    }    
    
    public function testGetEmailTemplateMatchRoleAndPerformer() {
        $name = 'leave.reject';
        $templateMatches = $this->emailDao->getEmailTemplateMatches($name, 'en_US', 'ess', 'supervisor');
        $this->assertEquals(1, count($templateMatches));             
    }    
    
    public function testGetEmailTemplateMatchesNotExistingPerformer() {
        $name = 'leave.reject';
        $templateMatches = $this->emailDao->getEmailTemplateMatches($name, 'en_US', 'ess', 'ess');
        $this->assertEquals(0, count($templateMatches));            
    }  
    
    public function testGetEmailTemplateMatchesNullIfPerformerNotAvailable() {
        $name = 'leave.apply';
        $templateMatches = $this->emailDao->getEmailTemplateMatches($name, 'en_US', 'subscriber', 'supervisor');
        $this->assertEquals(1, count($templateMatches));
        $this->assertEquals(2, $templateMatches[0]->getId());             
    }      
    public function testGetEmailTemplateMatchesNullIfRoleNotAvailable() {
        $name = 'leave.cancel';
        $templateMatches = $this->emailDao->getEmailTemplateMatches($name, 'en_US', 'subscriber', 'supervisor');
        $this->assertEquals(1, count($templateMatches));
        $this->assertEquals(11, $templateMatches[0]->getId());             
    }  
    public function testGetEmailTemplateMatchesNullAndPerformer() {
        $name = 'leave.cancel';
        $templateMatches = $this->emailDao->getEmailTemplateMatches($name, 'en_US', 'subscriber', 'ess');
        $this->assertEquals(2, count($templateMatches));
        
        $expectedIds = array(9, 11);
        $this->verifyTemplateIds($expectedIds, $templateMatches);
    }   
    
    protected function verifyTemplateIds($expectedIds, $templateMatches) {

        foreach($templateMatches as $template) {
            $key = array_search($template->getId(), $expectedIds);
            $this->assertTrue($key !== false, $template->getId() . ' not found');
            unset($expectedIds[$key]);
        }        
        
        $this->assertEquals(0, count($expectedIds));
    }
}