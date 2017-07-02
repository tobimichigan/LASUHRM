<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class EmailNotificationService extends BaseService {

    private $emailNotificationDao;

    public function __construct() {
        $this->emailNotificationDao = new EmailNotificationDao();
    }

    public function getEmailNotificationDao() {
        return $this->emailNotificationDao;
    }

    public function setEmailNotificationDao(EmailNotificationDao $emailNotificationDao) {
        $this->emailNotificationDao = $emailNotificationDao;
    }

    public function getEmailNotificationList(){
        return $this->emailNotificationDao->getEmailNotificationList();
    }

    public function updateEmailNotification($toBeUpdatedIds){
       return $this->emailNotificationDao->updateEmailNotification($toBeUpdatedIds);
    }

    public function getEnabledEmailNotificationIdList(){
        return $this->emailNotificationDao->getEnabledEmailNotificationIdList();
    }

    public function getSubscribersByNotificationId($emailNotificationId){
        return $this->emailNotificationDao->getSubscribersByNotificationId($emailNotificationId);
    }

    public function getSubscriberById($subscriberId){
        return $this->emailNotificationDao->getSubscriberById($subscriberId);
    }

    public function deleteSubscribers($subscriberIdList){
        return $this->emailNotificationDao->deleteSubscribers($subscriberIdList);
    }
    
    public function getEmailNotification($id) {
        return $this->emailNotificationDao->getEmailNotification($id);
    }
}

