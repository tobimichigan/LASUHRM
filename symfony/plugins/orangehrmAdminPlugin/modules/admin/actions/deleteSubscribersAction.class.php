<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class deleteSubscribersAction extends sfAction {

    private $emailNotoficationService;

    public function getEmailNotificationService() {
        if (is_null($this->emailNotoficationService)) {
            $this->emailNotoficationService = new EmailNotificationService();
            $this->emailNotoficationService->setEmailNotificationDao(new EmailNotificationDao());
        }
        return $this->emailNotoficationService;
    }

    public function execute($request) {

        $toBeDeletedIds = $request->getParameter('chkSelectRow');

        $notificationId = $this->getUser()->getAttribute('notificationId');
        $this->getEmailNotificationService()->deleteSubscribers($toBeDeletedIds);
        $this->getUser()->setFlash('success', __(TopLevelMessages::DELETE_SUCCESS));
        $this->redirect('admin/saveSubscriber?notificationId='.$notificationId);
    }

}

