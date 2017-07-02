<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */
class SubscriberForm extends BaseForm {

    private $emailNotoficationService;
    private $notificationId;

    public function getEmailNotificationService() {
        if (is_null($this->emailNotoficationService)) {
            $this->emailNotoficationService = new EmailNotificationService();
            $this->emailNotoficationService->setEmailNotificationDao(new EmailNotificationDao());
        }
        return $this->emailNotoficationService;
    }

    public function configure() {

        $this->notificationId = $this->getOption('notificationId');

        $this->setWidgets(array(
            'subscriberId' => new sfWidgetFormInputHidden(),
            'name' => new sfWidgetFormInputText(),
             'email' => new sfWidgetFormInputText()
        ));

        $this->setValidators(array(
            'subscriberId' => new sfValidatorNumber(array('required' => false)),
            'name' => new sfValidatorString(array('required' => true, 'max_length' => 100)),
            'email' => new sfValidatorEmail(array('required' => true, 'max_length' => 100, 'trim' => true))
        ));

        $this->widgetSchema->setNameFormat('subscriber[%s]');
    }

    public function save() {

        $subscriberId = $this->getValue('subscriberId');
        if (!empty($subscriberId)) {
            $subscriber = $this->getEmailNotificationService()->getSubscriberById($subscriberId);
        } else {
            $subscriber = new EmailSubscriber();
        }
        $subscriber->setNotificationId($this->notificationId);
        $subscriber->setName($this->getValue('name'));
        $subscriber->setEmail($this->getValue('email'));
        $subscriber->save();
    }

    public function getSubscriberListForNotificationAsJson() {

        $list = array();
        $subscriberList = $this->getEmailNotificationService()->getSubscribersByNotificationId($this->notificationId);
        foreach ($subscriberList as $subscriber) {
            $list[] = array('id' => $subscriber->getId(), 'email' => $subscriber->getEmail());
        }
        return json_encode($list);
    }

}

