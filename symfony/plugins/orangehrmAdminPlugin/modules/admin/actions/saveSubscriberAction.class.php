<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class saveSubscriberAction extends sfAction {

    private $emailNotoficationService;

    public function getEmailNotificationService() {
        if (is_null($this->emailNotoficationService)) {
            $this->emailNotoficationService = new EmailNotificationService();
            $this->emailNotoficationService->setEmailNotificationDao(new EmailNotificationDao());
        }
        return $this->emailNotoficationService;
    }

    public function setForm(sfForm $form) {
        if (is_null($this->form)) {
            $this->form = $form;
        }
    }

    public function execute($request) {
        
        /* For highlighting corresponding menu item */
        $request->setParameter('initialActionName', 'viewEmailNotification');

        $this->notificationId = $request->getParameter('notificationId');
        $this->getUser()->setAttribute('notificationId', $this->notificationId);
        $usrObj = $this->getUser()->getAttribute('user');
        if (!$usrObj->isAdmin()) {
            $this->redirect('pim/viewPersonalDetails');
        }

        $values = array('notificationId' => $this->notificationId);
        $this->setForm(new SubscriberForm(array(), $values));

        $subscriberList = $this->getEmailNotificationService()->getSubscribersByNotificationId($this->notificationId);
        $notification = $this->getEmailNotificationService()->getEmailNotification($this->notificationId);
        $this->_setListComponent($subscriberList, $notification->getName());
        $params = array();
        $this->parmetersForListCompoment = $params;

        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter($this->form->getName()));
            if ($this->form->isValid()) {
                $this->form->save();
                $this->getUser()->setFlash('success', __(TopLevelMessages::SAVE_SUCCESS));
                $this->redirect('admin/saveSubscriber?notificationId='.$this->notificationId);
            }
        }
    }

    private function _setListComponent($subscriberList, $notificationName) {

        $configurationFactory = new SubscriberHeaderFactory();
        $runtimeDefinitions = array('title' => __('Subscribers') . ' : ' . __($notificationName));
        $configurationFactory->setRuntimeDefinitions($runtimeDefinitions);
        
        ohrmListComponent::setConfigurationFactory($configurationFactory);
        ohrmListComponent::setListData($subscriberList);
    }

}

