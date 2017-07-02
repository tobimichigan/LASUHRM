<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
require_once sfConfig::get('sf_test_dir') . '/util/TestDataService.php';

class EmailNotificationDaoTest extends PHPUnit_Framework_TestCase {

    private $emailNotificationDao;
    protected $fixture;

    /**
     * Set up method
     */
    protected function setUp() {

        $this->emailNotificationDao = new EmailNotificationDao();
        $this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmAdminPlugin/test/fixtures/EmailNotificationDao.yml';
        TestDataService::populate($this->fixture);
    }

    public function testGetEmailNotificationList() {
        $result = $this->emailNotificationDao->getEmailNotificationList();
        $this->assertEquals(count($result), 3);
    }

    public function testUpdateEmailNotification(){
         $result = $this->emailNotificationDao->updateEmailNotification(array(1,2));
         $this->assertTrue($result);
    }

    public function testGetEnabledEmailNotificationIdList(){
        $result = $this->emailNotificationDao->getEnabledEmailNotificationIdList();
        $this->assertEquals(count($result), 1);
    }

    public function testGetSubscribersByNotificationId(){
        $result = $this->emailNotificationDao->getSubscribersByNotificationId(1);
        $this->assertEquals(count($result), 2);
    }

    public function testGetSubscriberById(){
        $result = $this->emailNotificationDao->getSubscriberById(1);
        $this->assertEquals($result->getName(), 'Kayla Abbey');
    }

    public function testDeleteSubscribers(){
       $result = $this->emailNotificationDao->deleteSubscribers(array(1, 2, 3));
        $this->assertEquals($result, 3);
    }
    
    public function testGetEmailNotification() {
        $notification = $this->emailNotificationDao->getEmailNotification(1);
        $this->assertTrue($notification instanceof EmailNotification);
        $this->assertEquals('Leave Applications', $notification->getName());
        
        $notification = $this->emailNotificationDao->getEmailNotification(3);
        $this->assertTrue($notification instanceof EmailNotification);
        $this->assertEquals('Leave Approvals', $notification->getName());        
        
        $notification = $this->emailNotificationDao->getEmailNotification(113);
        $this->assertTrue($notification === false);
    }

}

