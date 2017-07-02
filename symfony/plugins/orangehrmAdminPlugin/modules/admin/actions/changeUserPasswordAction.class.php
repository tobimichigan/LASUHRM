<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class changeUserPasswordAction extends sfAction {

    public function execute($request) {

        $this->form = new ChangeUserPasswordForm();

        $this->userId = $this->getUser()->getAttribute('user')->getUserId();

        $systemUserService = new SystemUserService();

        $systemUser = $systemUserService->getSystemUser($this->userId);
        $this->username = $systemUser->getName();

        if ($this->getUser()->hasFlash('templateMessage')) {
            $this->templateMessage = $this->getUser()->getFlash('templateMessage');
        }

        if ($request->isMethod('post')) {

            $this->form->bind($request->getParameter($this->form->getName()));

            if ($this->form->isValid()) {

                if (!$systemUserService->isCurrentPassword($this->userId, $this->form->getValue('currentPassword'))) {

                    $this->getUser()->setFlash('warning', __('Current Password Is Wrong'));
                    $this->redirect('admin/changeUserPassword');
                } else {
                    $this->form->save();
                    $this->getUser()->setFlash('success', __('Successfully Changed'));
                    $this->redirect('admin/changeUserPassword');
                }
            }
        }
    }

}